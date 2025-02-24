<?php

namespace Tests\Feature\Config;

use App\Facades\Config;
use Illuminate\Http\JsonResponse;
use Tests\Feature\ApiTestBase;

class ConfigTest extends ApiTestBase
{
    /**
     * @group config
     */
    public function testConfigCanBeListed()
    {
        $response = $this->get('api/config');
        $response->assertStatus(JsonResponse::HTTP_OK);
        $responseJson = $response->json();
        $this->assertCount(count(Config::get('exportable')), $responseJson);
        $this->assertArrayHasKey('frontend', $responseJson);
        $this->assertArrayHasKey('roles', $responseJson);
        $this->assertArrayHasKey('equipment', $responseJson);
        $this->assertArrayHasKey('colors', $responseJson);
        $this->assertArrayHasKey('transport_type', $responseJson);
        $this->assertArrayHasKey('transportation_type', $responseJson);
        $this->assertArrayHasKey('driver_status', $responseJson);
        $this->assertArrayHasKey('timezones', $responseJson);
        $this->assertArrayHasKey('jwt', $responseJson);
        $this->assertArrayHasKey('sentry', $responseJson);
    }
}
