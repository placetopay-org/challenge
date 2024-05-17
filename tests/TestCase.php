<?php

namespace Tests;

use App\Models\User;
use ErrorException;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\DeviceChannel;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageCategory;
use PlacetoPay\ThreeDsSecureBase\Constants\Common\MessageVersion;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;
    use CreatesApplication;

    public const PROTOCOL_VERSIONS = [MessageVersion::V_210, MessageVersion::V_220];
    public const DEVICE_CHANNELS = ['01', '02', '03'];
    public const MESSAGE_TYPES = ['AReq', 'ARes', 'CReq', 'CRes', 'RReq', 'RRes', 'PReq', 'PRes', 'Erro'];

    public const ACQUIRER_MERCHANT_ID = '9876543210001';
    public const ACQUIRER_BIN = '000000999';

    public const ECI = '05';

    public const THREEDS_REQUESTOR_AUTHENTICATION_IND = '01';
    public const THREEDS_REQUESTOR_ID = '6456';
    public const THREEDS_REQUESTOR_NAME = 'EMVCo 3DS Test Requestor';
    public const THREEDS_SERVER_REF_NUMBER = '3DS_LOA_SER_PPFU_020100_00008';
    public const THREEDS_REQUESTOR_URL = 'http://www.google.com';
    public const THREEDS_SERVER_OPERATOR_ID = '1jpeeLAWgGFgS1Ri9tX9';
    public const THREEDS_SERVER_TRANS_ID = '8a880dc0-d2d2-4067-bcb1-b08d1690b26e';

    public const THREEDS_SERVER_URL = 'http://www.google.com';

    public const FRICTIONLESS_ACCT_NUMBER = '4444444444444';
    public const CHALLENGE_ACCT_NUMBER = '4444444444441';

    public const MCC = '7922';
    public const ACC_TYPE = '03';
    public const BROAD_INFO = '{"message":"TLS 1.x will be turned off starting summer 2019"}';
    public const MERCHANT_COUNTRY_CODE = '840';
    public const MERCHANT_NAME = 'Ticket Service';

    public const PURCHASE_AMOUNT = '101';
    public const PURCHASE_CURRENCY = '840';
    public const PURCHASE_EXPONENT = '2';
    public const PURCHASE_DATE = '20170316141312';

    public const RECURRING_EXPIRY = '20180131';
    public const RECURRING_FREQUENCY = '6';

    public const SDK_APP_ID = 'dbd64fcb-c19a-4728-8849-e3d50bfdde39';
    public const SDK_EPHEM_PUB_KEY = [
        'kty' => 'EC',
        'crv' => 'P-256',
        'x' => '6bz1jCgbKg3gZx2cm_o-qo3_LANILUW8TPfKPAEuAtk',
        'y' => '9x751EdhlWvpiMpACrhPZIYkuewwZZ0ugaTX-YV3AEM',
    ];
    public const SDK_MAX_TIMEOUT = '10';
    public const SDK_REFERENCE_NUMBER = '3DS_LOA_SDK_PPFU_020100_00007';
    public const SDK_TRANS_ID = 'b2385523-a66c-4907-ac3c-91848e8c0067';

    public const BROWSER_ACCEPT_HEADER = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
    public const BROWSER_JAVA_ENABLED = true;
    public const BROWSER_LANGUAGE = 'en';
    public const BROWSER_COLOR_DEPTH = '48';
    public const BROWSER_SCREEN_HEIGHT = '400';
    public const BROWSER_SCREEN_WIDTH = '600';
    public const BROWSER_TZ = '0';
    public const BROWSER_USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0';

    public const DS_TRANS_ID = 'bd2cbad1-6ccf-48e3-bb92-bc9961bc011e';
    public const DS_REFERENCE_NUMBER = 'DS_LOA_DIS_PPFU_020100_00010';

    public const ACS_CHALLENGE_MANDATED = 'Y';
    public const ACS_RENDERING_TYPE = [
        'acsInterface' => '01',
        'acsUiTemplate' => '02',
    ];
    public const ACS_SIGNED_CONTENT = 'eyJhbGciOiJQUzI1NiIsIng1YyI6Ik1JSURlVENDQW1HZ0F3SUJBZ0lRYlM0QzRCU...';

    public const AUTHENTICATION_VALUE = 'qØ\0HQí{$ÇH`á± Å';

    public const TRANS_TYPE = '01';

    public const SHIP_ADDR_STATE = 'CO';
    public const SHIP_ADDR_COUNTRY = '840';

    public const CARDHOLDER_INFO = 'Additional authentication is needed for this transaction, please contact (Issuer Name) at xxx-xxx-xxxx.';

    public const DEVICE_INFO = 'ew0KCSJEViI6ICIxLjAiLA0KCSJERCI6IHsNCgkJIkMwMDEiOiAiQW5kcm9pZCIsDQoJCSJDMDAyIjogIkhUQyBPbmVfTTgiLA0KCQkiQzAwNCI6ICI1LjAuMSIsDQoJCSJDMDA1IjogImVuX1VTIiwNCgkJIkMwMDYiOiAiRWFzdGVybiBTdGFuZGFyZCBUaW1lIiwNCgkJIkMwMDciOiAiMDY3OTc5MDMtZmI2MS00MWVkLTk0YzItNGQyYjc0ZTI3ZDE4IiwNCgkJIkMwMDkiOiAiSm9obidzIEFuZHJvaWQgRGV2aWNlIg0KCX0sDQoJIkRQTkEiOiB7DQoJCSJDMDEwIjogIlJFMDEiLA0KCQkiQzAxMSI6ICJSRTAzIg0KCX0sDQoJIlNXIjogWyJTVzAxIiwgIlNXMDQiXQ0KfQ0K';

    public const MESSAGE_EXTESION = [
        [
            'name' => 'extensionField1',
            'id' => 'ID1',
            'criticalityIndicator' => true,
            'data' => [
                'valueOne' => 'value',
            ],
        ],
        [
            'name' => 'extensionField2',
            'id' => 'ID2',
            'criticalityIndicator' => true,
            'data' => [
                'valueOne' => 'value1',
                'valueTwo' => 'value2',
            ],
        ],
        [
            'name' => 'sharedData',
            'id' => 'ID3',
            'criticalityIndicator' => false,
            'data' => [
                'value3' => 'IkpTT05EYXRhIjogew0KImRhdGExIjogInNvbWUgZGF0YSIsDQoiZGF0YTIiOiAic29tZSBvdGhlciBkYXRhIg0KfQ==',
            ],
        ],
    ];

    public const DEVICE_RENDER_OPTIONS = [
        'sdkInterface' => '03',
        'sdkUiType' => ['01', '02', '03', '04', '05'],
    ];

    public const ISO_CODE_DEFAULT = '840';

    protected User $defaulUser;

    public function deviceInfo($data = []): string
    {
        $deviceInfo = [
            'DV' => '1.0',
            'DD' => [
                'C001' => 'Android',
                'C002' => 'HTC One_M8',
                'C004' => '8.1',
                'C005' => 'en_US',
                'C006' => 'Eastern Standard Time',
                'C007' => '06797903-fb61-41ed-94c2-4d2b74e27d18',
                'C009' => "John's Android Device",
            ],
            'DPNA' =>  [
                'C010' => 'RE01',
                'C011' => 'RE03',
            ],
            'SW' => [
                ['SW01', 'SW04'],
            ],
        ];

        $deviceInfo = array_replace_recursive($deviceInfo, $data);

        return base64_encode(json_encode($deviceInfo, true));
    }

    private static function buildDataFromCurrentBuilder($deviceChannel, $messageCategory): array
    {
        return self::buildDataFromBuilder($deviceChannel, $messageCategory, static::TEST_MESSAGE_BUILDER_IMPLEMENTATION);
    }

    private static function buildDataFromBuilder($deviceChannel, $messageCategory, $builder): array
    {
        $builder = new $builder([], $deviceChannel, $messageCategory);
        $fields = $builder->getRequiredFields();

        $data = [];

        foreach ($fields as $field) {
            $data[$field] = '';
        }

        $replacements = [
            'threeDSCompInd' => 'Y',
            'threeDSRequestorAuthenticationInd' => self::THREEDS_REQUESTOR_AUTHENTICATION_IND,
            'threeDSRequestorID' => self::THREEDS_REQUESTOR_ID,
            'threeDSRequestorName' => self::THREEDS_REQUESTOR_NAME,
            'threeDSRequestorURL' => self::THREEDS_REQUESTOR_URL,
            'threeDSServerRefNumber' => self::THREEDS_SERVER_REF_NUMBER,
            'threeDSServerTransID' => (string)Str::uuid(),
            'threeDSServerURL' => self::THREEDS_SERVER_URL,
            'acquirerBIN' => self::ACQUIRER_BIN,
            'acquirerMerchantID' => self::ACQUIRER_MERCHANT_ID,
            'acctNumber' => self::FRICTIONLESS_ACCT_NUMBER,
            'deviceChannel' => $deviceChannel,
            'mcc' => self::MCC,
            'merchantCountryCode' => self::MERCHANT_COUNTRY_CODE,
            'merchantName' => self::MERCHANT_NAME,
            'messageCategory' => $messageCategory,
            'messageType' => ($builder::MESSAGE)::MESSAGE_TYPE,
            'messageVersion' => static::TEST_MESSAGE_VERSION,
            'purchaseAmount' => self::PURCHASE_AMOUNT,
            'purchaseCurrency' => self::PURCHASE_CURRENCY,
            'purchaseExponent' => self::PURCHASE_EXPONENT,
            'purchaseDate' => self::PURCHASE_DATE,
            'sdkAppID' => self::SDK_APP_ID,
            'sdkEphemPubKey' => self::SDK_EPHEM_PUB_KEY,
            'sdkMaxTimeout' => self::SDK_MAX_TIMEOUT,
            'sdkReferenceNumber' => self::SDK_REFERENCE_NUMBER,
            'sdkTransID' => self::SDK_TRANS_ID,
            'browserAcceptHeader' => self::BROWSER_ACCEPT_HEADER,
            'browserJavaEnabled' => self::BROWSER_JAVA_ENABLED,
            'browserLanguage' => self::BROWSER_LANGUAGE,
            'browserColorDepth' => self::BROWSER_COLOR_DEPTH,
            'browserScreenHeight' => self::BROWSER_SCREEN_HEIGHT,
            'browserScreenWidth' => self::BROWSER_SCREEN_WIDTH,
            'browserTZ' => self::BROWSER_TZ,
            'browserUserAgent' => self::BROWSER_USER_AGENT,
            'notificationURL' => 'https://notification-url.com',
            'browserJavascriptEnabled' => false,
            'deviceRenderOptions' => self::DEVICE_RENDER_OPTIONS,
        ];

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $replacements)) {
                $data[$key] = $replacements[$key];
            }
        }

        return $data;
    }

    public static function requiredFieldsProvider(): array
    {
        $provider = [];

        $_data = self::handleDataMethod(DeviceChannel::APP, MessageCategory::PA);

        while (($value = current($_data)) !== false) {
            $data = $_data;
            unset($data[key($_data)]);
            $provider[key($_data)] = [key($_data), $data];
            next($_data);
        }

        return $provider;
    }

    /**
     * @param mixed $name
     * @param mixed $args
     * @throws ErrorException
     */
    public static function __callStatic($name, $args)
    {
        if ($name == 'handleDataMethod') {
            switch (count($args)) {
                case 2:
                    return self::buildDataFromCurrentBuilder(...$args);
                case 3:
                    return self::buildDataFromBuilder(...$args);
            }
        }

        throw new ErrorException('Call to undefined method ' . __CLASS__ . '::' . $name);
    }
}
