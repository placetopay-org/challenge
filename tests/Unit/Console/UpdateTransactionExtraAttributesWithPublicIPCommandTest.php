<?php

namespace Tests\Unit\Commands;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\DeviceChannel;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageCategory;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageType;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageVersion;
use Tests\Concerns\LogTestTrait;
use Tests\Concerns\ProcessingFlows\HasSampleDataBrw;
use Tests\TestCase;

class UpdateTransactionExtraAttributesWithPublicIPCommandTest extends TestCase
{
    use RefreshDatabase;
    use LogTestTrait;
    use WithFaker;
    use HasSampleDataBrw;

    /**
     * @test
     */
    public function itCanUpdateThisDateTransactionsByAddingExtraAttributes(): void
    {
        /**
         * it is updated successfully.
         */
        $transactionA = $this->createTransaction(MessageVersion::V_220, [
            'created_at' => Carbon::now(),
        ]);

        /**
         * created a year ago.
         */
        $transactionB = $this->createTransaction(MessageVersion::V_220, [
            'created_at' => now()->subYear(),
        ]);

        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth()->format('Y-m-d');

        $this->artisan('acs:update-transactions-extra-attributes', ['--from' => $from, '--to' => $to])
            ->assertOk()
            ->expectsOutput('Transactions updated successfully.');

        $transactionA->refresh();
        $transactionB->refresh();
        $this->assertIPLocationData($transactionA);
        $this->assertEmpty($transactionB->extra_attributes);

        $this->assertSame(1, $this->countTransactionExtraAttributes($from, $to));
        $this->assertSame(2, Transaction::count());
        $this->assertSame($transactionA->getAReqAttribute()->browserIP, '1.12.123.255');
        $this->assertSame($transactionA->message_version, MessageVersion::V_220);

    }

    /**
     * @test
     */
    public function itCanNotUpdateThisDateTransactionsByAddingExtraAttributes(): void
    {
        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'created_at' => now()->subDays(2),
            'device_channel' => DeviceChannel::BRW,
        ], [
            'messageCategory' =>  MessageCategory::PA,
            'deviceChannel' => DeviceChannel::BRW,
            'browserIP' => $this->faker->localIpv4,
        ]);

        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth()->format('Y-m-d');

        $this->artisan('acs:update-transactions-extra-attributes', ['--from' => $from, '--to' => $to])
            ->assertOk()
            ->expectsOutput('Transactions updated successfully.');

        $transaction->refresh();

        $this->assertEmpty($transaction->extra_attributes);
    }

    private function countTransactionExtraAttributes(string $from, string $to): int
    {
        return Transaction::whereYear('created_at', date('Y'))
            ->whereBetween('transactions.created_at', [$from, $to])
            ->whereNotNull('extra_attributes')
            ->where('device_channel', DeviceChannel::BRW)
            ->with('messages', function ($query) {
                $query->where('message_type', MessageType::AREQ);
            })
            ->count();
    }
}
