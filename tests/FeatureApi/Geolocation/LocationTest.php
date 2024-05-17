<?php

namespace Tests\FeatureApi\Geolocation;

use App\Contracts\Services\IPLocationContract;
use Facades\App\Helpers\UserHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\Feature\Mocks\IPApiProviderMock;
use Tests\Feature\Mocks\IPLocationServiceMock;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function canGetTheIpInformation(): void
    {
        $user = UserHelper::create();

        $this->swap(IPLocationContract::class, new IPLocationServiceMock());

        Passport::actingAs($user);

        $response = $this
            ->getJson(route('api.ip.location', ['ip' => IPApiProviderMock::DATA['ip']]));

        $response->assertOk();
        $response->assertJsonStructure(['information']);
        $ipInformation = $response->json('information');

        $this->assertEquals(IPApiProviderMock::DATA['ip'], $ipInformation['ip']);
        $this->assertEquals(IPApiProviderMock::DATA['countryCode'], $ipInformation['countryCode']);
        $this->assertEquals(IPApiProviderMock::DATA['region'], $ipInformation['region']);
        $this->assertEquals(IPApiProviderMock::DATA['city'], $ipInformation['city']);
        $this->assertEquals(IPApiProviderMock::DATA['timezone'], $ipInformation['timezone']);
        $this->assertEquals(IPApiProviderMock::DATA['latitude'], $ipInformation['latitude']);
        $this->assertEquals(IPApiProviderMock::DATA['longitude'], $ipInformation['longitude']);
    }

    /**
     * @test
     */
    public function itChecksUnprocessableIp(): void
    {
        $user = UserHelper::create();

        $ip = $this->faker->localIpv4;

        Passport::actingAs($user);

        $response = $this
            ->getJson(route('api.ip.location', ['ip' => $ip]));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonFragment([
                'error' => "IP is private or null [{$ip}]",
            ]);
    }
}
