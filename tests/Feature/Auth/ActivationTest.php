<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ActivationTest extends ApiTestBase
{
    private $organization;

    public function setUp()
    {
        parent::setUp();
        Mail::fake();
        $this->organization = factory(\App\Models\Organization\Organization::class)->make(['name' => 'Apple Clinics']);
        $this->organization->save(['unprotected' => true]);
        $this->login();
    }

    /**
     * @group activation
     */
    public function testWeGotActivationToken()
    {
        $firstName = $this->faker->firstName();
        $middleName = '';
        $lastName = $this->faker->lastName();
        $email = $this->faker->email();
        $response = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'users',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone' => null,
                        'role_id' => 2,
                        'color_id' => null,
                        'organization' => [
                            'id' => $this->organization['id']
                        ],
                        'facility' => [
                            'id' => null,
                        ]
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson('data');

        $this->assertNotEmpty(DB::table('user_activations')
            ->select('token')
            ->where('user_id', $jsonData['id'])
            ->first()->token);
    }

    /**
     * @group activation
     * @SuppressWarnings(PHPMD.ShortVariables)
     */
    public function testWeCanLoadActivableUser()
    {
        $firstName = $this->faker->firstName();
        $middleName = '';
        $lastName = $this->faker->lastName();
        $email = $this->faker->email();
        $response = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'users',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone' => null,
                        'role_id' => 2,
                        'organization' => [
                            'id' => $this->organization['id']
                        ],
                        'facility' => [
                            'id' => null,
                        ]
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson('data');

        $token = DB::table('user_activations')
            ->select('token')
            ->where('user_id', $jsonData['id'])
            ->first()->token;

        $this->logout();

        $response = $this->postJsonRequest('api/activation/activable-user', [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'id' => $jsonData['id'],
                    'token' => $token
                ]
            ]
        ]);

        $jsonData = $response->decodeResponseJson();

        $id = $jsonData['data']['id'];
        $this->assertSame([
            'data' => [
                'type' => 'users',
                'id' => $id,
                'attributes' => [
                    'name' => "{$firstName} {$lastName}",
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => '',
                    'role_id' => 2,
                    'color_id' => null,
                    'organization' => [
                        'id' => null,
                        'name' => '',
                        'budget' => 0,
                        'facility_limit' => null,
                    ],
                    'facility' => [
                        'id' => null,
                        'name' => '',
                        'budget' => 0,
                        'organization_id' => null,
                        'timezone' => '',
                        'location_id' => null,
                    ]
                ],
                'links' => [
                    'self' => env('APP_URL') . '/users/' . $id,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group activation
     */
    public function testWeCanActivateUser()
    {
        $firstName = $this->faker->firstName();
        $middleName = null;
        $lastName = $this->faker->lastName();
        $email = $this->faker->email();
        $response = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'users',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone' => null,
                        'role_id' => 2,
                        'organization' => [
                            'id' => $this->organization['id']
                        ],
                        'facility' => [
                            'id' => null,
                        ]
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson('data');

        $token = DB::table('user_activations')
            ->select('token')
            ->where('user_id', $jsonData['id'])
            ->first()->token;

        $this->logout();

        $response = $this->postJsonRequest('api/activation/activate-user', [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'id' => $jsonData['id'],
                    'token' => $token,
                    'password' => 'secret'
                ]
            ]
        ]);

        $jsonData = $response->decodeResponseJson();

        $this->assertNotEmpty($jsonData['data']['attributes']['access_token']);
    }
}
