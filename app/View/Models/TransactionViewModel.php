<?php

namespace App\View\Models;

use App\Actions\UpdateTransactionExtraAttributesAction;
use App\FraudControl\Constants\RiskScores;
use App\Models\Transaction;
use App\Models\TransactionScore;
use App\ThreeDS\Messages\Requests\AReq;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TransactionViewModel extends BasicTransactionViewModel
{
    private bool $exportable = false;
    private array $message;
    private ?AReq $aReq;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    private function scores(): Collection
    {
        return TransactionScore::where('transaction_id', $this->transaction->id)->get()->map(function ($score) {
            $type = $this->assignTypeByRisk($score->risk);

            return [
                'title' => trans('fields.' . Str::snake($score->score_name) . '.label'),
                'subtitle' => $score->risk ? trans("authentications.risks.{$score->risk}") : '',
                'value' => $score->value,
                'class' => 'text-' . $type['type'],
                'ico' => 'fal header-card-ico header-card-ico-text-' . $type['type'] . ' ' . $type['ico'],
            ];
        });
    }

    private function assignTypeByRisk(string $risk): array
    {
        return match ($risk) {
            RiskScores::LOW => [
                'type' => 'success',
                'ico' => 'fa-check-circle',
            ],
            RiskScores::MEDIUM => [
                'type' => 'warning',
                'ico' => 'fa-exclamation-circle',
            ],
            default => [
                'type' => 'danger',
                'ico' => 'fa-times-circle',
            ],
        };
    }

    public function reservedFields(): array
    {
        return [
            'browserIP',
            'workPhone.subscriber',
            'homePhone.subscriber',
            'mobilePhone.subscriber',
            'billAddrLine1',
            'billAddrLine2',
            'billAddrLine3',
            'shipAddrLine1',
            'shipAddrLine2',
            'shipAddrLine3',
        ];
    }

    public function enableExportable(): self
    {
        $this->exportable = true;

        return $this;
    }

    public function toArray(): array
    {
        $this->resolveTransaction();
        $this->updateExtraAttributes();

        return [
            'transaction' => $this->transaction,
            'scores' => $this->scores(),
            'messages' => $this->message,
            'indicators' => $this->indicators(),
            'aReq' => $this->aReq,
            'disputeHistories' => $this->disputeHistories(),
            'exportable' => $this->exportable,
            'reservedFields' => $this->reservedFields(),
            'billAddr' => $this->billAddr($this->aReq),
            'payer' => $this->payer($this->aReq),
            'riskIndicator' => $this->riskIndicator($this->aReq),
        ];
    }

    public function resolveTransaction(): void
    {
        $this->transaction->load([
            'issuer:id,name,slug,country_id,logo',
            'issuer.country:id,alpha_3_code',
            'traces' => function ($query) {
                $query->select([
                    'id',
                    'type',
                    'content',
                    'transaction_id',
                    'created_at',
                    'updated_at',
                ])->latest();
            },
            'messages' => function ($query) {
                $query->select([
                    'id',
                    'message_type',
                    'message',
                    'parent_id',
                    'transaction_status',
                    'created_at',
                    'updated_at',
                    'transaction_id',
                ]);
            },
        ]);

        $this->message = $this->messages();
        $this->aReq = $this->aReq();
    }

    private function billAddr(AReq|null $aReq): array
    {
        return array_filter([
            trans('fields.billAddr.city') => $aReq?->billAddrCity,
            trans('fields.billAddr.country') => $aReq?->billAddrCountry,
            trans('fields.billAddr.line1') => $aReq?->billAddrLine1,
            trans('fields.billAddr.line2') => $aReq?->billAddrLine2,
            trans('fields.billAddr.line3') => $aReq?->billAddrLine3,
            trans('fields.billAddr.post_code') => $aReq?->billAddrPostCode,
            trans('fields.billAddr.state') => $aReq?->billAddrState,
        ]);
    }

    private function payer(AReq|null $aReq): array
    {
        return array_filter([
            trans('fields.email.label') => $aReq?->email,
            trans('fields.home_phone.label') => $this->exportable && $aReq?->hasField('homePhone')
                ? $aReq?->truncatePhone('homePhone')
                : data_get($aReq?->toArray(), 'homePhone.subscriber'),
            trans('fields.mobile_phone.label') => $this->exportable && $aReq?->hasField('mobilePhone')
                ? $aReq?->truncatePhone('mobilePhone')
                : data_get($aReq?->toArray(), 'mobilePhone.subscriber'),
            trans('fields.work_phone.label') => $this->exportable && $aReq?->hasField('workPhone')
                ? $aReq?->truncatePhone('workPhone')
                : data_get($aReq?->toArray(), 'workPhone.subscriber'),
            trans('fields.cardholder_account_information.ch_acc_age_ind') => $aReq?->chAccAgeInd,
            trans('fields.cardholder_account_information.ch_acc_change') => $aReq?->chAccChange,
            trans('fields.cardholder_account_information.ch_acc_change_ind') => $aReq?->chAccChangeInd,
            trans('fields.cardholder_account_information.ch_acc_date') => $aReq?->chAccDate,
            trans('fields.cardholder_account_information.nb_purchase_account') => $aReq?->nbPurchaseAccount,
            trans('fields.cardholder_account_information.txn_activity_day') => $aReq?->txnActivityDay,
            trans('fields.cardholder_account_information.txn_activity_year') => $aReq?->txnActivityYear,
            trans('fields.merchant.risk.delivery_email_address') => $aReq?->deliveryEmailAddress,
            trans('fields.merchant.risk.delivery_timeframe') => $aReq?->deliveryTimeframe,
            trans('fields.merchant.risk.gift_card_amount') => $aReq?->giftCardAmount,
            trans('fields.merchant.risk.gift_card_count') => $aReq?->giftCardCount,
            trans('fields.merchant.risk.gift_card_curr') => $aReq?->giftCardCurr,
            trans('fields.merchant.risk.pre_order_date') => $aReq?->preOrderDate,
            trans('fields.merchant.risk.pre_order_purchase_ind') => $aReq?->preOrderPurchaseInd,
            trans('fields.merchant.risk.reorder_items_ind') => $aReq?->reorderItemsInd,
            trans('fields.merchant.risk.ship_indicator') => $aReq?->shipIndicator,
        ]);
    }

    private function riskIndicator(AReq|null $aReq): array
    {
        $merchantRiskInd = $aReq?->merchantRiskIndicator;

        $suspiciousAccActivity = $aReq?->suspiciousAccActivity;
        $addrMatch = $aReq?->addrMatch;

        return array_filter(array_merge($this->riskData($merchantRiskInd), [
            trans('fields.device_channel.label') => ($this->transaction->device_channel !== null) ? trans(
                "fields.device_channel.{$this->transaction->device_channel}"
            ) : null,
            trans('fields.acc_activity.label') => ($suspiciousAccActivity) ? trans(
                "fields.acc_activity.values.{$suspiciousAccActivity}"
            ) . ' (' . $suspiciousAccActivity . ')' : null,
            trans('fields.addr_match.label') => ($addrMatch !== null) ? trans(
                "fields.addr_match.values.{$addrMatch}"
            ) . ' (' . $addrMatch . ')' : null,
            trans('fields.merchant_risk.gift_card_amount') => data_get($merchantRiskInd, 'giftCardAmount'),
            trans('fields.merchant_risk.gift_card_count') => data_get($merchantRiskInd, 'giftCardCount'),
            trans('fields.merchant_risk.pre_order_date') => data_get($merchantRiskInd, 'preOrderDate'),
            trans('fields.merchant_risk.gift_card_curr') => data_get($merchantRiskInd, 'giftCardCurr'),
            trans('fields.merchant_risk.delivery_email_address') => data_get(
                $merchantRiskInd,
                'deliveryEmailAddress'
            ),
        ]));
    }

    private function riskData($merchantRiskInd): array
    {
        $data = [
            'preOrderPurchaseInd' => 'fields.merchant_risk.pre_order_purchase_ind',
            'deliveryTimeframe' => 'fields.merchant_risk.delivery_timeframe',
            'reorderItemsInd' => 'fields.merchant_risk.reorder_items_ind',
            'shipIndicator' => 'fields.merchant_risk.ship_indicator',
            'deviceChannel' => 'fields.device_channel',
            'accActivity' => 'fields.acc_activity',
            'addrMatch' => 'fields.addr_match',
        ];

        $riskData = [];
        foreach ($data as $key => $transKey) {
            $value = data_get($merchantRiskInd, $key);
            if ($value !== null) {
                $riskData[trans("{$transKey}.label")] = trans("{$transKey}.values.{$value}");
            }
        }

        return $riskData;
    }

    public function updateExtraAttributes(): void
    {
        if ($this?->aReq && $this->aReq?->browserIP && !$this->transaction->hasIpInformation()) {
            UpdateTransactionExtraAttributesAction::execute($this->transaction, $this->aReq->browserIP);
            $this->transaction->refresh();
        }
    }
}
