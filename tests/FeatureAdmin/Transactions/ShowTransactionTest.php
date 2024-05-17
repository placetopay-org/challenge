<?php

namespace Tests\FeatureAdmin\Transactions;

use App\Constants\AcsSetting;
use App\Constants\DisputesStatus;
use App\Constants\Permissions;
use App\Constants\ResponseCodes;
use App\Constants\TransactionTraceTypes;
use App\FraudControl\Constants\DAFActions;
use App\FraudControl\Constants\Frequencies;
use App\FraudControl\Constants\RiskScores;
use App\FraudControl\Constants\RuleActions;
use App\FraudControl\Constants\RuleOperators;
use App\FraudControl\Constants\RuleTypes;
use App\FraudControl\MessageExtensions\DigitalAuthenticationFramework as DAF;
use App\Models\Challenge;
use App\Models\Dispute;
use App\Models\FraudControlList;
use App\Models\Issuer;
use App\Models\Transaction;
use App\Models\TransactionMessage;
use App\Models\TransactionScore;
use App\Models\TransactionTrace;
use App\Models\User;
use App\ThreeDS\Challenge\Types\OneTimePasscode\OTPTarget;
use App\ThreeDS\Constants\FraudControlListType;
use App\ThreeDS\Constants\FraudControlListValueType;
use App\ThreeDS\Factories\MessageBuilderFactory;
use App\ThreeDS\Services\OTP\Strategies\DinersStrategy;
use App\ThreeDS\Services\OTP\Strategies\PlacetoPayStrategy;
use Facades\App\Helpers\UserHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use PlacetoPay\Base\Entities\Status;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\AcsUiType;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\DeviceChannel;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageCategory;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageType;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageVersion;
use PlacetoPay\ThreeDsSecureBase\Constants\Versions\V220\TransactionStatus;
use PlacetoPay\ThreeDsSecureBase\Helpers\DataElement;
use Tests\Concerns\CardholderInformationDataTrait;
use Tests\Concerns\HasAclRule;
use Tests\Concerns\HasSampleTransactionMessages;
use Tests\Concerns\HasTransactionTraces;
use Tests\Concerns\ProcessingFlows\HasSampleDataBrw;
use Tests\Concerns\Providers\MessageExtensionProvider;
use Tests\Helpers\DOMAnalyzer;
use Tests\TestCase;

class ShowTransactionTest extends TestCase
{
    use WithFaker;
    use HasAclRule;
    use RefreshDatabase;
    use HasSampleDataBrw;
    use HasTransactionTraces;
    use MessageExtensionProvider;
    use HasSampleTransactionMessages;
    use CardholderInformationDataTrait;

    /**
     * @test
     */
    public function unauthorizedUserCannotAccessToTheTransactionDetail(): void
    {
        $transaction = Transaction::factory()->create();
        $response = $this->get(route('admin.transactions.show', $transaction));

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function aUsersWithoutPermissionCannotAccessTheTransactionDetail(): void
    {
        $transaction = Transaction::factory()->create();

        $user = UserHelper::create();

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function anAuthorizedUserCanSeeATransactionDetailWithAllowAclRule(): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('admin.transactions.show');

        $response->assertSeeText($transaction->getFormattedAmount());
        $response->assertSeeText($transaction->issuer->name);
        $response->assertSeeText($transaction->issuer->country->alpha_3_code);
        $response->assertSeeText($transaction->acquirer_bin);
        $response->assertSeeText($transaction->acs_trans_id);
        $response->assertSeeText($transaction->threeds_server_trans_id);
        $response->assertSeeText($transaction->ds_trans_id);
        $response->assertSeeText($transaction->sdk_trans_id);
        $response->assertSeeText($transaction->created_at->toDateString());
        $response->assertSeeText($transaction->created_at->toTimeString());
        $response->assertSeeText(trans("fields.device_channel.{$transaction->aReq->deviceChannel}"));
        $response->assertSeeText(trans("fields.message_category.{$transaction->aReq->messageCategory}"));

        $response->assertSeeText(trans('titles.requestor_authentication_information'));
        $response->assertSeeText(trans('titles.bill_address'));
        $response->assertSeeText(trans('titles.card_holder'));
        $response->assertSeeText(trans('titles.risk_indicators'));
        $response->assertSeeText(trans('titles.shipping'));

        $response->assertSeeText($transaction->aReq->homePhone['subscriber']);
        $response->assertSeeText($transaction->aReq->mobilePhone['subscriber']);
        $response->assertSeeText($transaction->aReq->workPhone['subscriber']);

        $response->assertSeeText($transaction->aReq->merchantName);
        $response->assertSeeText($transaction->aReq->mcc);
        $response->assertSeeText($transaction->country->alpha_3_code);

        $this->assertIsArray($transaction->aReq->acctInfo);

        $response->assertSeeText($transaction->country->alpha_3_code);
        $response->assertSeeText($transaction->aReq->shipAddrState);
        $response->assertSeeText($transaction->aReq->shipAddrCity);
        $response->assertSeeText($transaction->aReq->shipAddrPostCode);

        $response->assertSeeText($transaction->aReq->merchantRiskIndicator['preOrderPurchaseInd']);
        $response->assertSeeText($transaction->aReq->merchantRiskIndicator['deliveryEmailAddress']);
        $response->assertSeeText($transaction->aReq->merchantRiskIndicator['deliveryTimeframe']);
        $response->assertSeeText($transaction->aReq->merchantRiskIndicator['reorderItemsInd']);

        $response->assertSeeText($transaction->aReq->merchantRiskIndicator['giftCardAmount']);
        $response->assertSeeText($transaction->aReq->merchantRiskIndicator['shipIndicator']);
        $response->assertSeeText($transaction->aReq->merchantRiskIndicator['giftCardCount']);
        $response->assertSeeText($transaction->aReq->merchantRiskIndicator['preOrderDate']);
        $response->assertSeeText($transaction->aReq->merchantRiskIndicator['giftCardCurr']);
        $response->assertSeeText(trans("fields.merchant_risk.pre_order_purchase_ind.values.{$transaction->aReq->merchantRiskIndicator['preOrderPurchaseInd']}"));
        $response->assertSeeText(trans("fields.merchant_risk.delivery_timeframe.values.{$transaction->aReq->merchantRiskIndicator['deliveryTimeframe']}"));
        $response->assertSeeText(trans("fields.merchant_risk.reorder_items_ind.values.{$transaction->aReq->merchantRiskIndicator['reorderItemsInd']}"));
        $response->assertSeeText(trans("fields.merchant_risk.ship_indicator.values.{$transaction->aReq->merchantRiskIndicator['shipIndicator']}"));
        $response->assertSeeText(trans("fields.addr_match.values.{$transaction->aReq->addrMatch}"));
        $response->assertSeeText(trans("fields.device_channel.{$transaction->device_channel}"));

        $response->assertSeeText(trans("fields.message_category.{$transaction->message_category}"));
    }

    /**
     * @test
     */
    public function anAuthorizedUserCanSeeATransactionDetailWithStatusSuccessWithAllowAclRule(): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => TransactionStatus::SUCCESSFUL,
        ]);

        TransactionScore::factory()->create([
            'transaction_id' => $transaction->id,
            'risk' => RiskScores::MEDIUM,
        ]);

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('admin.transactions.show');
    }

    /**
     * @test
     */
    public function anAuthorizedUserCanSeeATransactionDetailWithStatusNotAuthenticatedWithAllowAclRule(): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => TransactionStatus::NOT_AUTHENTICATED,
        ]);

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('admin.transactions.show');
    }

    /**
     * @test
     */
    public function anAuthorizedUserCannotSeeATransactionDetailWithDenyAclRule(): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $this->withDenyPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function anAuthorizedUserCannotSeeATransactionDetailWithNoAclRule(): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function anAuthorizedUserCanSeeADisputeDetailWithAllowAclRule(): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();
        $this->actingAs($user);
        $transaction = $this->createTransaction(MessageVersion::V_220);
        $dispute = Dispute::factory()->close()->create(['transaction_id' => $transaction->id]);

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->get(route('admin.transactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('admin.transactions.show');

        $response->assertSeeText($dispute->modality);
        $response->assertSeeText($dispute->status);
        $response->assertSeeText($dispute->action[0]);
        $response->assertSeeText($dispute->justify);
        $response->assertSeeText($dispute->resposible_agent);
    }

    /**
     * @test
     * @dataProvider disputeIndicatorProvider
     * @param string $status
     */
    public function anAuthorizedUserCanSeeAllDispiteIndicators(string $status): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $this->actingAs($user);

        $transaction = $this->createTransaction(MessageVersion::V_220);

        Dispute::factory()->{$status}()->create(['transaction_id' => $transaction->id]);

        $response = $this->get(route('admin.transactions.show', $transaction));

        $response->assertOk()
            ->assertViewIs('admin.transactions.show')
            ->assertViewHas('indicators', function (array $indicators) use ($status): bool {
                $indicator = Arr::first($indicators, function (array $indicator) use ($status): bool {
                    return $indicator['subtitle'] === trans("disputes.status.{$status}");
                });

                return !empty($indicator);
            });
    }

    /**
     * @test
     */
    public function itCheckTransactionShowViewContent(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $this->createCReqMessage($transaction);
        $this->createCResMessage($transaction);
        $this->createRReqMessage($transaction);
        $this->createRResMessage($transaction);

        $content = [
            [
                'name' => $transaction->card->truncated,
                'group' => trans('fraudControlGroup.titles.main'),
                'executed_action' => RuleActions::AUTHENTICATE,
                'requested_action' => RuleActions::AUTHENTICATE,
                'rule_conditionals' => [
                    [
                        'rule' => RuleTypes::BIN_RANGE,
                        'operator' => RuleOperators::BETWEEN,
                        'stringValue' => "{$transaction->card->bin}, {$transaction->card->bin}",
                    ],
                ],
            ],
        ];

        TransactionTrace::factory()->create([
            'content' => $content,
            'type' => TransactionTraceTypes::FRAUD_CONTROL,
            'transaction_id' => $transaction->id,
        ]);

        $erro = $this->createErrorMessage($transaction);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $erroComponent = trans('authentications.component.error', [
            'causer' => 'A - ' . trans('authentications.component.' . $erro->message['errorComponent']),
        ]);

        $response->assertOk()
            ->assertSeeTextInOrder([
                'Authentication Request (AReq)',
                'Authentication Response (ARes)',
                'Challenge Request (CReq)',
                'Challenge Response (CRes)',
                'Result Request (RReq)',
                'Result Response (RRes)',
                'Error (Erro)',
            ])
            ->assertSeeText(strip_tags($erroComponent))
            ->assertSeeText($erro->message['errorDescription'])
            ->assertSeeText($erro->message['errorDetails'])
            ->assertSee(route('admin.transactions.index'))
            ->assertSee(route('admin.transactions.disputes.store', $transaction))
            ->assertSeeTextInOrder([
                trans('fraudControlGroup.titles.main'),
                RuleActions::trans(RuleActions::AUTHENTICATE),
                RuleTypes::trans(RuleTypes::BIN_RANGE)
                . ' ' . strtolower(RuleOperators::trans(RuleOperators::BETWEEN))
                . ' ' . "{$transaction->card->bin}, {$transaction->card->bin}",
            ]);

        $dom = new DOMAnalyzer($response->getContent());

        $messages = [
            MessageType::AREQ,
            MessageType::ARES,
            MessageType::CREQ,
            MessageType::CRES,
            MessageType::RREQ,
            MessageType::RRES,
        ];

        foreach ($messages as $message) {
            $this->assertStringContainsString(trans("authentications.messages.{$message}.description"), $dom->getBody());
        }
    }

    /**
     * @test
     */
    public function itCanDisplayFraudControlTraceWithAuthenticationDataRule(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $content = [
            [
                'name' => 'Custom rule name',
                'group' => 'Custom group name',
                'executed_action' => RuleActions::AUTHENTICATE,
                'requested_action' => RuleActions::AUTHENTICATE,
                'rule_conditionals' => [
                    [
                        'rule' => RuleTypes::AUTHENTICATION_DATA,
                        'operator' => RuleOperators::EQ,
                        'field' => 'acctInfo.chAccPwChange',
                        'stringValue' => now()->format('Ymd'),
                    ],
                ],
            ],
        ];

        TransactionTrace::factory()->create([
            'content' => $content,
            'type' => TransactionTraceTypes::FRAUD_CONTROL,
            'transaction_id' => $transaction->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk()
            ->assertSeeTextInOrder([
            'Custom group name',
            'Custom rule name',
            RuleActions::trans(RuleActions::AUTHENTICATE),
            RuleTypes::trans(RuleTypes::AUTHENTICATION_DATA)
            . ': ' . trans('conditions.fields.acctInfo.chAccPwChange')
            . ' ' . strtolower(RuleOperators::trans(RuleOperators::EQ))
            . ' ' . now()->format('Ymd'),
        ]);
    }

    /**
     * @test
     */
    public function itCanDisplayFraudControlTraceWithSpeedConditionRule(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $content = [
            [
                'name' => 'Main rule',
                'group' => 'Main group',
                'executed_action' => RuleActions::AUTHENTICATE,
                'requested_action' => RuleActions::AUTHENTICATE,
                'rule_conditionals' => [
                    [
                        'rule' => RuleTypes::SPEED_CONDITION,
                        'operator' => RuleOperators::EQ,
                        'frequency' => Frequencies::HOURLY,
                        'stringValue' => '2',
                    ],
                ],
            ],
        ];

        TransactionTrace::factory()->create([
            'content' => $content,
            'type' => TransactionTraceTypes::FRAUD_CONTROL,
            'transaction_id' => $transaction->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk()
            ->assertSeeTextInOrder([
                'Main group',
                'Main rule',
                RuleActions::trans(RuleActions::AUTHENTICATE),
                RuleTypes::trans(RuleTypes::SPEED_CONDITION)
                . ' ' . strtolower(RuleOperators::trans(RuleOperators::EQ))
                . ' ' . 2
                . ' ' . strtolower(trans_choice('authentications.frequency', 2, [
                        'frequency' => strtolower(Frequencies::trans(Frequencies::HOURLY)),
                ])),
            ]);
    }

    /**
     * @test
     */
    public function itCanDisplayFraudControlTracesForLists(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $list = FraudControlList::factory()
            ->restrictive()
            ->pan($transaction->card->getDecrypt())
            ->for($transaction->issuer)
            ->create();

        $content = [
            [
                'list_type' => $list->list_type,
                'value_type' => $list->value_type,
                'display_value' => $list->display_value,
                'requested_action' => $list->isPermissive() ? RuleActions::AUTHENTICATE : RuleActions::NOT_AUTHENTICATE,
                'executed_action' => RuleActions::AUTHENTICATE,
            ],
        ];

        TransactionTrace::factory()->create([
            'content' => $content,
            'type' => TransactionTraceTypes::FRAUD_CONTROL,
            'transaction_id' => $transaction->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk()
            ->assertSeeTextInOrder([
                trans('fraudControlLists.titles.index'),
                FraudControlListType::trans($list->list_type),
                FraudControlListValueType::trans($list->value_type),
                FraudControlListValueType::trans($list->value_type)
                . ' ' . strtolower(RuleOperators::trans(RuleOperators::EQ))
                . ' ' . $list->display_value,
        ]);
    }

    /**
     * @test
     */
    public function itCanDisplayBadgesFraudControlTracesForVisaDAF(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $data = ['messageExtension' => $this->visaMessageExtension(DAF::AUTHENTICATED, DAF::MUST_APPROVE)];

        $transaction = $this->createTransaction(
            messageVersion: MessageVersion::V_220,
            aReqData: $data
        );

        $data = [
            [
                'type' => TransactionTraceTypes::FRAUD_CONTROL,
                'content' => [
                    [
                        'type' => DAF::KEY_NAME,
                        'executed_action' => DAFActions::APPROVE,
                    ],
                ],
            ],
            [
                'type' => TransactionTraceTypes::FRAUD_CONTROL,
                'content' => [
                    [
                        'type' => DAF::KEY_NAME,
                        'executed_action' => DAFActions::AUTHENTICATE,
                    ],
                ],
            ],
            [
                'type' => TransactionTraceTypes::FRAUD_CONTROL,
                'content' => [
                    [
                        'type' => DAF::KEY_NAME,
                        'executed_action' => DAFActions::DECIDE,
                    ],
                ],
            ],
            [
                'type' => TransactionTraceTypes::FRAUD_CONTROL,
                'content' => [
                    [
                        'type' => DAF::KEY_NAME,
                        'executed_action' => DAFActions::DENY,
                    ],
                ],
            ],
            [
                'type' => TransactionTraceTypes::FRAUD_CONTROL,
                'content' => [
                    [
                        'type' => DAF::KEY_NAME,
                        'executed_action' => DAFActions::ISSUER_DENY,
                    ],
                ],
            ],
        ];

        $transaction->traces()->createMany($data);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction))
            ->assertViewHas('indicators', function (array $indicators) {
                $indicator = Arr::first($indicators, function (array $indicator) {
                    return $indicator['subtitle'] === 'Digital Authentication Framework';
                });

                return !empty($indicator);
            });

        $response->assertOk();

        $dom = new DOMAnalyzer($response->getContent());
        $body = $dom->getBody();

        $this->assertStringContainsString(
            trans('authentications.traces.brands.daf.actions.label.approve'),
            $body
        );

        $this->assertStringContainsString(
            trans('authentications.traces.brands.daf.actions.description.approve'),
            $body
        );

        $this->assertStringContainsString(
            trans('authentications.traces.brands.daf.actions.label.authenticate'),
            $body
        );

        $this->assertStringContainsString(
            trans('authentications.traces.brands.daf.actions.description.authenticate'),
            $body
        );

        $this->assertStringContainsString(
            trans('authentications.traces.brands.daf.actions.label.decide'),
            $body
        );

        $this->assertStringContainsString(
            trans('authentications.traces.brands.daf.actions.description.decide'),
            $body
        );

        $this->assertStringContainsString(
            trans('authentications.traces.brands.daf.actions.label.deny'),
            $body
        );

        $this->assertStringContainsString(
            trans('authentications.traces.brands.daf.actions.description.deny'),
            $body
        );

        $this->assertStringContainsString(
            trans('authentications.traces.brands.daf.actions.description.issuer_deny'),
            $body
        );
    }

    /**
     * @test
     */
    public function itCanDisplayCardholderInfoTraces(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $content = [
            'request' => [
                'payload' => [
                    'acsTransID' => $transaction->acs_trans_id,
                    'cardNumber' => $transaction->card->truncated,
                ],
                'endpoint' => 'https://cardholders.dinners.com',
            ],
        ];

        TransactionTrace::factory()->create([
            'content' => $content,
            'type' => TransactionTraceTypes::CARDHOLDER_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        $content = [
            'response' => [
                'data' => [
                    'emails' => [],
                    'phones' => [
                        [
                            'type' => 'Mobile',
                            'number' => '300*****77',
                            'countryCode' => '57',
                        ],
                    ],
                    'document' => [
                        'type' => 'CC',
                        'number' => '246*****55',
                        'countryCode' => '57',
                    ],
                    'cardStatus' => '00',
                    'cardholderName' => 'John Doe',
                ],
                'status' => [
                    'code' => 1200,
                ],
            ],
        ];

        TransactionTrace::factory()->create([
            'content' => $content,
            'type' => TransactionTraceTypes::CARDHOLDER_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        TransactionTrace::factory()->create([
            'content' => ['error' => trans('common.errors_encountered')],
            'type' => TransactionTraceTypes::CARDHOLDER_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        $error = json_encode([
            'status' => 'ERROR',
            'statusCode' => '990',
            'statusMessage' => 'La tarjeta ingresada no se encuentra registrada en el sistema.',
        ]);

        $removableContent = 'removable content body:';

        TransactionTrace::factory()->create([
            'content' => [
                'error' => $removableContent . $error,
            ],
            'type' => TransactionTraceTypes::CARDHOLDER_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        $errorWithoutJson = 'error content body:';

        TransactionTrace::factory()->create([
            'content' => ['error' => $errorWithoutJson],
            'type' => TransactionTraceTypes::CARDHOLDER_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        $errorWithWrongJson = 'error content body: {bad json}';

        TransactionTrace::factory()->create([
            'content' => ['error' => $errorWithWrongJson],
            'type' => TransactionTraceTypes::CARDHOLDER_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk()
            ->assertSeeTextInOrder([
                trans('authentications.traces.cardholder.request'),
                trans('authentications.traces.cardholder.response'),
                trans('authentications.traces.cardholder.error'),
            ]);

        $dom = new DOMAnalyzer($response->getContent());
        $body = $dom->getBody();

        $this->assertStringNotContainsString($removableContent, $body);
        $this->assertStringContainsString($errorWithoutJson, $body);
        $this->assertStringContainsString($errorWithWrongJson, $body);
    }

    /**
     * @test
     */
    public function itCanDisplaySmsDinersServiceTraces(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);
        $cardNumber = Crypt::decrypt($transaction->card->encrypted);

        $content = [
            'action' => 'send',
            'request' => [
                'card' => [
                    'number' => $cardNumber,
                    'expiration' => now()->format('m/y'),
                ],
                'uuid' => $transaction->acs_trans_id,
                'payment' => [
                    'amount' => [
                        'total' => '146',
                        'currency' => 'USD',
                    ],
                ],
                'merchantCode' => '9876543210001',
            ],
            'setting' => AcsSetting::OTP_STRATEGY,
            'strategy' => DinersStrategy::class,
        ];

        TransactionTrace::factory()->create([
            'content' => $content,
            'type' => TransactionTraceTypes::SMS_DINERS_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        TransactionTrace::factory()->create([
            'content' => [
                'code' => ResponseCodes::SUCCESSFUL,
                'action' => 'send',
                'setting' => AcsSetting::OTP_STRATEGY,
                'response' => [
                    'date' => '2021-09-20T19 =>14 =>55+00 =>00',
                    'reason' => 0,
                    'status' => 'OK',
                    'message' => null,
                ],
                'strategy' => DinersStrategy::class,
            ],
            'type' => TransactionTraceTypes::SMS_DINERS_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        TransactionTrace::factory()->create([
            'content' => [
                'action' => 'validate',
                'request' => [
                    'otp' => '223423',
                    'card' => [
                        'number' => $cardNumber,
                        'expiration' => now()->format('m/y'),
                    ],
                    'uuid' => $transaction->acs_trans_id,
                    'payment' => [
                        'reference' => $transaction->acs_trans_id,
                    ],
                    'merchantCode' => '9876543210001',
                ],
                'setting' => AcsSetting::OTP_STRATEGY,
                'strategy' => DinersStrategy::class,
            ],
            'type' => TransactionTraceTypes::SMS_DINERS_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        TransactionTrace::factory()->create([
            'content' => [
                'code' => 1200,
                'action' => 'validate',
                'setting' => AcsSetting::OTP_STRATEGY,
                'response' => [
                    'date' => now(),
                    'reason' => 0,
                    'status' => 'OK',
                    'message' => null,
                ],
                'strategy' => DinersStrategy::class,
            ],
            'type' => TransactionTraceTypes::SMS_DINERS_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        TransactionTrace::factory()->create([
            'content' => [
                'error' => [
                    'code' => '57',
                    'errorDescription' => '',
                ],
                'action' => 'send',
                'setting' => AcsSetting::OTP_STRATEGY,
                'strategy' => DinersStrategy::class,
            ],
            'type' => TransactionTraceTypes::SMS_DINERS_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        TransactionTrace::factory()->create([
            'content' => [
                'error' => [
                    'code' => '67',
                    'errorDescription' => '',
                    'reason' => ResponseCodes::FAILED,
                ],
                'action' => 'validate',
                'setting' => AcsSetting::OTP_STRATEGY,
                'strategy' => DinersStrategy::class,
            ],
            'type' => TransactionTraceTypes::SMS_DINERS_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk();

        $dom = new DOMAnalyzer($response->getContent());
        $body = $dom->getBody();

        $messages = [
            trans('authentications.services.otp_strategy.diners.send.request'),
            trans('authentications.services.otp_strategy.diners.send.response'),
            trans('authentications.services.otp_strategy.diners.validate.request'),
            trans('authentications.services.otp_strategy.diners.validate.response'),
            trans('authentications.services.otp_strategy.diners.send.error'),
            trans('authentications.services.otp_strategy.diners.validate.error'),
        ];

        foreach ($messages as $message) {
            $this->assertStringContainsString($message, $body);
        }
    }

    /**
     * @test
     */
    public function itCanDisplaySmsCoreApiServiceTraces(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);
        $phoneNumber = '0009995566';

        TransactionTrace::factory()->create([
            'content' => [
                'request' => [
                    'number' => $phoneNumber,
                    'message' => 'Hello',
                    'country' => 'CO',
                    'setting' => AcsSetting::OTP_STRATEGY,
                    'strategy' => PlacetoPayStrategy::class,
                ],
            ],
            'type' => TransactionTraceTypes::SMS_CORE_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        TransactionTrace::factory()->create([
            'content' => [
                'response' => [
                    'code' => ResponseCodes::SUCCESSFUL,
                    'date' => now()->toDateTimeString(),
                    'reason' => 0,
                    'status' => Status::ST_OK,
                    'message' => null,
                    'setting' => AcsSetting::OTP_STRATEGY,
                    'strategy' => PlacetoPayStrategy::class,
                ],
            ],
            'type' => TransactionTraceTypes::SMS_CORE_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        TransactionTrace::factory()->create([
            'content' => [
                'error' => [
                    'code' => '1',
                    'errorDescription' => '',
                    'setting' => AcsSetting::OTP_STRATEGY,
                    'strategy' => PlacetoPayStrategy::class,
                ],
            ],
            'type' => TransactionTraceTypes::SMS_CORE_SERVICE,
            'transaction_id' => $transaction->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk()
            ->assertSeeTextInOrder([
            trans('authentications.services.otp_strategy.core.request'),
            trans('authentications.services.otp_strategy.core.response'),
            trans('authentications.services.otp_strategy.core.error'),
        ]);
    }

    /**
     * @test
     */
    public function itCanDisplayQuestionnaireServiceTraces(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $this->createQuestionnaireTraces($transaction);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk();
        $traces = [
            trans('authentications.services.questionnaire.get_questionnaire.request'),
            trans('authentications.services.questionnaire.get_questionnaire.response'),
            trans('authentications.services.questionnaire.get_questionnaire.error'),
            trans('authentications.services.questionnaire.get_questionnaire.error'),
            trans('authentications.services.questionnaire.get_questionnaire.error'),
            trans('authentications.services.questionnaire.verify_answers.request'),
            trans('authentications.services.questionnaire.verify_answers.response.passed'),
            trans('authentications.services.questionnaire.verify_answers.response.didnt_pass'),
            trans('authentications.services.questionnaire.verify_answers.error'),
            trans('authentications.services.questionnaire.verify_answers.error'),
            trans('authentications.services.questionnaire.verify_answers.error'),
            trans('authentications.services.questionnaire.get_answers.request'),
            trans('authentications.services.questionnaire.get_answers.response'),
            trans('authentications.services.questionnaire.get_answers.error'),
            trans('authentications.services.questionnaire.get_answers.error'),
            trans('authentications.services.questionnaire.get_answers.error'),
        ];

        $dom = new DOMAnalyzer($response->getContent());
        $body = $dom->getBody();
        foreach ($traces as $trace) {
            $this->assertStringContainsString($trace, $body);
        }
    }

    /**
     * @test
     */
    public function itCanDisplayOutOfBandServiceTraces(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $this->createOutOfBandTraces($transaction);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk();

        $traces = [
            trans('authentications.services.out_of_band.create_session.request'),
            trans('authentications.services.out_of_band.create_session.response'),
            trans('authentications.services.out_of_band.create_session.error'),
            trans('authentications.services.out_of_band.create_session.error'),
            trans('authentications.services.out_of_band.create_session.error'),
            trans('authentications.services.out_of_band.verify_session.request'),
            trans('authentications.services.out_of_band.verify_session.response.passed'),
            trans('authentications.services.out_of_band.verify_session.response.didnt_pass'),
            trans('authentications.services.out_of_band.verify_session.error'),
            trans('authentications.services.out_of_band.verify_session.error'),
            trans('authentications.services.out_of_band.verify_session.error'),
        ];

        $dom = new DOMAnalyzer($response->getContent());
        $body = $dom->getBody();
        foreach ($traces as $trace) {
            $this->assertStringContainsString($trace, $body);
        }
    }

    /**
     * @test
     */
    public function authorizedUserCanSeeATransactionUsingNumericIdentifier(): void
    {
        /** @var User $user */
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', ['transaction' => $transaction->id]));

        $response->assertOk()
            ->assertViewIs('admin.transactions.show');
    }

    /**
     * @test
     */
    public function messagesInTracesHaveTranslations(): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();
        $transaction = $this->createTransaction(MessageVersion::V_220);

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction))
            ->assertOk()
            ->assertViewIs('admin.transactions.show')
            ->assertViewHas('messages', function ($messages) use ($transaction) {
                $mapped = DataElement::mapDataWithDataElementsDescription(
                    $transaction->messages()
                        ->get(['message'])
                        ->first()
                        ->toArray()['message'],
                    $transaction->franchise->brand
                );

                return reset($messages)['message'] == $mapped;
            });
    }

    /**
     * @test
     */
    public function anAuthorizedUserCanSeeAStatelessTransaction(): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220, [
            'trans_status' => null,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk()
            ->assertViewIs('admin.transactions.show');

        $dom = new DOMAnalyzer($response->getContent());

        $this->assertStringContainsString(trans('authentications.statuses.U.label'), $dom->getBody());
    }

    /**
     * @test
     */
    public function itCheckTransactionShowViewContentWithoutUpdateDateInTrace(): void
    {
        $user = UserHelper::withPermissions(Permissions::TRANSACTIONS_VIEW)->create();

        $transaction = $this->createTransaction(MessageVersion::V_220);

        $data = [
            'threeDSServerTransID' => $transaction->threeds_server_trans_id,
            'acsTransID' => $transaction->acs_trans_id,
            'dsTransID' => $transaction->ds_trans_id,
            'messageType' => MessageType::CREQ,
            'messageVersion' => $transaction->message_version,
            'sdkCounterStoA' => '111',
            'challengeWindowSize' => '03',
            'deviceChannel' => DeviceChannel::BRW,
            'messageCategory' => MessageCategory::PA,
        ];

        TransactionMessage::factory()->create([
            'transaction_id' => $transaction->id,
            'message_type' => MessageType::CREQ,
            'message' => MessageBuilderFactory::create($data)->toMessage(),
            'updated_at' => null,
        ]);

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('admin.transactions.show');

        $response->assertSeeText($transaction->getFormattedAmount());
        $response->assertSeeText($transaction->issuer->name);
        $response->assertSeeText($transaction->issuer->country->alpha_3_code);
        $response->assertSeeText($transaction->acquirer_bin);
        $response->assertSeeText($transaction->acs_trans_id);
        $response->assertSeeText($transaction->threeds_server_trans_id);
        $response->assertSeeText($transaction->ds_trans_id);
        $response->assertSeeText($transaction->sdk_trans_id);
        $response->assertSeeText($transaction->created_at->toDateString());
        $response->assertSeeText($transaction->created_at->toTimeString());
        $response->assertSeeText(__("fields.device_channel.{$transaction->aReq->deviceChannel}"));
        $response->assertSeeText(__("fields.message_category.{$transaction->aReq->messageCategory}"));

        $response->assertSeeText($transaction->aReq->homePhone['subscriber']);
        $response->assertSeeText($transaction->aReq->mobilePhone['subscriber']);
        $response->assertSeeText($transaction->aReq->workPhone['subscriber']);

        $response->assertSeeText($transaction->aReq->merchantName);
        $response->assertSeeText($transaction->aReq->mcc);
        $response->assertSeeText($transaction->country->alpha_3_code);

        $this->assertIsArray($transaction->aReq->acctInfo);

        $response->assertSeeText($transaction->country->alpha_3_code);
        $response->assertSeeText($transaction->aReq->shipAddrState);
        $response->assertSeeText($transaction->aReq->shipAddrCity);
        $response->assertSeeText($transaction->aReq->shipAddrPostCode);
    }

    /**
     * @test
     */
    public function itCheckTransactionWithoutAReqShowViewContent(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $transaction = $this->createTransaction(MessageVersion::V_220);

        TransactionMessage::where('transaction_id', $transaction->id)->delete();

        $erro = $this->createErrorMessage($transaction);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        $erroComponent = trans('authentications.component.error', [
            'causer' => 'A - ' . trans('authentications.component.' . $erro->message['errorComponent']),
        ]);

        $response->assertOk()
            ->assertSeeText('Error (Erro)')
            ->assertSeeText(strip_tags($erroComponent))
            ->assertSeeText($erro->message['errorDescription'])
            ->assertSeeText($erro->message['errorDetails'])
            ->assertSee(route('admin.transactions.index'))
            ->assertSee(route('admin.transactions.disputes.store', $transaction));
    }

    /**
     * @test
     */
    public function itDisplaysAuthenticationMethodsData(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        /** @var \App\Models\Challente $challenge */
        $challenge = Challenge::factory()
            ->passed()
            ->create();

        $challenge->setAuthenticationMethod(AcsUiType::SINGLE_SELECT);
        $challenge->pushAuthenticationMethod(AcsUiType::TEXT);
        $challenge->pushAuthenticationMethod(AcsUiType::OOB);
        $challenge->save();

        $transaction = $this->createTransaction(MessageVersion::V_220, ['challenge_id' => $challenge->id]);

        $response = $this->actingAs($user)
            ->get(route('admin.transactions.show', $transaction));

        DOMAnalyzer::load($response->getContent())
            ->assertBodyContains(trans('authentications.challenge_statuses.passed'))
            ->assertBodyContains(trans('authentications.methods.text'))
            ->assertBodyContains(trans('authentications.methods.oob'))
            ->assertBodyContains(trans('authentications.methods.single_select'));

    }

    /**
     * @test
     */
    public function itDisplaysAuthenticationMethodsDataTarget(): void
    {
        $user = UserHelper::withPermissions([
            Permissions::TRANSACTIONS_VIEW,
            Permissions::DISPUTES_CREATE,
        ])->create();

        $this->withAllowPolicy($user->currentProfile()->id, Issuer::class, 'issuers');

        $challenge = Challenge::factory()->create();

        $challenge->setAuthenticationMethod(AcsUiType::SINGLE_SELECT);
        $challenge->pushAuthenticationMethod(AcsUiType::TEXT);
        $challenge->pushAuthenticationMethod(AcsUiType::OOB);
        $challenge->save();

        $transaction = $this->createTransaction(MessageVersion::V_220, ['challenge_id' => $challenge->id]);

        $this->generateCardholderInformation($transaction->card);

        $cardholderTarget = new OTPTarget($transaction->card->cardholder);
        $cardholderTarget->setCurrentTarget([
            'value' => '3009998877',
            'type' => OTPTarget::PHONE_TYPE,
            'country' => 'CO',
        ]);

        $challenge->setTarget($cardholderTarget);
        $challenge->save();

        $response = $this->actingAs($user)->get(route('admin.transactions.show', $transaction));

        DOMAnalyzer::load($response->getContent())
            ->assertBodyContains(trans('challenge.titles.otp_messaging_channel'))
            ->assertBodyContains(trans('authentications.methods.oob'))
            ->assertBodyContains(trans('authentications.methods.text'))
            ->assertBodyContains(trans('authentications.methods.single_select'))
            ->assertBodyContains(trans('challenge.otp_messaging_channel_type.phone'));
    }

    public static function disputeIndicatorProvider(): array
    {
        return [
            'open dispute' => [DisputesStatus::OPEN],
            'closed dispute' => [DisputesStatus::CLOSE],
            'canceled dispute' => [DisputesStatus::CANCELED],
        ];
    }
}
