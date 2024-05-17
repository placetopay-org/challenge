<?php

namespace App\Actions;

use App\Contracts\Services\IPLocationContract;
use App\Models\Country;

class GetGeolocationInfoAction
{
    public static function execute(string $ip, IPLocationContract $ipLocation): array
    {
        $ipInformation = [];

        $ipLocation->setIp($ip);

        if ($ip && $ipLocation->isPublic()) {
            $response = $ipLocation->getResponse();

            $ipInformation['ip'] = $response->ip();

            $ipInformation['countryCode'] = Country::where('alpha_2_code', $response->countryCode())
                ->get('name')->first()->name ?? $response->countryCode();

            $ipInformation['city'] = $response->city();
            $ipInformation['latitude'] = $response->latitude();
            $ipInformation['longitude'] = $response->longitude();
            $ipInformation['timezone'] = $response->timezone();
            $ipInformation['region'] = $response->region();
        }

        return $ipInformation;
    }
}