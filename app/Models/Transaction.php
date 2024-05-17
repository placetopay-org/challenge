<?php

namespace App\Models;

use App\Concerns\HasPresenter;
use App\Constants\AcsSetting;
use App\Exceptions\CurrencyNotFoundException;
use App\Exceptions\ThreeDSException;
use App\Helpers\Acl\Acl as AclHelper;
use App\Helpers\Amount;
use App\Helpers\ExchangeRateHelper;
use App\Helpers\IssuerSettingHelper;
use App\Helpers\Truncator\Email;
use App\Models\Concerns\HasChallengeStatus;
use App\Models\Concerns\HasTimezonedTimestamps;
use App\Presenters\TransactionPresenter;
use App\ThreeDS\Messages\Message;
use App\ThreeDS\Messages\Requests\AReq;
use App\ThreeDS\Messages\Requests\RReq;
use App\ThreeDS\Messages\Responses\ARes;
use App\ThreeDS\Messages\Responses\CRes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PlacetoPay\Filters\Interfaces\Filterable;
use PlacetoPay\Filters\Traits\HasFilters;
use Placetopay\Metrics\Contracts\ModelMetricContract;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\AcsUiType;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\DeviceChannel;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageCategory;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageType;
use PlacetoPay\ThreeDsSecureBase\Constants\Versions\V220\TransactionStatus;

/**
 * @property mixed acs_trans_id
 * @property mixed device_channel
 * @property mixed message_category
 * @property mixed message_version
 * @property mixed ds_trans_id
 * @property mixed threeds_server_trans_id
 * @property mixed trans_status
 * @property mixed trans_type
 * @property mixed mcc
 * @property mixed acquirer_merchant_id
 * @property mixed acquirer_bin
 * @property mixed email
 * @property mixed purchase_amount
 * @property mixed platform_amount
 * @property mixed sdk_trans_id
 * @property mixed current_message
 * @property string eci
 * @property string authentication_value
 * @property string trans_status_reason
 * @property mixed issuer_id
 * @property mixed id
 * @property string threeds_session_data
 * @property string transaction_message_id
 * @property string cek
 * @property int acs_counter_a_to_s
 * @property int interaction_counter
 * @property int card_id
 * @property int device_id
 * @property string country_id
 * @property string merchant_name
 * @property string ip_address
 * @property int challenge_id
 * @property int franchise_id
 * @property Carbon current_message_created_at
 * @property Challenge|null challenge
 * @property Issuer issuer
 * @property Card card
 */
class Transaction extends Model implements ModelMetricContract, Filterable
{
    use HasPresenter;
    use HasChallengeStatus;
    use HasTimezonedTimestamps;
    use HasFactory;
    use HasFilters;

    private int $filterLimitInDays = 1;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->defaultLimitInDays = 7;
        $this->hasDefaultFilters = true;
    }

    protected $table = 'transactions';

    protected $fillable = [
        'acs_trans_id',
        'sdk_trans_id',
        'ds_trans_id',
        'threeds_server_trans_id',
        'issuer_id',
        'user_id',
        'acquirer_bin',
        'acquirer_merchant_id',
        'mcc',
        'trans_status',
        'current_message',
        'eci',
        'authentication_value',
        'trans_status_reason',
        'trans_type',
        'device_channel',
        'message_category',
        'message_version',
        'currency_id',
        'purchase_amount',
        'platform_amount',
        'card_id',
        'email',
        'device_id',
        'franchise_id',
        'current_message_created_at',
    ];

    protected $casts = [
        'purchase_amount' => 'integer',
    ];

    protected string $presenter = TransactionPresenter::class;

    public function getRouteKeyName(): string
    {
        return 'acs_trans_id';
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TransactionMessage::class);
    }

    public function dispute(): HasOne
    {
        return $this->hasOne(Dispute::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    public function traces(): HasMany
    {
        return $this->hasMany(TransactionTrace::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function franchise(): BelongsTo
    {
        return $this->belongsTo(Franchise::class);
    }

    public function findPreviousSuccessfulTransactionBySameCard(
        string $currentTransactionDate,
        int $monthsNumber
    ): ?self {
        return $this->select(['trans_status', 'threeds_server_trans_id', 'device_id', 'card_id', 'created_at'])
            ->where([
                ['trans_status', TransactionStatus::SUCCESSFUL],
                ['threeds_server_trans_id', '<>', $this->threeds_server_trans_id],
                ['created_at', '>', $this->obtainHistoricDate($currentTransactionDate, $monthsNumber)],
            ])
            ->with(['card' => function ($query) {
                $query->where('hashed', $this->card->hashed)->select('id', 'hashed');
            }])
            ->with(['device:id,fingerprint'])
            ->first();
    }

    public function obtainHistoricDate(string $initialDate, int $monthsNumber)
    {
        return date('Y-m-d H:i:s', strtotime($initialDate . ' - ' . $monthsNumber . ' month'));
    }

    public function findByAcsTransId($acsTransId): ?Model
    {
        return $this->where('acs_trans_id', $acsTransId)
            ->with(['messages' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])->first();
    }

    public function setTransactionDataFromRequest(Message $request): self
    {
        $this->acs_trans_id = Str::uuid();
        $this->sdk_trans_id = $request->sdkTransID ?? null;
        $this->ds_trans_id = $request->dsTransID;
        $this->threeds_server_trans_id = $request->threeDSServerTransID;
        $this->acquirer_bin = $request->acquirerBIN;
        $this->acquirer_merchant_id = $request->acquirerMerchantID;
        $this->mcc = $request->mcc;
        $this->trans_type = $request->transType;
        $this->device_channel = $request->deviceChannel;
        $this->message_category = $request->messageCategory;
        $this->message_version = $request->messageVersion;
        $this->email = $request->email;
        $this->ip_address = $request->browserIP;
        $this->merchant_name = $request->merchantName;
        $this->purchase_amount = $request->purchaseAmount;
        $this->platform_amount = $request->purchaseAmount
            ? $this->setPlatformAmountFromMessage($request)
            : $request->purchaseAmount;

        if ($request->purchaseCurrency) {
            $this->setCurrencyByNumericCode($request->purchaseCurrency);
        }

        if ($request->merchantCountryCode) {
            $this->setCountryByNumericCode($request->merchantCountryCode);
        }

        return $this;
    }

    public function setTransactionDataFromResponse(Message $response): self
    {
        $this->acs_trans_id = $response->acsTransID;
        $this->sdk_trans_id = $response->sdkTransID;
        $this->ds_trans_id = $response->dsTransID;
        $this->threeds_server_trans_id = $response->threeDSServerTransID;
        $this->trans_status = $response->transStatus;
        $this->current_message = $response->messageType;
        $this->eci = $response->eci;
        $this->authentication_value = $response->authenticationValue;
        $this->trans_status_reason = $response->transStatusReason;
        $this->save();

        return $this;
    }

    public function setIssuer(Issuer $issuer): self
    {
        $this->issuer_id = $issuer->id;

        return $this;
    }

    public function setCard(Card $card): self
    {
        $this->card_id = $card->id;

        return $this;
    }

    public static function hasFriction(string $status): bool
    {
        return in_array($status, [
            TransactionStatus::CHALLENGE_REQUIRED,
            TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE,
        ]);
    }

    public function isDecoupledChallenge(): bool
    {
        return TransactionStatus::isChallengeRequiredDecoupleStatus($this->attributes['trans_status']);
    }

    public function isSuccessful(): bool
    {
        return TransactionStatus::isSuccessfulStatus($this->attributes['trans_status']);
    }

    public function setCurrencyByNumericCode(string $numericCode): self
    {
        $currency = $numericCode ? Currency::getCurrenciesCache()->firstWhere('numeric_code', $numericCode) : null;

        if ($currency) {
            $this->currency_id = $currency->id;
        }

        return $this;
    }

    public function setCountryByNumericCode(string $numericCode): self
    {
        $country = $numericCode ? Country::where('numeric_code', $numericCode)->select([
            'id', 'name', 'numeric_code', 'dial_codes', 'alpha_2_code', 'alpha_3_code',
        ])->first() : null;

        if ($country) {
            $this->country_id = $country->id;
        }

        return $this;
    }

    public function setFranchise(Franchise $franchise): self
    {
        $this->franchise_id = $franchise->id;

        return $this;
    }

    public function getAReqAttribute(): AReq
    {
        $message = $this->messages->where('message_type', MessageType::AREQ)->first()->message;

        return new AReq($message->toArray());
    }

    public function getAResAttribute(): ARes
    {
        $aRes = $this->messages->where('message_type', MessageType::ARES)->first();

        if (empty($aRes)) {
            return new ARes([]);
        }

        return new ARes($aRes->message->toArray());
    }

    public function getCResAttribute(): CRes
    {
        $cRes = $this->messages->where('message_type', MessageType::CRES)->first();

        if (empty($cRes)) {
            return new CRes([]);
        }

        return new CRes($cRes->message->toArray());
    }

    public function getRReqAttribute(): RReq
    {
        $rReq = $this->messages->where('message_type', MessageType::RREQ)->first();

        if (empty($rReq)) {
            return new RReq([]);
        }

        return new RReq($rReq->message->toArray());
    }

    public function getTruncatedEmail(): string
    {
        return Email::truncate($this->email);
    }

    /**
     * @param string $messageVersion
     * @return bool
     */
    public function hasSameMessageVersionAs(string $messageVersion): bool
    {
        return $this->message_version === $messageVersion;
    }

    public function updateCurrentMessage(string $messageType): void
    {
        $this->update([
            'current_message' => $messageType,
            'current_message_created_at' => now(),
        ]);
    }

    public function updateTransactionStatus(string $transStatus, string $reason = null): void
    {
        $this->update([
            'trans_status' => $transStatus,
            'trans_status_reason' => $reason,
        ]);
    }

    public function isApp(): bool
    {
        return $this->device_channel === DeviceChannel::APP;
    }

    public function isBrw(): bool
    {
        return $this->device_channel === DeviceChannel::BRW;
    }

    public function isForPayment(): bool
    {
        return $this->message_category === MessageCategory::PA;
    }

    public function getFormattedAmount()
    {
        return ($this->currency->alphabetic_code ?? null)
            ? Amount::format($this->currency->alphabetic_code, $this->purchase_amount)
            : $this->purchase_amount;
    }

    public function getUiType(): ?string
    {
        $acsUiTemplate = $this->aRes->acsRenderingType['acsUiTemplate'] ?? '';

        if ($acsUiTemplate) {
            return AcsUiType::getUiType($acsUiTemplate);
        }

        return null;
    }

    public function getUiInterface(): ?string
    {
        return $this->aRes->acsRenderingType['acsInterface'];
    }

    public function saveTransactionMessageId($transactionMessageId): void
    {
        $this->transaction_message_id = $transactionMessageId;
        $this->save();
    }

    public function saveThreeDsSessionData($threeDSSessionData): void
    {
        $this->threeds_session_data = $threeDSSessionData;
        $this->save();
    }

    public function saveCEK($cek): void
    {
        $this->cek = $cek;
        $this->save();
    }

    public function incrementsAcsCounterAtoS(): void
    {
        $this->acs_counter_a_to_s += 1;
        $this->save();
    }

    public function incrementsInteractionCounter(): void
    {
        if (is_null($this->interaction_counter)) {
            $this->interaction_counter = 0;
        } else {
            $this->interaction_counter += 1;
        }
        $this->save();
    }

    public function getAcsUiType(): ?string
    {
        return $this->cRes->acsUiType ?? null;
    }

    public function getTimeRemaining(): int
    {
        $diffTimeDecoupling = now()->diffInMinutes($this->created_at);

        $threeDSRequestorDecMaxTime = $this->getAReqAttribute()->threeDSRequestorDecMaxTime;
        if (!$threeDSRequestorDecMaxTime) {
            $threeDSRequestorDecMaxTime = IssuerSettingHelper::getValue(
                AcsSetting::DECOUPLED_MAX_TIME,
                $this->issuer
            );
        }

        return intval($threeDSRequestorDecMaxTime) - $diffTimeDecoupling;
    }

    public function canBeResolved(): bool
    {
        return $this->trans_status === TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE && $this->getTimeRemaining() > 0;
    }

    /**
     * @throws CurrencyNotFoundException|ThreeDSException
     */
    public function setPlatformAmountFromMessage(Message $request): string
    {
        return ExchangeRateHelper::convertToPlatformCurrency($request->purchaseCurrency, $request->purchaseAmount);
    }

    public function couldNotBeAuthenticated(): bool
    {
        return $this->trans_status === TransactionStatus::NOT_AUTHENTICATED
            || $this->trans_status === TransactionStatus::COULD_NOT_BE_PERFORMED;
    }

    public static function scopeResolved(Builder $query): Builder
    {
        return $query
            ->where('trans_status', '!=', TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE)
            ->where('trans_status', '!=', TransactionStatus::CHALLENGE_REQUIRED)
            ->where('trans_status', '!=', null);
    }

    public static function scopeDecoupledTransactions(Builder $query): Builder
    {
        return $query->with([
            'user',
            'issuer',
            'currency',
            'franchise',
            'issuer.country',
            'card:id,truncated',
            'messages' => function ($query) {
                $query->where('message_type', MessageType::AREQ);
            },
        ])
            ->where('trans_status', TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE)
            ->latest('id');
    }

    public function getIssuerId(): int
    {
        return $this->issuer_id;
    }

    public function getTransactionStatus(): ?string
    {
        return $this->trans_status;
    }

    public function getCreateAtFormat(): string
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getExportName(): string
    {
        return "transaction_{$this->acs_trans_id}_{$this->getCreateAtFormat()}.pdf";
    }

    public function scopeWithAcl(Builder $query, Profile $profile = null): Builder
    {
        $query = $query->where(function ($query) use ($profile) {
            $needFilterIssuer = AclHelper::needsModelFilter(Issuer::class, $profile->id ?? null);
            $needFilterFranchise = AclHelper::needsModelFilter(Franchise::class, $profile->id ?? null);

            if (!$needFilterIssuer && !$needFilterFranchise) {
                return;
            }

            if ($needFilterIssuer) {
                $query->whereIn(
                    'issuer_id',
                    Issuer::withAclOrCreatedBy(null, null, $profile)->select('id')->get()->pluck('id')
                );
            } else {
                $query->whereNotNull('issuer_id');
            }

            if ($needFilterFranchise) {
                $query->orWhereIn(
                    'franchise_id',
                    Franchise::withAclOrCreatedBy(null, null, $profile)->select('id')->get()->pluck('id')
                );
            } else {
                $query->orWhereNotNull('franchise_id');
            }
        });

        return $query;
    }

    public function scopeWithAcsTransId(Builder $query, string $acsTransId = null): Builder
    {
        return $acsTransId ? $query->where($this->getRouteKeyName(), $acsTransId) : $query;
    }

    public function scopeWithTruncatedCard(Builder $query): Builder
    {
        return $query->addSelect([
            'truncated_card' => Card::select('truncated')
                ->whereColumn('transactions.card_id', 'cards.id')
                ->take(1),
        ]);
    }

    public function scopeWithHashedCard(Builder $query): Builder
    {
        return $query->addSelect([
            'hashed_card' => Card::select('hashed')
                ->whereColumn('transactions.card_id', 'cards.id')
                ->take(1),
        ]);
    }

    public function scopeWithCountryCode(Builder $query): Builder
    {
        return $query->addSelect([
            'country_code' => Country::select('alpha_3_code')
                ->whereColumn('transactions.country_id', 'countries.id')
                ->take(1),
        ]);
    }

    public function scopeWithCurrencyCode(Builder $query): Builder
    {
        return $query->addSelect([
            'currency_code' => Currency::select('alphabetic_code')
                ->whereColumn('transactions.currency_id', 'currencies.id')
                ->take(1),
        ]);
    }

    public function getFormattedAmountAttribute(): string
    {
        return isset($this->attributes['currency_code'])
            ? Amount::format($this->attributes['currency_code'], $this->attributes['purchase_amount'])
            : $this->attributes['purchase_amount'];
    }

    public function getCountryCode(): ?string
    {
        return $this->country_code ?? optional($this->country)->alpha_3_code;
    }

    public function hasCountry(): bool
    {
        return !is_null($this->getCountryCode());
    }

    public function getCurrentCauserName(): string
    {
        /** @var Authenticatable|null $authUser */
        $authUser = Auth::user();

        return isset($this::$logCauser) ? $authUser->{$this::$logCauser} : $authUser->email;
    }
}
