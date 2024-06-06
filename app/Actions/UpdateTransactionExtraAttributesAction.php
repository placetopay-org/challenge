<?php

namespace App\Actions;

use App\Models\Transaction;
use App\Services\IPLocationService;
use Illuminate\Support\Carbon;

class UpdateTransactionExtraAttributesAction
{
    public static function execute(Transaction $transaction, string $ip): void
    {
        $ipInformation = GetGeolocationInfoAction::execute($ip, new IPLocationService());

        if (empty($ipInformation)) {
            return;
        }

        data_set(
            $ipInformation,
            'sameYearProcessed',
            $transaction->created_at->year === Carbon::now()->year
        );

        data_set($ipInformation, 'created_at', Carbon::now()->toDateTimeString());

        $transaction->extra_attributes->set(['ipInformation' => $ipInformation]);
        $transaction->save();
    }
}
