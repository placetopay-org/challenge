<?php

namespace App\Console\Commands;

use App\Actions\GetGeolocationInfoAction;
use App\Contracts\Services\IPLocationContract;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\DeviceChannel;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageType;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateTransactionExtraAttributesCommand extends Command
{
    protected $signature = 'acs:update-transactions-extra-attributes {--from=} {--to=}';

    protected $description = 'Update extra attributes of transactions for this year';

    public function handle(IPLocationContract $ipLocation): int
    {
        $from = $this->option('from');
        $to = $this->option('to');

        $validator = Validator::make(
            [
                'from' => $from,
                'to' => $to,
            ],
            [
                'from' => 'required|date|date_format:Y-m-d',
                'to' => 'required|date|date_format:Y-m-d|after_or_equal:from',
            ]
        );

        if ($validator->fails()) {
            $this->error('Invalid date: ' . $validator->errors()->first());
            return CommandAlias::FAILURE;
        }

        $from = Carbon::parse($from)->startOfDay()->toDateTimeString();
        $to = Carbon::parse($to)->endOfDay()->toDateTimeString();

        Transaction::whereBetween('transactions.created_at', [$from, $to])
            ->whereNull('extra_attributes')
            ->where('device_channel', DeviceChannel::BRW)
            ->with('messages', function ($query) {
                $query->where('message_type', MessageType::AREQ);
            })->chunk(100, function ($transactions) use ($ipLocation) {
                $transactionsInsert = [];
                foreach ($transactions as $transaction) {
                    $browserIP = $transaction->aReq->browserIP;
                    $ipInformation = GetGeolocationInfoAction::execute($browserIP, $ipLocation);

                    if (empty($ipInformation)) {
                        continue;
                    }

                    data_set($ipInformation, 'sameYearProcessed', true);
                    data_set($ipInformation, 'created_at', Carbon::now()->toDateTimeString());

                    $transactionsInsert[] = [
                        'id' => $transaction->id,
                        'acs_trans_id' => $transaction->acs_trans_id,
                        'ds_trans_id' => $transaction->ds_trans_id,
                        'threeds_server_trans_id' => $transaction->threeds_server_trans_id,
                        'extra_attributes' => json_encode(['ipInformation' => $ipInformation]),
                        'issuer_id' => $transaction->issuer_id,
                        'device_channel' => $transaction->device_channel,
                        'message_category' => $transaction->message_category,
                        'card_id' => $transaction->card_id,
                    ];
                }

                Transaction::upsert($transactionsInsert, ['id'], ['extra_attributes']);
            }, 'id');

        $this->info('Transactions updated successfully.');

        return CommandAlias::SUCCESS;
    }
}
