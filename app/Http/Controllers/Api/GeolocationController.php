<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\IPLocationContract;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeolocationController extends Controller
{
    public function getLocation(Request $request, IPLocationContract $ipLocation): JsonResponse
    {
        $ip = $request->input('ip');
        $ipLocation->setIp($ip);

        if ($ip && $ipLocation->isPublic()) {
            $response = $ipLocation->getResponse();

            $ipInformation = [];
            $ipInformation['ip'] = $response->ip();
            $ipInformation['countryCode'] = Country::where('alpha_2_code', $response->countryCode())->get('name')
                    ->first()->name ?? $response->countryCode();
            $ipInformation['city'] = $response->city();
            $ipInformation['latitude'] = $response->latitude();
            $ipInformation['longitude'] = $response->longitude();
            $ipInformation['timezone'] = $response->timezone();
            $ipInformation['region'] = $response->region();

            return response()->json(['information' => $ipInformation]);
        }

        return response()->json(['error' => 'IP is private or null' . ($ip ? ' [' . $ip . ']' : '')], 422);
    }
}
