<?php

namespace App\Jobs;

use App\Actions\UpdateTransactionExtraAttributesAction;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTransactionExtraAttributes implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly Transaction $transaction, private readonly string $ip)
    {
    }

    public function handle(UpdateTransactionExtraAttributesAction $action): void
    {
        $action->execute($this->transaction, $this->ip);
    }
}
