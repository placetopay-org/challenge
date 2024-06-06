<?php

namespace FeatureAdmin\DecoupledTransaction;

use App\Constants\Permissions;
use App\Models\Issuer;
use Facades\App\Helpers\UserHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageVersion;
use PlacetoPay\ThreeDsSecureBase\Constants\Versions\V220\TransactionStatus;
use Tests\Concerns\HasAclRule;
use Tests\Concerns\ProcessingFlows\HasSampleDataBrw;
use Tests\TestCase;

class ShowDecoupledTransactionTest extends TestCase
{
    use RefreshDatabase;
    use HasSampleDataBrw;
    use HasAclRule;

    /**
     * @test
     */
    public function anUnauthorizedUserCannotViewADecoupledTransaction(): void
    {
        $user = UserHelper::create();

        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE,
        ]);

        $this->assertEmpty($transaction->extra_attributes);

        $response = $this->actingAs($user)
            ->get(route('admin.decoupleTransactions.show', $transaction));

        $response->assertForbidden();

        $transaction->refresh();
        $this->assertEmpty($transaction->extra_attributes);
    }

    /**
     * @test
     */
    public function anUnauthenticatedUserCannotViewADecoupledTransaction(): void
    {
        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE,
        ]);

        $this->assertEmpty($transaction->extra_attributes);

        $response = $this->get(route('admin.decoupleTransactions.show', $transaction));

        $response->assertStatus(302)->assertRedirect(route('login'));
        $this->assertEmpty($transaction->extra_attributes);
    }

    /**
     * @test
     */
    public function anAuthorizedUserCanViewADecoupledTransactionWithAllowAclRule(): void
    {
        $userA = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE,
        ]);

        $this->assertEmpty($transaction->extra_attributes);

        $this->withAllowPolicy($userA->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->actingAs($userA)
            ->get(route('admin.decoupleTransactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('admin.decoupled_transactions.show');
        $response->assertViewHasAll(['transaction', 'messages', 'aReq']);

        $transaction->refresh();
        $this->assertIPLocationData($transaction);
    }

    /**
     * @test
     */
    public function anAuthorizedUserCannotViewADecoupledTransactionWithDenyAclRule(): void
    {
        $userA = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE,
        ]);

        $this->withDenyPolicy($userA->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->actingAs($userA)
            ->get(route('admin.decoupleTransactions.show', $transaction));

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function anAuthorizedUserCannotViewADecoupledTransactionWithNoAclRule(): void
    {
        $userA = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE,
        ]);

        $response = $this->actingAs($userA)
            ->get(route('admin.decoupleTransactions.show', $transaction));

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function anAuthorizedUserCanSeeTheReleaseButton(): void
    {
        $userA = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE,
        ]);

        $this->assertEmpty($transaction->extra_attributes);

        $this->withAllowPolicy($userA->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->actingAs($userA)
            ->get(route('admin.decoupleTransactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('admin.decoupled_transactions.show');
        $response->assertSee(trans('common.release_user'));

        $transaction->refresh();
        $this->assertIPLocationData($transaction);
    }

    /**
     * @test
     */
    public function anAuthorizedUserCanSeeTheResolveButton(): void
    {
        $userA = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => TransactionStatus::CHALLENGE_REQUIRED_DECOUPLE,
        ]);

        $this->assertEmpty($transaction->extra_attributes);

        $this->withAllowPolicy($userA->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->actingAs($userA)
            ->get(route('admin.decoupleTransactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('admin.decoupled_transactions.show');
        $response->assertSee(trans('common.resolve_authentication'));

        $transaction->refresh();
        $this->assertIPLocationData($transaction);
    }
}
