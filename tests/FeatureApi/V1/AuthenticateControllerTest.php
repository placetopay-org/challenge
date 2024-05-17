<?php

namespace Tests\FeatureApi\V1;

use App\Constants\Brands;
use App\Helpers\CardNumber;
use App\Helpers\Truncator\TruncatorHelper;
use App\Mocks\CreditCardCases;
use App\Models\Cardholder;
use App\Models\DocumentType;
use App\Models\Email;
use App\Models\Franchise;
use App\Models\PhoneType;
use App\Models\Transaction;
use App\Notifications\BinOutOfRangeNotification;
use App\ThreeDS\Exceptions\Factories\MissingArrayKeyException;
use App\ThreeDS\Services\CardholderInfo\Constants\CardholderPhoneType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\DeviceChannel;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\ErrorCode;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageCategory;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageType;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageVersion;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\ThreeDSComponent;
use PlacetoPay\ThreeDsSecureBase\Constants\Versions\V220\ThreeDSRequestorChallengeIndicator;
use PlacetoPay\ThreeDsSecureBase\Constants\Versions\V220\TransactionStatus;
use PlacetoPay\ThreeDsSecureBase\Constants\Versions\V220\TransactionStatusReason;
use Symfony\Component\HttpFoundation\Request;
use Tests\Concerns\HasCertificates;
use Tests\Concerns\HasFranchises;
use Tests\Concerns\HasIssuerCardRange;
use Tests\Concerns\ProcessingFlows\HasSampleDataBrw;
use Tests\FieldsProviderTrait;
use Tests\TestCase;
use Tests\Unit\FraudControl\Rules\Concerns\HasTestRule;
use Tests\Unit\ProcessingFlows\Concerns\HasIssuerSetting;
use Tests\Unit\ProcessingFlows\Concerns\HasTestCountry;
use Tests\Unit\ProcessingFlows\Concerns\HasTestDocumentType;
use Tests\Unit\ProcessingFlows\Concerns\HasTestIssuer;
use Tests\Unit\ProcessingFlows\Concerns\HasTestPhoneType;

class AuthenticateControllerTest extends TestCase
{
    use FieldsProviderTrait;
    use RefreshDatabase;
    use HasTestIssuer;
    use HasTestCountry;
    use HasTestPhoneType;
    use HasTestDocumentType;
    use HasFranchises;
    use HasIssuerSetting;
    use HasIssuerCardRange;
    use HasSampleDataBrw;
    use HasTestRule;
    use HasCertificates;

    public const TEST_MESSAGE_TYPE = MessageType::AREQ;
    public const URL_AUTHENTICATE = 'api/v1/authenticate';
    public const CONTENT_TYPE = ['Content-Type' => 'application/json;charset=UTF-8'];
    public const CARD_NUMBER = '4005580000000040';
    protected Franchise $franchise;

    private PhoneType $workPhoneType;

    private PhoneType $mobilePhoneType;

    protected string $cardNumber;
    protected DocumentType $documentType;

    public function setUp(): void
    {
        parent::setUp();
        $this->seedData();
    }

    /**
     * @test
     * @dataProvider messageVersionProvider
     * @param string $version
     */
    public function returnsAnErrorMessageWhenMessageTypeIsNotRecognised(string $version): void
    {
        $data['messageVersion'] = $version;
        $data['messageType'] = 'ARRR';
        $data['deviceChannel'] = DeviceChannel::APP;
        $data['messageCategory'] = MessageCategory::PA;
        $data['acctNumber'] = self::CARD_NUMBER;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'messageType' => MessageType::ERRO,
            'errorCode' => ErrorCode::ERROR_MESSAGE_RECEIVED_INVALID,
            'errorDescription' => trans('error.threeds.description.message_type_is_not'),
            'errorDetail' => trans('error.threeds.detail.message_type_is_not'),
        ]);
        $this->assertDatabaseCount('transactions', 0);
    }

    /**
     * @test
     */
    public function returnsAnErrorMessageWhenMessageVersionIsMissing(): void
    {
        $data['messageVersion'] = null;
        $data['messageType'] = MessageType::AREQ;
        $data['deviceChannel'] = DeviceChannel::APP;
        $data['messageCategory'] = MessageCategory::PA;
        $data['acctNumber'] = self::CARD_NUMBER;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'messageType' => MessageType::ERRO,
            'errorCode' => ErrorCode::REQUIRED_DATA_ELEMENT_MISSING,
            'errorDescription' => trans('error.threeds.description.required_data_element_missing'),
            'errorDetail' => trans('error.threeds.detail.data_element_is_invalid', ['elements' => 'messageVersion']),

        ]);
        $this->assertNull(Transaction::first());
    }

    /**
     * @test
     */
    public function returnsAnErrorMessageWhenMessageVersionIsNotRecognised(): void
    {
        $data['messageVersion'] = '1.5.0';
        $data['messageType'] = MessageType::AREQ;
        $data['messageType'] = MessageType::AREQ;
        $data['deviceChannel'] = DeviceChannel::APP;
        $data['messageCategory'] = MessageCategory::PA;
        $data['acctNumber'] = self::CARD_NUMBER;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'messageType' => MessageType::ERRO,
            'errorCode' => ErrorCode::MESSAGE_VERSION_NUMBER_NOT_SUPPORTED,
            'errorDescription' => trans('error.threeds.description.message_version_is_invalid'),
            'errorDetail' => trans('error.threeds.detail.message_version_is_invalid', ['messageVersionValid' => MessageVersion::V_220]),

        ]);
        $this->assertNull(Transaction::first());
    }

    /**
     * @test
     * @dataProvider messageVersionProvider
     * @param string $version
     */
    public function returnsAnErrorMessageWhenMessageTypeIsRecognisedButIsInappropriate(string $version): void
    {
        $data['messageVersion'] = $version;
        $data['messageType'] = MessageType::CREQ;
        $data['acctNumber'] = self::CARD_NUMBER;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'messageType' => MessageType::ERRO,
            'errorCode' => ErrorCode::REQUIRED_DATA_ELEMENT_MISSING,
        ]);
        $this->assertNull(Transaction::first());
    }

    /** @test */
    public function returnsAnErrorMessageWhenMessageVersionIsInvalid(): void
    {
        $data['messageVersion'] = '2.0.0';
        $data['acctNumber'] = self::CARD_NUMBER;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'messageType' => MessageType::ERRO,
            'errorCode' => ErrorCode::ERROR_MESSAGE_RECEIVED_INVALID,
        ]);
        $this->assertNull(Transaction::first());
    }

    /**
     * @test
     * @dataProvider messageVersionProvider
     * @param string $version
     */
    public function returnsAnErrorMessageWhenRequestHasInvalidFields(string $version): void
    {
        $data['messageVersion'] = $version;
        $data['threeDSRequestorAuthenticationInd'] = 'Y';
        $data['acctNumber'] = self::CARD_NUMBER;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'messageType' => MessageType::ERRO,
            'errorCode' => ErrorCode::REQUIRED_DATA_ELEMENT_MISSING,
        ]);
        $this->assertNull(Transaction::first());
    }

    /**
     * @test
     * @dataProvider messageVersionProvider
     * @param string $version
     * @throws MissingArrayKeyException
     */
    public function returnsAResMessageWhenRequestIsCorrect(string $version): void
    {
        $data = $this->createAReq([
            'acctNumber' => $this->cardNumber,
            'messageVersion' => $version,
        ])->toArray();

        $this->createCardholderInfoServiceSetting($this->issuer);
        $this->createOAuthServiceSetting($this->issuer);

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['messageType' => MessageType::ARES]);

        $transaction = Transaction::first();
        $this->assertEquals($data['threeDSServerTransID'], $transaction->threeds_server_trans_id);
        $this->assertEquals($data['deviceChannel'], $transaction->device_channel);
        $this->assertNotNull($transaction->card_id);

        $cardholder = Cardholder::first();

        $this->assertEquals('John Doe', $cardholder->name);
        $this->assertEquals($this->documentType->id, $cardholder->document_type_id);
        $this->assertEquals('2468865355', $cardholder->document);
        $this->assertEquals($response['acsOperatorID'], $this->franchise->acs_operator_id);

        Email::all()->each(function ($item) {
            $this->assertTrue(in_array($item->email, ['john.doe@examples.org', 'john.doe@laravel.com']));
        });

        $cardholder->emails->each(function ($item) {
            $this->assertTrue(in_array($item->email, ['john.doe@examples.org', 'john.doe@laravel.com']));
        });

        $this->assertDatabaseHas('phones', [
            'phone' => '3009998877',
            'country_id' => $this->country->id,
            'phone_type_id' => $this->mobilePhoneType->id,
        ]);

        $this->assertDatabaseHas('phones', [
            'phone' => '5556677',
            'country_id' => $this->country->id,
            'phone_type_id' => $this->workPhoneType->id,
        ]);

        $cardholder->phones->each(function ($item) {
            $this->assertTrue(in_array($item->phone, ['3009998877', '5556677']));
        });
    }

    /**
     * Required newsletter AI11604.
     * @test
     * @dataProvider messageVersionProvider
     * @param string $version
     * @throws MissingArrayKeyException
     */
    public function returnsAResMessageWithTransStatusReason13WhenCardHolderIsNotEnrolled(string $version): void
    {
        $data = $this->createAReq([
            'acctNumber' => CreditCardCases::CARDHOLDER_NOT_ENROLLED,
            'messageVersion' => $version,
        ])->toArray();

        $this->createCardholderInfoServiceSetting($this->issuer);
        $this->createOAuthServiceSetting($this->issuer);

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['messageType' => MessageType::ARES]);
        $response->assertJson(['transStatusReason' => TransactionStatusReason::CARDHOLDER_NOT_ENROLLED_IN_SERVICE]);
        $response->assertJson(['transStatus' => TransactionStatus::NOT_AUTHENTICATED]);

        $transaction = Transaction::first();
        $this->assertEquals($data['threeDSServerTransID'], $transaction->threeds_server_trans_id);
        $this->assertEquals($data['deviceChannel'], $transaction->device_channel);
    }

    /**
     * @test
     * @dataProvider messageVersionProvider
     * @param string $version
     * @throws MissingArrayKeyException
     */
    public function returnsAnErrorMessageAndErrorMessageTypeWhenRequestNotHasDeviceChannel(string $version): void
    {
        $data = $this->createAReq(['acctNumber' => $this->cardNumber])->toArray();
        $data['messageVersion'] = $version;
        $data['deviceChannel'] = '';
        $data['threeDSRequestorAuthenticationInd'] = 'Y';

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'messageType' => MessageType::ERRO,
            'errorCode' => ErrorCode::REQUIRED_DATA_ELEMENT_MISSING,
        ]);
        $response->assertJsonStructure(['errorMessageType']);

        $this->assertNull(Transaction::first());
    }

    /**
     * @test
     * @dataProvider whitelistingDataEntryInvalidProvider
     * @param string $whitListStatus
     * @throws MissingArrayKeyException
     */
    public function returnsAnErrorMessageWhenWhiteListStatusOnV210(string $whitListStatus): void
    {
        $data = $this->createAReq(['acctNumber' => $this->cardNumber])->toArray();
        $data['messageVersion'] = MessageVersion::V_210;
        $data['whiteListStatus'] = $whitListStatus;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['messageType' => MessageType::ERRO]);
        $response->assertJson(['errorComponent' => ThreeDSComponent::ACS_COMPONENT]);
        $response->assertJson(['errorCode' => ErrorCode::FORMAT_OF_ELEMENTS_IS_INVALID]);
        $response->assertJsonStructure(['errorDescription']);
        $response->assertJsonStructure(['errorDetail']);
        $response->assertJsonStructure(['messageVersion']);

        $this->assertNull(Transaction::first());
    }

    /**
     * @test
     * @dataProvider whitelistingDataEntryInvalidProvider
     * @param string $whitListStatus
     * @throws MissingArrayKeyException
     */
    public function returnsAnErrorMessageWhenWhiteListStatusOnV220(string $whitListStatus): void
    {
        $data = $this->createAReq(['acctNumber' => $this->cardNumber])->toArray();
        $data['messageVersion'] = MessageVersion::V_220;
        $data['whiteListStatus'] = $whitListStatus;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['messageType' => MessageType::ERRO]);
        $response->assertJson(['errorComponent' => ThreeDSComponent::ACS_COMPONENT]);
        $response->assertJson(['errorCode' => ErrorCode::FORMAT_OF_ELEMENTS_IS_INVALID]);
        $response->assertJsonStructure(['errorDescription']);
        $response->assertJsonStructure(['errorDetail']);
        $response->assertJsonStructure(['messageVersion']);

        $this->assertNull(Transaction::first());
    }

    /** @test */
    public function itReturnsInformationOnlyStatusWhenThreeDsRequestorChallengeIndIsDataShareOnly(): void
    {
        $data = $this->createAReq(['acctNumber' => $this->cardNumber])->toArray();
        $data['messageVersion'] = MessageVersion::V_220;
        $data['threeDSRequestorChallengeInd'] = ThreeDSRequestorChallengeIndicator::NO_CHALLENGE_REQUESTED_DATA_SHARED_ONLY;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $aRes = json_decode($response->getContent(), true);

        $this->assertEquals(TransactionStatus::INFORMATION_ONLY, $aRes['transStatus']);

        $transaction = Transaction::first();
        $this->assertEquals($data['threeDSServerTransID'], $transaction->threeds_server_trans_id);
        $this->assertEquals($data['deviceChannel'], $transaction->device_channel);
        $this->assertNotNull($transaction->card_id);
    }

    /** @test */
    public function returnsAnErrorMessageAndErrorMessageTypeWhenRequestHasPurchaseExponent(): void
    {
        $data = $this->createAReq(['acctNumber' => $this->cardNumber])->toArray();
        $data['purchaseExponent'] = 4;
        $data['messageVersion'] = MessageVersion::V_220;
        $data['threeDSRequestorChallengeInd'] = ThreeDSRequestorChallengeIndicator::NO_CHALLENGE_REQUESTED_DATA_SHARED_ONLY;

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['messageType' => MessageType::ERRO]);
        $response->assertJsonStructure(['errorMessageType']);

        $this->assertNull(Transaction::first());
    }

    /**
     * @test
     * @dataProvider messageVersionProvider
     * @param string $version
     * @throws MissingArrayKeyException
     */
    public function returnsAnErrorMessageWhenTheIssuerIsNotEnabled(string $version): void
    {
        $data = $this->createAReq([
            'acctNumber' => $this->cardNumber,
            'messageVersion' => $version,
        ])->toArray();

        $this->createCardholderInfoServiceSetting($this->issuer);
        $this->issuer->toggle();

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'messageType' => MessageType::ERRO,
            'errorCode' => ErrorCode::ACCESS_DENIED,
            'errorComponent' => ThreeDSComponent::ACS_COMPONENT,
            'errorDescription' => trans('error.threeds.description.issuer_not_enabled'),
            'errorDetail' => trans('error.threeds.detail.issuer_not_enabled'),
            'errorMessageType' => MessageType::AREQ,
            'messageVersion' => $version,
        ]);

        $this->assertDatabaseCount('transactions', 0);
    }

    /**
     * @test
     * @param array $requestFields
     * @dataProvider invalidUuidProvider
     * @throws MissingArrayKeyException
     */
    public function itValidatesUuidFormat(array $requestFields): void
    {
        $request = $this->createAReq(array_merge([
            'acctNumber' => $this->cardNumber,
            'messageVersion' => MessageVersion::V_220,
        ], $requestFields))->toArray();

        $this->createCardholderInfoServiceSetting($this->issuer);

        $response = $this->json(
            Request::METHOD_POST,
            self::URL_AUTHENTICATE,
            $request,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'messageType' => MessageType::ERRO,
                'errorCode' => ErrorCode::TRANSACTION_ID_NOT_RECOGNISED,
                'errorComponent' => ThreeDSComponent::ACS_COMPONENT,
                'errorDescription' => trans('error.threeds.description.invalid_uuid'),
                'errorDetail' => trans('error.threeds.detail.invalid_uuid', [
                    'uuid' => implode(', ', array_keys($requestFields)),
                ]),
                'errorMessageType' => MessageType::AREQ,
                'messageVersion' => MessageVersion::V_220,
            ]);

        $this->assertDatabaseCount('transactions', 0);
    }

    /**
     * @test
     * @param array $requestFields
     * @param array $transactionFields
     * @dataProvider duplicateUuidProvider
     * @throws MissingArrayKeyException
     */
    public function itValidatesDuplicatesUuid(array $requestFields, array $transactionFields): void
    {
        $request = $this->createAReq(array_merge([
            'acctNumber' => $this->cardNumber,
            'messageVersion' => MessageVersion::V_220,
        ], $requestFields))->toArray();

        $transaction = $this->createTransaction(
            MessageVersion::V_220,
            $transactionFields,
            $request
        );

        $this->createCardholderInfoServiceSetting($this->issuer);

        $response = $this->json(
            Request::METHOD_POST,
            self::URL_AUTHENTICATE,
            $request,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'messageType' => MessageType::ERRO,
                'errorCode' => ErrorCode::TRANSACTION_ID_NOT_RECOGNISED,
                'errorComponent' => ThreeDSComponent::ACS_COMPONENT,
                'errorDescription' => trans('error.threeds.description.invalid_uuid'),
                'errorDetail' => trans('error.threeds.detail.duplicate_uuid', [
                    'uuid' => implode(', ', array_keys($requestFields)),
                ]),
                'errorMessageType' => MessageType::AREQ,
                'messageVersion' => MessageVersion::V_220,
            ]);

        $this->assertDatabaseCount('transactions', 1);
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
        ]);
    }

    /**
     * @test
     * @param string $invalid
     * @param string $duplicated
     * @param array $requestFields
     * @param array $transactionFields
     * @dataProvider invalidAndDuplicateUuidProvider
     * @throws MissingArrayKeyException
     */
    public function itValidatesFormatAndDuplicatesUuid(
        string $invalid,
        string $duplicated,
        array $requestFields,
        array $transactionFields
    ): void {
        $request = $this->createAReq(array_merge([
            'acctNumber' => $this->cardNumber,
            'messageVersion' => MessageVersion::V_220,
        ], $requestFields))->toArray();

        $transaction = $this->createTransaction(
            MessageVersion::V_220,
            $transactionFields,
            $request
        );

        $this->createCardholderInfoServiceSetting($this->issuer);

        $response = $this->json(
            Request::METHOD_POST,
            self::URL_AUTHENTICATE,
            $request,
            self::CONTENT_TYPE,
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'messageType' => MessageType::ERRO,
                'errorCode' => ErrorCode::TRANSACTION_ID_NOT_RECOGNISED,
                'errorComponent' => ThreeDSComponent::ACS_COMPONENT,
                'errorDescription' => trans('error.threeds.description.invalid_uuid'),
                'errorDetail' => trans('error.threeds.detail.invalid_uuid', ['uuid' => $invalid])
                    . '. ' . trans('error.threeds.detail.duplicate_uuid', ['uuid' => $duplicated]),
                'errorMessageType' => MessageType::AREQ,
                'messageVersion' => MessageVersion::V_220,
            ]);

        $this->assertDatabaseCount('transactions', 1);
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
        ]);
    }

    /**
     * @test
     * @dataProvider messageVersionProvider
     * @param string $version
     */
    public function returnsErrorResponseOnDisabledIssuer(string $version): void
    {
        $data = $this->createAReq([
            'acctNumber' => $this->cardNumber,
            'messageVersion' => $version,
        ])->toArray();

        $this->createCardholderInfoServiceSetting($this->issuer);
        $this->createOAuthServiceSetting($this->issuer);

        $this->issuer->update(['enabled_at' => null]);

        $response = $this->json(
            'POST',
            self::URL_AUTHENTICATE,
            $data,
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );

        $response->assertOk()
            ->assertSee(trans('common.errors_encountered'));
    }

    /**
     * @test
     * @dataProvider brandProvider
     */
    public function itSavesInvalidTransactionOnCardRangeNotEnrolled(string $brand): void
    {
        Notification::fake();

        $brand = Brands::from($brand);

        [$acctNumber, $method] = match ($brand) {
            Brands::VISA => [
                $this->faker->creditCardNumber('Visa'),
                'createVisaBrand',
            ],
            Brands::MASTERCARD => [
                $this->faker->creditCardNumber('MasterCard'),
                'createMasterCardBrand',
            ],
            Brands::DISCOVER => [
                $this->faker->creditCardNumber('Discover Card'),
                'createDiscoverBrand',
            ],
            Brands::DINERS_CLUB => [
                '3616921528000000',
                'createDinersClubBrand',
            ],
            Brands::ELO => [
                '6509522854305394',
                'createEloBrand',
            ],
        };

        $franchise = Franchise::where('brand', $brand->value)->firstOr(fn () => $this->{$method}());

        $data = $this->createAReq([
            'acctNumber' => $acctNumber,
        ])->toArray();

        $this->createCardholderInfoServiceSetting($this->issuer);
        $this->createOAuthServiceSetting($this->issuer);

        $response = $this->postJson(
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertOk()
            ->assertJson([
                'messageVersion' => MessageVersion::V_220,
                'messageType' => MessageType::ERRO,
                'errorCode' => ErrorCode::TRANSACTION_DATA_NOT_VALID,
                'errorComponent' => ThreeDSComponent::ACS_COMPONENT,
                'errorDescription' => trans('error.threeds.description.transaction_data_not_valid'),
                'errorDetail' => trans('error.threeds.detail.transaction_data_not_valid'),
                'errorMessageType' => MessageType::AREQ,
                'dsTransID' => $data['dsTransID'],
                'threeDSServerTransID' => $data['threeDSServerTransID'],
            ]);

        $acctNumber = TruncatorHelper::truncate(['acctNumber' => $data['acctNumber']], ['acctNumber']);
        $email = TruncatorHelper::truncate(['email' => $data['email']], ['email']);

        $this->assertDatabaseHas('invalid_transactions', [
            'threeds_server_trans_id' => $data['threeDSServerTransID'],
            'ds_trans_id' => $data['dsTransID'],
            'request->acctNumber' => $acctNumber['acctNumber'],
            'request->email' => $email['email'],
            'response->errorCode' => ErrorCode::TRANSACTION_DATA_NOT_VALID,
            'response->errorDetail' => trans('error.threeds.detail.transaction_data_not_valid'),
            'franchise_id' => $franchise->id,
        ]);

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            function (BinOutOfRangeNotification $notification) use ($data) {
                return str_contains(
                    $notification->toMail($notification)->introLines[0],
                    (new CardNumber($data['acctNumber']))->bin()
                );
            }
        );
    }

    /**
     * @test
     */
    public function itSavesInvalidTransactionOnInvalidMessage(): void
    {
        $acctNumber = $this->faker->creditCardNumber('Visa');

        $data = $this->createAReq([
            'acctNumber' => $acctNumber,
        ])->toArray();

        $data['email'] = 'invalid_email';

        // $this->createCardholderInfoServiceSetting($this->issuer);
        // $this->createOAuthServiceSetting($this->issuer);

        $this->assignCardRange($acctNumber);

        $response = $this->postJson(
            self::URL_AUTHENTICATE,
            $data,
            self::CONTENT_TYPE,
        );

        $response->assertOk()
            ->assertJson([
                'messageVersion' => MessageVersion::V_220,
                'messageType' => MessageType::ERRO,
                'errorCode' => ErrorCode::FORMAT_OF_ELEMENTS_IS_INVALID,
                'errorComponent' => ThreeDSComponent::ACS_COMPONENT,
                'errorDescription' => trans('error.threeds.description.data_element_is_invalid'),
                'errorDetail' => trans('error.threeds.detail.data_element_is_invalid', ['elements' => 'email']),
                'errorMessageType' => MessageType::AREQ,
            ]);

        $acctNumber = TruncatorHelper::truncate(['acctNumber' => $data['acctNumber']], ['acctNumber']);

        $this->assertDatabaseHas('invalid_transactions', [
            'threeds_server_trans_id' => $data['threeDSServerTransID'],
            'ds_trans_id' => $data['dsTransID'],
            'request->acctNumber' => $acctNumber['acctNumber'],
            'request->email' => '',
            'response->errorDescription' => trans('error.threeds.description.data_element_is_invalid'),
            'response->errorDetail' => trans('error.threeds.detail.data_element_is_invalid', ['elements' => 'email']),
            'franchise_id' => $this->franchise->id,
        ]);
    }

    public static function invalidUuidProvider(): array
    {
        return [
            'invalid ds_trans_id' => [
                ['dsTransID' => 'wrong'],
            ],
            'invalid threeds_server_trans_id' => [
                ['threeDSServerTransID' => 'wrong'],
            ],
            'invalid ds_trans_id and threeds_server_trans_id' => [
                ['dsTransID' => 'wrong', 'threeDSServerTransID' => 'wrong'],
            ],
        ];
    }

    public static function duplicateUuidProvider(): array
    {
        $uuid = '16bf577d-82d8-43bc-9173-feb53d500ad3';

        return [
            'duplicate ds_trans_id' => [
                ['dsTransID' => $uuid],
                ['ds_trans_id' => $uuid],
            ],
            'duplicate threeds_server_trans_id' => [
                ['threeDSServerTransID' => $uuid],
                ['threeds_server_trans_id' => $uuid],
            ],
            'duplicate ds_trans_id and threeds_server_trans_id' => [
                ['dsTransID' => $uuid, 'threeDSServerTransID' => $uuid],
                ['ds_trans_id' => $uuid, 'threeds_server_trans_id' => $uuid],
            ],
        ];
    }

    public static function invalidAndDuplicateUuidProvider(): array
    {
        $uuid = '16bf577d-82d8-43bc-9173-feb53d500ad3';

        return [
            'wrong ds_trans_id and duplicate threeds_server_trans_id' => [
                'invalid' => 'dsTransID',
                'duplicated' => 'threeDSServerTransID',
                'requestFields' => ['dsTransID' => 'wrong', 'threeDSServerTransID' => $uuid],
                'transactionFields' => ['threeds_server_trans_id' => $uuid],
            ],
            'duplicate ds_trans_id and wrong threeds_server_trans_id' => [
                'invalid' => 'threeDSServerTransID',
                'duplicated' => 'dsTransID',
                'requestFields' => ['dsTransID' => $uuid, 'threeDSServerTransID' => 'wrong'],
                'transactionFields' => ['ds_trans_id' => $uuid],
            ],
        ];
    }

    public static function brandProvider(): array
    {
        return [
            'visa' => [Brands::VISA->value],
            'mastercard' => [Brands::MASTERCARD->value],
            'discover' => [Brands::DISCOVER->value],
            'diners club' => [Brands::DINERS_CLUB->value],
            'elo' => [Brands::ELO->value],
        ];
    }

    private function seedData(): void
    {
        $this->cardNumber = self::CARD_NUMBER;
        $this->issuer = $this->createIssuer();
        $this->country = $this->createCountry(['dial_codes' => [57]]);
        $this->documentType = $this->createDocumentType($this->country->id);
        $this->mobilePhoneType = $this->createPhoneType(CardholderPhoneType::MOBILE);
        $this->workPhoneType = $this->createPhoneType(CardholderPhoneType::WORK);
        $this->franchise = $this->createVisaBrand();
        $this->assignCardRange($this->cardNumber);
        $this->createIssuerFranchiseVisa($this->issuer->id, $this->franchise->id);
    }
}
