<?php

namespace App\Presenters;

use PlacetoPay\ThreeDsSecureBase\Constants\Versions\V220\TransactionStatus;

class TransactionPresenter extends Presenter
{
    public function showRoute(): string
    {
        return TransactionStatus::isChallengeRequiredDecoupleStatus($this->entity->trans_status)
            ? route('admin.decoupleTransactions.show', $this->entity)
            : route('admin.transactions.show', $this->entity);
    }

    public function status(): string
    {
        return $this->entity->trans_status ?? TransactionStatus::COULD_NOT_BE_PERFORMED;
    }

    public function deviceChannel(): string
    {
        return trans("fields.device_channel.{$this->entity->device_channel}");
    }
}
