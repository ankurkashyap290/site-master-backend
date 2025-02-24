<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Organization\Facility;
use App\Models\Organization\Organization;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class AuthApiTest extends ApiTestBase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @group userauth
     */
    public function testLoginWithWrongParams()
    {
        $response = $this->postJsonRequest(route('auth.login'), [
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'email' => 'test@example.com',
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);

        $response = $this->postJsonRequest(route('auth.login'), [
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'email' => $this->email,
                    'test' => 'test',
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group userauth
     */
    public function testFailLogin()
    {
        $response = $this->postJsonRequest(route('auth.login'), [
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'email' => 'test@example.com',
                    'password' => 'wrongpass',
                ]
            ]
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group userauth
     */
    public function testWeCantLoginWithDisabledUser()
    {
        $user = User::withoutGlobalScopes()->where('email', 'fa@silverpine.test')->first();

        $user->delete(['unprotected' => true]);

        $response = $this->postJsonRequest(route('auth.login'), [
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'email' => 'fa@silverpine.test',
                    'password' => $this->password,
                ]
            ]
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group userauth
     */
    public function testWeCantLoginToDisabledFacility()
    {
        $facility = Facility::withoutGlobalScopes()->first();
        $facility->delete(['unprotected' => true]);

        $response = $this->postJsonRequest(route('auth.login'), [
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'email' => 'fa@silverpine.test',
                    'password' => $this->password,
                ]
            ]
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group userauth
     */
    public function testWeCantLoginToDisabledOrganization()
    {
        $organization = Organization::withoutGlobalScopes()->first();
        $organization->delete(['unprotected' => true]);

        $response = $this->postJsonRequest(route('auth.login'), [
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'email' => 'oa@silverpine.test',
                    'password' => $this->password,
                ]
            ]
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group userauth
     */
    public function testSuccessLogin()
    {
        $response = $this->postJsonRequest(route('auth.login'), [
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'email' => $this->email,
                    'password' => $this->password,
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonArray = $response->decodeResponseJson();
        $this->assertEquals(1, $jsonArray['data']['id']);
        $this->assertEquals($this->email, $jsonArray['data']['attributes']['email']);
    }

    /**
     * @group userauth
     */
    public function testSuccessLoginWithPolicies()
    {
        $this->email = 'ad@silverpine.test';
        $response = $this->postJsonRequest(route('auth.login'), [
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'email' => $this->email,
                    'password' => $this->password,
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonArray = $response->decodeResponseJson();
        $this->assertEquals(6, $jsonArray['data']['id']);
        $this->assertEquals($this->email, $jsonArray['data']['attributes']['email']);
        $this->assertCount(9, $jsonArray['data']['attributes']['policies']);
    }

    /**
     * @group userauth
     */
    public function testLoginGettingTimeoutBlocked()
    {
        $wrongLoginData = [
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'email' => $this->email,
                    'password' => 'wrongPassword',
                ]
            ]
        ];
        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJsonRequest(route('auth.login'), $wrongLoginData);
            $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
            $jsonArray = $response->decodeResponseJson();
            $this->assertEquals('Invalid password!', $jsonArray['errors'][0]['detail']);
        }
        $response = $this->postJsonRequest(route('auth.login'), $wrongLoginData);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $jsonArray = $response->decodeResponseJson();
        $this->assertEquals(
            'Too many login attempts! Please try again in 15 minutes.',
            $jsonArray['errors'][0]['detail']
        );
    }
}
