<?php

namespace App\Services;

use App\Concerns\HasFranchiseForCard;
use App\Constants\Brands;
use App\Events\NewTransactionMessage;
use App\Exceptions\ThreeDSException;
use App\Helpers\Environment;
use App\Helpers\Truncator\TruncatorHelper;
use App\Jobs\UpdateTransactionExtraAttributes;
use App\Jobs\VerifyTransactionWithoutFirstCReq;
use App\Models\Card;
use App\Models\CardRange;
use App\Models\Franchise;
use App\Models\InvalidTransaction;
use App\Models\Issuer;
use App\Models\Transaction;
use App\Notifications\BinOutOfRangeNotification;
use App\ThreeDS\Constants\Responses;
use App\ThreeDS\Constants\Step;
use App\ThreeDS\Encryption\Encrypter;
use App\ThreeDS\Factories\StepFactory;
use App\ThreeDS\Handlers\MessageErrorHandler;
use App\ThreeDS\Messages\Message;
use App\ThreeDS\Messages\Requests\AReq;
use App\ThreeDS\ProcessingFlows\FlowStep;
use App\ThreeDS\Validators\MessageValidator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\DeviceChannel;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageType;
use PlacetoPay\ThreeDsSecureBase\Constants\Versions\V220\TransactionStatus;
use PlacetoPay\ThreeDsSecureBase\Helpers\Base64Url;

abstract class AuthenticateService
{
    use HasFranchiseForCard;

    private Issuer $issuer;
    protected Request $httpRequest;
    protected Message $response;
    protected string $deviceChannel;
    protected string $messageCategory;
    private string $messageVersion;

    public function __construct(Request $request)
    {
        $this->httpRequest = $request;
        $this->deviceChannel = $request->input('deviceChannel', '');
        $this->messageCategory = $request->input('messageCategory', '');
        $this->messageVersion = $this->httpRequest->input('messageVersion', '');
    }

    public function setIssuer(Issuer $issuer): void
    {
        $this->issuer = $issuer;
    }

    public function response()
    {
        return response()->{Responses::JSON}($this->response);
    }

    /**
     * @throws ThreeDSException
     */
    public function execute(): self
    {
        $aReq = $this->getAReq();

        if (!$this->validateCardRange() || !$this->isValidMessage($aReq)) {
            return $this;
        }

        $this->validateIssuerStatus($this->httpRequest);
        $this->validateMessageExtensionForUl($this->httpRequest);

        $aReq = $this->getMessageBuilderAReq($aReq);

        $this->validateAcctNumber($this->httpRequest);

        if (DeviceChannel::isApp($this->deviceChannel)) {
            try {
                Encrypter::createSharedSecretFromECKey(Encrypter::createEphemeral(), [
                    'alg' => 'ECDH-ES',
                    'apv' => Base64Url::encode($this->httpRequest->input('sdkReferenceNumber')),
                    'epk' => $this->httpRequest->input('sdkEphemPubKey'),
                ]);
            } catch (\Exception $e) {
                $this->response = (new MessageErrorHandler(
                    $this->httpRequest,
                    MessageType::AREQ
                ))->elementFormatIsInvalidError(['sdkEphemPubKey', 'sdkReferenceNumber'])->error();

                return $this;
            }
        }

        $transaction = $this->createNewTransaction($aReq);

        if ($transaction->isBrw() && $aReq->browserIP) {
            dispatch(new UpdateTransactionExtraAttributes($transaction, $aReq->browserIP));
        }

        $this->response = $this->authenticationSteps($aReq, $transaction)->response();

        $transaction->setTransactionDataFromResponse($this->response);

        event(new NewTransactionMessage($transaction, $this->response));

        $this->dispatchAuthenticationServiceEvents($transaction);

        return $this;
    }

    protected function isAResMessageType(): bool
    {
        return MessageType::ARES === $this->response->messageType;
    }

    protected function dispatchAuthenticationServiceEvents(Transaction $transaction): void
    {
        $this->dispatchResultRequestSenderWithoutCReqEvent($transaction);
    }

    /**
     * @param Request $request
     * @throws ThreeDSException
     */
    protected function validateMessageExtensionForUl(Request $request): void
    {
        if (Environment::isUlSelfTest()) {
            $messageExtension = $request->input('messageExtension.0');

            if (!is_null($messageExtension) && $criticalityIndicator = $messageExtension['criticalityIndicator']) {
                $messageErrorHandler = new MessageErrorHandler($request, MessageType::AREQ);
                $error = $messageErrorHandler->messageExtensionElementIsIgnoredByUL($criticalityIndicator)->error();

                throw ThreeDSException::forErrorMessage($error);
            }
        }
    }

    protected function validateIssuerStatus(Request $request): void
    {
        if ($this->issuer->isDisabled()) {
            $error = (new MessageErrorHandler($request, MessageType::AREQ))->issuerNotEnabled()->error();

            throw ThreeDSException::forErrorMessage($error);
        }
    }

    protected function getAReq(): AReq
    {
        return new AReq($this->httpRequest->toArray());
    }

    private function isValidMessage(AReq $aReq): bool
    {
        return MessageValidator::make(
            $aReq,
            function ($validator) {
                $this->response = (new MessageErrorHandler(
                    $this->httpRequest,
                    MessageType::AREQ
                ))->errorMessageFailsRules($validator)->error();

                $this->createInvalidTransaction($this->response);
            },
        );
    }

    /**
     * @param Request $request
     * @throws ThreeDSException
     */
    private function validateAcctNumber(Request $request): void
    {
        if (!$this->franchise) {
            $error = (new MessageErrorHandler($request, MessageType::AREQ))->transactionDataNotValid()->error();

            throw ThreeDSException::forErrorMessage($error);
        }
    }

    /**
     * @throws ThreeDSException
     */
    private function createNewTransaction(Message $message): Transaction
    {
        $card = Card::firstOrCreateByCardNumber($message->acctNumber);

        $transaction = new Transaction();

        $transaction->setTransactionDataFromRequest($message);
        $transaction->setIssuer($this->issuer);
        $transaction->setCard($card);
        $transaction->setFranchise($this->franchise);

        try {
            $transaction->save();
        } catch (QueryException) {
            $error = (new MessageErrorHandler($this->httpRequest, MessageType::AREQ))
                ->duplicateUUID()->error();

            throw ThreeDSException::forErrorMessage($error);
        }

        $transaction->setRelation('card', $card);
        $transaction->setRelation('issuer', $this->issuer);
        $transaction->setRelation('franchise', $this->franchise);

        event(new NewTransactionMessage($transaction, $message));

        return $transaction;
    }

    private function authenticationSteps(Message $aReq, Transaction $transaction): FlowStep
    {
        $step = $this->getFlowStep($aReq);
        $step->setTransaction($transaction);
        $step->addEvents();
        $step->dispatchEvents();

        return $step;
    }

    private function getFlowStep(Message $aReq): FlowStep
    {
        return (new StepFactory(
            Step::AUTHENTICATION[$this->messageVersion][$this->deviceChannel],
            $aReq
        ))->getStep();
    }

    private function dispatchResultRequestSenderWithoutCReqEvent(Transaction $transaction): void
    {
        if ($this->isAResMessageType() && TransactionStatus::isChallengeRequiredStatus($this->response->transStatus)) {
            VerifyTransactionWithoutFirstCReq::dispatch($transaction->acs_trans_id)->delay(now()->addSeconds(30));
        }
    }

    private function getMessageBuilderAReq(AReq $aReq): Message
    {
        return (new $this->messageBuilderAReq($aReq->toArray(), $this->deviceChannel, $this->messageCategory))
            ->toMessage();
    }

    private function validateCardRange(): bool
    {
        $cardRange = CardRange::select('id', 'issuer_id', 'franchise_id')
            ->inRange($this->httpRequest->input('acctNumber'))
            ->with([
                'issuer:id,name,slug,enabled_at',
                'franchise:id,brand,pattern,cavv_algorithm,eci_algorithm,'
                    . 'acs_operator_id,acs_reference_number,enabled_at',
            ])
            ->first();

        if (null === $cardRange) {
            Notification::route('mail', config('placetopay.notification.email'))
                ->notify(new BinOutOfRangeNotification($this->httpRequest->input('acctNumber')));

            $messageErrorHandler = new MessageErrorHandler($this->httpRequest, MessageType::AREQ);
            $error = $messageErrorHandler->transactionDataNotValid()->error();

            $error->dsTransID = $this->httpRequest->input('dsTransID');
            $error->threeDSServerTransID = $this->httpRequest->input('threeDSServerTransID');

            if ($this->httpRequest->input('deviceChannel') === DeviceChannel::APP) {
                $error->sdkTransID = $this->httpRequest->input('sdkTransID');
            }

            $this->createInvalidTransaction($error);

            $this->response = $error;

            return false;
        }

        $this->issuer = $cardRange->issuer;
        $this->franchise = $cardRange->franchise;

        $issuerService = resolve(IssuerService::class);
        $issuerService->setIssuer($cardRange->issuer);

        return true;
    }

    private function createInvalidTransaction(Message $message): void
    {
        $request = TruncatorHelper::truncate($this->httpRequest->all(), ['acctNumber', 'email']);
        $request = Arr::except($request, ['sdkEphemPubKey', 'acsSignedContent']);

        InvalidTransaction::create([
            'acs_trans_id' => Str::uuid()->toString(),
            'threeds_server_trans_id' => $this->httpRequest->input('threeDSServerTransID'),
            'ds_trans_id' => $this->httpRequest->input('dsTransID'),
            'request' => $request,
            'response' => $message->toArray(),
            'franchise_id' => $this->resolveFranchise()?->id,
        ]);
    }

    private function resolveFranchise(): Franchise|null
    {
        $franchise = null;

        foreach ($this->getBrandPatterns() as $brand => $pattern) {
            preg_match("/{$pattern}/", $this->httpRequest->input('acctNumber'), $matches);

            if (!empty($matches)) {
                $franchise = Franchise::where('brand', $brand)->first();
            }

            if ($franchise) {
                break;
            }
        }

        return $franchise;
    }

    private function getBrandPatterns(): array
    {
        $patterns = Brands::getPatterns();

        if (!Environment::isUlSelfTest()) {
            $patterns = Arr::except($patterns, [Brands::UL->value]);
        }

        return $patterns;
    }
}
