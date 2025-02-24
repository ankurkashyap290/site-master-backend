<?php

namespace Tests\Feature\User;

use App\Mail\ResetPasswordEmail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use App\Models\Color;
use App\Models\User;
use App\Models\Organization\Organization;
use App\Models\Organization\Facility;
use Illuminate\Support\Facades\Hash;

class UserTest extends ApiTestBase
{
    private $organization;
    private $facility;

    public function setUp()
    {
        parent::setUp();
        $this->organization = Organization::withoutGlobalScopes()->first();
        $this->facility = Facility::withoutGlobalScopes()->first();
        $this->login();
    }

    /**
     * Data provider for creating users
     */
    public function createProvider()
    {
        $roles = $this->config('roles');
        $provider = include 'userProviders/createProvider.php';
        return $provider($roles);
    }

    /**
     * @group user
     * @dataProvider createProvider
     */
    public function testUserCanBeAdded($authEmail, $roleId, $organizationId, $facilityId, $responseStatus)
    {
        $this->login($authEmail);

        $firstName = $this->faker->firstName();
        $middleName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $email = $this->faker->email();
        $phone = $this->faker->phoneNumber();
        $response = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'name' => $firstName . (string)$middleName . $lastName,
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone' => $phone,
                        'role_id' => $roleId,
                        'organization' => [
                            'id' => $organizationId,
                        ],
                        'facility' => [
                            'id' => $facilityId,
                        ]
                    ]
                ]
            ]
        );

        $response->assertStatus($responseStatus);

        if ($responseStatus == JsonResponse::HTTP_CREATED) {
            $jsonData = $response->decodeResponseJson();

            $id = $jsonData['data']['id'];
            $this->assertSame([
                'data' => [
                    'type' => 'users',
                    'id' => $id,
                    'attributes' => [
                        'name' => "{$firstName} {$middleName} {$lastName}",
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone' => $phone,
                        'role_id' => $roleId,
                        'color_id' => null,
                        'organization' => [
                            'id' => $this->organization['id'],
                            'name' => $this->organization['name'],
                            'budget' => 0,
                            'facility_limit' => 3,
                        ],
                        'facility' => [
                            'id' => $facilityId ?: null,
                            'name' => $facilityId ? $this->facility['name'] : '',
                            'budget' => 0,
                            'organization_id' => $facilityId ? $this->organization['id'] : null,
                            'timezone' => $facilityId ? $this->facility['timezone'] : '',
                            'location_id' => $facilityId ? $this->facility['location_id'] : null,
                        ]
                    ],
                    'links' => [
                        'self' => env('APP_URL') . '/users/' . $id,
                    ],
                ],
            ], $jsonData);
        }
    }

    /**
     * @group user
     * @group color
     */
    public function testWeCanAddMasterUserWithColor()
    {
        $color = Color::findOrFail(1);
        $firstName = $this->faker->firstName();
        $middleName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $email = $this->faker->email();
        $user = factory(User::class)->make([
            'role_id' => 2,
            'organization_id' => $this->organization['id'],
            'facility_id' => null,
        ]);
        $user->save(['unprotected' => true]);
        $this->login($user->email);
        $response = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'role_id' => 5,
                        'color_id' => $color->id,
                        'organization' => [
                            'id' => $this->organization['id'],
                        ],
                        'facility' => [
                            'id' => $this->facility['id'],
                        ]
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();
        $id = $jsonData['data']['id'];
        $this->assertSame([
            'data' => [
                'type' => 'users',
                'id' => $id,
                'attributes' => [
                    'name' => "{$firstName} {$middleName} {$lastName}",
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => '',
                    'role_id' => 5,
                    'color_id' => $color->id,
                    'organization' => [
                        'id' => $this->organization['id'],
                        'name' => $this->organization['name'],
                        'budget' => 0,
                        'facility_limit' => 3,
                    ],
                    'facility' => [
                        'id' => $this->facility['id'],
                        'name' => $this->facility['name'],
                        'budget' => 0,
                        'organization_id' => (int)$this->facility['organization_id'],
                        'timezone' => $this->facility['timezone'],
                        'location_id' => $this->facility['location_id'],
                    ]
                ],
                'links' => [
                    'self' => env('APP_URL') . '/users/' . $id,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group user
     * @group color
     */
    public function testWeCantAddMasterUserWithWrongColorId()
    {
        $firstName = $this->faker->firstName();
        $middleName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $email = $this->faker->email();
        $response = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'role_id' => 5,
                        'color_id' => 0,
                        'organization' => [
                            'id' => $this->organization['id']
                        ],
                        'facility' => [
                            'id' => $this->facility['id'],
                        ]
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group user
     * @group color
     */
    public function testWeCanAddMasterUserAfterAlreadyDeletedOnce()
    {
        $this->login('fa@silverpine.test');

        $userAttributes = [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'role_id' => 5,
            'color_id' => 1,
            'organization' => [
                'id' => $this->organization['id']
            ],
            'facility' => [
                'id' => $this->facility['id'],
            ]
        ];

        $response = $this
            ->postJsonRequest(
                route('users.store'),
                [
                    'data' => [
                        'type' => 'user',
                        'attributes' => $userAttributes,
                    ]
                ]
            )
            ->assertStatus(JsonResponse::HTTP_CREATED);

        $userId = $response->decodeResponseJson()['data']['id'];

        $this
            ->deleteJsonRequest(
                route('users.destroy', ['id' => $userId])
            )
            ->assertStatus(JsonResponse::HTTP_OK);

        $this
            ->postJsonRequest(
                route('users.store'),
                [
                    'data' => [
                        'type' => 'user',
                        'attributes' => $userAttributes,
                    ]
                ]
            )
            ->assertStatus(JsonResponse::HTTP_CREATED);
    }

    /**
     * @group user
     */
    public function testWeCantAddUserWithoutBeingLoggedIn()
    {
        $userName = $this->faker->name();
        $email = $this->faker->email();
        $this->logout();
        $response = $this->postJson(
            route('users.store'),
            [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'name' => $userName,
                        'email' => $email,
                        'role_id' => 1,
                        'organization' => [
                            'id' => Organization::withoutGlobalScopes()->first()->id,
                        ],
                        'facility' => [
                            'id' => null,
                        ]
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group user
     */
    public function testCantAddUserWithSameEmail()
    {
        $firstName = $this->faker->firstName();
        $middleName = '';
        $lastName = $this->faker->lastName();
        $email = $this->faker->email();
        $response = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'user',
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

        $response2 = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone' => null,
                        'role_id' => 2,
                        'organization' => [
                            'id' => $this->organization['id']
                        ]
                    ]
                ]
            ]
        );
        $response2->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group user
     */
    public function testCantAddInvalidEmail()
    {
        $firstName = $this->faker->firstName();
        $middleName = '';
        $lastName = $this->faker->lastName();
        $email = $this->faker->text();
        $response = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'role_id' => 1,
                        'organization' => [
                            'id' => $this->organization['id']
                        ]
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group user
     */
    public function testCantAddLessParam()
    {
        $response = $this->postJsonRequest(
            route('users.store'),
            [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'first_name' => $this->faker->firstName()
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Data provider for updating users
     */
    public function updateProvider()
    {
        $roles = $this->config('roles');
        $provider = include 'userProviders/updateProvider.php';
        return $provider($roles);
    }

    /**
     * @group user
     * @dataProvider updateProvider
     */
    public function testRenameUser($authEmail, $roleId, $organizationId, $facilityId, $responseStatus)
    {
        $this->login($authEmail);

        $firstName = $this->faker->firstName();
        $middleName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $user = factory(User::class)->make([
            'role_id' => $roleId,
            'organization_id' => $organizationId,
            'facility_id' => $facilityId,
        ]);
        $user->save(['unprotected' => true]);

        $response = $this->putJsonRequest(
            route('users.update', ['id' => $user->id]),
            [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'role_id' => $roleId,
                        'phone' => '',
                    ]
                ]
            ]
        );

        $response->assertStatus($responseStatus);

        if ($responseStatus == JsonResponse::HTTP_OK) {
            $jsonData = $response->decodeResponseJson();
            $this->assertSame($firstName, $jsonData['data']['attributes']['first_name']);
            $this->assertSame($middleName, $jsonData['data']['attributes']['middle_name']);
            $this->assertSame($lastName, $jsonData['data']['attributes']['last_name']);
        }
    }

    /**
     * @group user
     * @group color
     */
    public function testChangeColor()
    {
        $firstName = $this->faker->firstName();
        $middleName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $user = factory(User::class)->make([
            'color_id' => 2,
            'role_id' => 5,
            'organization_id' => Organization::first()->id,
        ]);
        $user->save(['unprotected' => true]);
        $this->login($user->email);
        $response = $this->putJsonRequest(
            route('users.update', ['id' => $user->id]),
            [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'role_id' => '5',
                        'color_id' => 1,
                    ]
                ]
            ]
        );

        $jsonData = $response->decodeResponseJson();
        $response->assertStatus(JsonResponse::HTTP_OK);

        $this->assertSame(1, $jsonData['data']['attributes']['color_id']);
    }

     /**
     * @group user
     */
    public function testWeCantChangeEmail()
    {
        $user = factory(User::class)->create([
            'role_id' => 1,
            'organization_id' => Organization::first()->id
        ]);
        $response = $this->putJsonRequest(route('users.update', ['id' => $user->id]), [
            'data' => [
                'type' => 'user',
                'attributes' => [
                    'email' => $this->faker->email()
                ],
            ]
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Data provider for deleting users
     */
    public function deleteProvider()
    {
        $roles = $this->config('roles');
        $provider = include 'userProviders/deleteProvider.php';
        return $provider($roles);
    }

    /**
     * @group user
     * @dataProvider deleteProvider
     */
    public function testDeleteUser($authEmail, $roleId, $organizationId, $facilityId, $responseStatus)
    {
        $this->login($authEmail);

        $user = factory(User::class)->make([
            'role_id' => $roleId,
            'organization_id' => $organizationId,
            'facility_id' => $facilityId,
        ]);
        $user->save(['unprotected' => true]);

        $response = $this->deleteJsonRequest(route('users.destroy', ['id' => $user->id]));
        $response->assertStatus($responseStatus);
        if ($responseStatus == JsonResponse::HTTP_OK) {
            $this->assertSoftDeleted('users', ['id' => $user->id]);
        }
    }

    /**
     * @group user
     */
    public function testGetCreatedUser()
    {
        $firstName = $this->faker->firstName();
        $middleName = '';
        $lastName = $this->faker->lastName();
        $user = factory(User::class)->create([
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'role_id' => 1,
            'organization_id' => Organization::first()->id
        ]);
        $response = $this->getJsonRequest(route('users.show', ['id' => $user->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($firstName, $jsonData['data']['attributes']['first_name']);
        $this->assertSame($middleName, $jsonData['data']['attributes']['middle_name']);
        $this->assertSame($lastName, $jsonData['data']['attributes']['last_name']);
    }

    /**
     * Data provider for listing users
     */
    public function listProvider()
    {
        $roles = $this->config('roles');
        $provider = include 'userProviders/listProvider.php';
        return $provider($roles);
    }

    /**
     * @group user
     * @dataProvider listProvider
     */
    public function testListAllUsers($authEmail, $count)
    {
        $this->login($authEmail);

        $response = $this->getJsonRequest(route('users.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($count, count($jsonData['data']));
    }

    /**
     * @group user
     */
    public function testWeCanPaginateUserList()
    {
        $this->login('oa@silverpine.test');
        $perPage = (new User())->getPerPage();
        $baseUserCount = User::count();
        $expectedCount =  $perPage + 3;
        $totalUserCount = $baseUserCount + $expectedCount;
        $lastPage = (int) ceil($totalUserCount / $perPage);

        factory(User::class, $expectedCount)->create([
            'first_name' => $this->faker->firstName,
            'middle_name' => '',
            'last_name' => $this->faker->lastName,
            'role_id' => 4,
            'organization_id' => Organization::first()->id
        ]);

        // First page
        $this
            ->getJsonRequest(route('users.index', ['page' => 1]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($perPage, 'data')
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => $perPage,
                        'current_page' => 1,
                        'total_pages' => $lastPage,
                        'per_page' => $perPage,
                        'total' => $totalUserCount
                    ]
                ]
            ]);

        // Last page
        $this
            ->getJsonRequest(route('users.index', ['page' => $lastPage]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($totalUserCount - $perPage, 'data')
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => $totalUserCount - $perPage,
                        'current_page' => $lastPage,
                        'total_pages' => $lastPage,
                        'per_page' => $perPage,
                        'total' => $totalUserCount
                    ]
                ]
            ]);
    }

    /**
     * @group user
     */
    public function testWeCanSortUserList()
    {
        $this->login('oa@silverpine.test');

        $testUsers = [
            [
                'first_name' => 'Jane',
                'role_id' => 4,
                'email' => 'jane.doe@example.com',
            ],
            [
                'first_name' => 'John',
                'role_id' => 5,
                'email' => 'john.doe@example.com',
            ],
        ];

        for ($i = 0; $i < count($testUsers); $i++) {
            $testUsers[$i]['id'] =
                factory(User::class)
                    ->create($testUsers[$i] + [
                        'organization_id' => Organization::first()->id,
                        'facility_id' => 2,
                    ])
                ->id;
        }

        foreach (array_keys($testUsers[0]) as $field) {
            // Ascending order
            $this
                ->getJsonRequest(route('users.index', ['facility_id' => 2, 'order_by' => $field, 'order' => 'ASC']))
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testUsers[0][$field], $testUsers[1][$field]]);

            // Descending order
            $this
                ->getJsonRequest(route('users.index', ['facility_id' => 2, 'order_by' => $field, 'order' => 'DESC']))
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testUsers[1][$field], $testUsers[0][$field]]);
        }
    }

    /**
     * @group user
     */
    public function testWeCanGetUserListWithoutPaginate()
    {
        $this->login('oa@silverpine.test');
        $perPage = (new User())->getPerPage();
        $baseUserCount = User::count();
        $recordCount = $perPage + 3;

        // Bulk insert
        factory(User::class, $recordCount)->create([
            'first_name' => $this->faker->firstName,
            'middle_name' => '',
            'last_name' => $this->faker->lastName,
            'role_id' => 4,
            'organization_id' => Organization::first()->id
        ]);

        $this
            ->getJsonRequest(route('users.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertDontSee('pagination')
            ->assertJsonCount($baseUserCount + $recordCount, 'data');
    }

    /**
     * @group user
     */
    public function testListUsersByOrganizationId()
    {
        $response = $this->getJsonRequest(route('users.index'), ['organization_id' => 1]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame(6, count($jsonData['data']));

        $response = $this->getJsonRequest(route('users.index'), ['organization_id' => 2]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame(1, count($jsonData['data']));
    }

    /**
     * @group user
     */
    public function testListUsersByOrganizationScope()
    {
        for ($i = 0; $i < 3; $i++) {
            factory(User::class)->create([
                'first_name' => $this->faker->firstName(),
                'middle_name' => '',
                'last_name' => $this->faker->lastName(),
                'role_id' => 1,
                'organization_id' => $this->organization['id']
            ]);
        }

        // log in with Silver Pine user
        $this->login('oa@silverpine.test');
        $response = $this->getJsonRequest(route('users.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame(9, count($jsonData['data']));

        // log in with Golden Years user
        $this->login('oa@goldenyears.test');
        $response = $this->getJsonRequest(route('users.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame(1, count($jsonData['data']));
    }

    /**
     * @group user
     */
    public function testListUsersByRoleId()
    {
        for ($i = 0; $i < 3; $i++) {
            factory(User::class)->create([
                'first_name' => $this->faker->firstName(),
                'middle_name' => '',
                'last_name' => $this->faker->lastName(),
                'role_id' => 2,
                'organization_id' => Organization::first()->id
            ]);
        }
        $response = $this->getJsonRequest(route('users.index'), ['role_ids' => 2]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame(5, count($jsonData['data']));
    }

    /**
     * @group user
     */
    public function testListUsersByRoleIdAndOrganizationId()
    {
        $bananaMedics = factory(Organization::class)->create([
            'name' => 'Banana Medics'
        ]);

        factory(User::class)->make([
            'first_name' => $this->faker->firstName(),
            'middle_name' => '',
            'last_name' => $this->faker->lastName(),
            'role_id' => 2,
            'organization_id' => Organization::first()->id
        ])->save(['unprotected' => true]);

        factory(User::class)->make([
            'first_name' => $this->faker->firstName(),
            'middle_name' => '',
            'last_name' => $this->faker->lastName(),
            'role_id' => 2,
            'organization_id' => $bananaMedics['id'],
        ])->save(['unprotected' => true]);

        $user = factory(User::class)->make([
            'first_name' => $this->faker->firstName(),
            'middle_name' => '',
            'last_name' => $this->faker->lastName(),
            'role_id' => 3,
            'organization_id' => $bananaMedics['id'],
            'password' => Hash::make($this->password),
        ]);
        $user->save(['unprotected' => true]);

        $this->login($user->email);

        $response = $this->getJsonRequest(route('users.index'), [
            'role_ids' => 2,
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame(1, count($jsonData['data']));
    }

    /**
     * @group users
     * @group emails
     */
    public function testWeCanResetUserPasswordWithAllowedUser()
    {
        Mail::fake();

        $userForReset = User::where('email', 'mu@silverpine.test');
        $this->login('oa@silverpine.test');
        $response = $this->putJsonRequest(route('users.resetPassword', ['id' => $userForReset->first()->id]), []);

        $response->assertStatus(JsonResponse::HTTP_OK);

        $this->assertNull($userForReset->first()->password);

        Mail::assertSent(ResetPasswordEmail::class, function ($mail) use ($userForReset) {
            return $mail->hasTo($userForReset->first()->email);
        });

        $userForReset = User::where('email', 'mu2@silverpine.test');
        $this->login('fa@silverpine.test');
        $response = $this->putJsonRequest(route('users.resetPassword', ['id' => $userForReset->first()->id]), []);

        $response->assertStatus(JsonResponse::HTTP_OK);

        $this->assertNull($userForReset->first()->password);

        Mail::assertSent(ResetPasswordEmail::class, function ($mail) use ($userForReset) {
            return $mail->hasTo($userForReset->first()->email);
        });
    }

    /**
     * @group users
     * @group emails
     */
    public function testWeCantResetUserPasswordWithNotAllowedUser()
    {
        Mail::fake();

        $userForReset = User::where('email', 'mu2@silverpine.test');
        $this->login('mu@silverpine.test');
        $response = $this->putJsonRequest(route('users.resetPassword', ['id' => $userForReset->first()->id]), []);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);

        $this->assertNotNull($userForReset->first()->password);

        Mail::assertNotSent(ResetPasswordEmail::class);

        $userForReset = User::where('email', 'mu2@silverpine.test');
        $this->login('ad@silverpine.test');
        $response = $this->putJsonRequest(route('users.resetPassword', ['id' => $userForReset->first()->id]), []);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);

        $this->assertNotNull($userForReset->first()->password);

        Mail::assertNotSent(ResetPasswordEmail::class);
    }

    /**
     * @group users
     * @group emails
     */
    public function testWeCantResetUserPasswordInLoggedOut()
    {
        $this->logout();
        Mail::fake();

        $userForReset = User::withoutGlobalScopes()->where('email', 'mu2@silverpine.test');
        $response = $this->putJsonRequest(route('users.resetPassword', ['id' => $userForReset->first()->id]), []);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);

        $this->assertNotNull($userForReset->first()->password);
    }
}
