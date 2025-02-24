<?php

namespace Tests\Feature\Organization;

use App\Models\Organization\Organization;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class OrganizationTest extends ApiTestBase
{
    public function setUp()
    {
        parent::setUp();
        $this->login();
    }

    /**
     * @group organization
     */
    public function testWeCanAddOrganization()
    {
        $organizationName = $this->faker->company();
        $response = $this->postJsonRequest(route('organizations.store'), [
            'data' => [
                'type' => 'organization',
                'attributes' => [
                    'name' => $organizationName,
                    'facility_limit' => 20,
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame([
            'data' => [
                'type' => 'organizations',
                'id' => '3',
                'attributes' => [
                    'name' => $organizationName,
                    'budget' => 0,
                    'facility_limit' => 20,
                ],
                'links' => [
                    'self' => env('APP_URL') . '/organizations/3',
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group organization
     */
    public function testWeCanAddOrganizationWithBudget()
    {
        $organizationName = $this->faker->company();
        $response = $this->postJsonRequest(route('organizations.store'), [
            'data' => [
                'type' => 'organization',
                'attributes' => [
                    'name' => $organizationName,
                    'budget' => 5000,
                    'facility_limit' => 1,
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame([
            'data' => [
                'type' => 'organizations',
                'id' => '3',
                'attributes' => [
                    'name' => $organizationName,
                    'budget' => 5000,
                    'facility_limit' => 1,
                ],
                'links' => [
                    'self' => env('APP_URL') . '/organizations/3',
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group organization
     */
    public function testWeCantAddOrganizationWithoutBeingLoggedIn()
    {
        $this->logout();
        $organizationName = $this->faker->company;
        $response = $this->postJson(
            route('organizations.store'),
            [
                'data' => [
                    'type' => 'organization',
                    'attributes' => [
                        'name' => $organizationName,
                        'facility_limit' => 1,
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group organization
     */
    public function testWeCantAddOrganizationWithoutPermission()
    {
        $this->logout();
        $organizationName = $this->faker->company();
        $response = $this->postJsonRequest(route('organizations.store'), [
            'data' => [
                'type' => 'organization',
                'attributes' => [
                    'name' => $organizationName,
                    'facility_limit' => 1,
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group organization
     */
    public function testCantAddOrgWithSameName()
    {
        $organizationName = $this->faker->company();
        $response = $this->postJsonRequest(route('organizations.store'), [
            'data' => [
                'type' => 'organization',
                'attributes' => [
                    'name' => $organizationName,
                    'facility_limit' => 1,
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_CREATED);

        $response = $this->postJsonRequest(route('organizations.store'), [
            'data' => [
                'type' => 'organization',
                'attributes' => [
                    'name' => $organizationName,
                    'facility_limit' => 1,
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group organization
     */
    public function testRenameOrganization()
    {
        $organization = factory(Organization::class)->create(['name' => 'Not Evergreen Retirement Home']);
        $response = $this->putJsonRequest(route('organizations.update', ['id' => $organization->id]), [
            'data' => [
                'type' => 'organization',
                'attributes' => [
                    'name' => 'Evergreen Retirement Home',
                    'facility_limit' => 1,
                ],
            ],
        ]);

        $jsonData = $response->decodeResponseJson();
        $this->assertSame('Evergreen Retirement Home', $jsonData['data']['attributes']['name']);
        $response->assertStatus(JsonResponse::HTTP_OK);
    }

    /**
     * @group organization
     */
    public function testAddBudgetToOrganization()
    {
        $organization = factory(Organization::class)->create(['name' => 'Not Evergreen Retirement Home']);
        $user = factory(User::class)->make(['role_id' => 3, 'organization_id' => $organization->id]);
        $user->save(['unprotected' => true]);
        $this->login($user->email);
        $response = $this->putJsonRequest(route('organizations.update', ['id' => $organization->id]), [
            'data' => [
                'type' => 'organization',
                'attributes' => [
                    'name' => $organization->name,
                    'budget' => 5000,
                ],
            ],
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame(5000, $jsonData['data']['attributes']['budget']);
    }

    /**
     * @group organization
     */
    public function testMasterUserCantChangeName()
    {
        $organization = factory(Organization::class)->create(['name' => 'Not Evergreen Retirement Home']);
        $user = factory(User::class)->make(['role_id' => 3, 'organization_id' => $organization->id]);
        $user->save(['unprotected' => true]);
        $this->login($user->email);
        $response = $this->putJsonRequest(route('organizations.update', ['id' => $organization->id]), [
            'data' => [
                'type' => 'organization',
                'attributes' => [
                    'name' => 'Evergreen Retirement Home',
                    'budget' => 5000,
                ],
            ],
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group organization
     */
    public function testDeleteOrganization()
    {
        $organization = factory(Organization::class)->create();
        $response = $this->deleteJsonRequest(route('organizations.destroy', ['id' => $organization->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSoftDeleted('organizations', ['id' => $organization->id]);
    }

    /**
     * @group organization
     */
    public function testGetCreatedOrganization()
    {
        $organizationName = $this->faker->company();
        $organization = factory(Organization::class)->create(['name' => $organizationName]);
        $response = $this->getJsonRequest(route('organizations.show', ['id' => $organization->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($organizationName, $jsonData['data']['attributes']['name']);
    }

    /**
     * @group organization
     */
    public function testListOrganizations()
    {
        $response = $this->getJsonRequest(route('organizations.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $alreadyExists = count($jsonData['data']);

        factory(Organization::class)->create();
        factory(Organization::class)->create();
        factory(Organization::class)->create();
        $response = $this->getJsonRequest(route('organizations.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($alreadyExists + 3, count($jsonData['data']));
    }

    /**
     * @group organization
     */
    public function testWeCanSortOrganizationList()
    {
        $testOrganizations = [
            [
                'name' => 'GreenPine LLC.',
                'facility_limit' => 1,
            ],
            [
                'name' => 'SilverWood LLC.',
                'facility_limit' => 3,
            ]
        ];

        for ($i = 0; $i < count($testOrganizations); $i++) {
            $testOrganizations[$i]['id'] =
                $this
                    ->postJsonRequest(
                        route('organizations.store'),
                        [
                            'data' => [
                                'type' => 'organization',
                                'attributes' => [
                                    'name' => $testOrganizations[$i]['name'],
                                    'budget' => 5000,
                                    'facility_limit' => $testOrganizations[$i]['facility_limit'],
                                ]
                            ]
                        ]
                    )
                     ->decodeResponseJson()['data']['id'];
        }

        foreach (array_keys($testOrganizations[0]) as $sortingKey) {
            // Ascending order
            $this
                ->getJsonRequest(
                    route('organizations.index', ['order_by' => $sortingKey, 'order' => 'ASC'])
                )
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testOrganizations[0][$sortingKey], $testOrganizations[1][$sortingKey]]);

            // Descending order
            $this
                ->getJsonRequest(
                    route('organizations.index', ['order_by' => $sortingKey, 'order' => 'DESC'])
                )
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testOrganizations[1][$sortingKey], $testOrganizations[0][$sortingKey]]);
        }
    }

    /**
     * @group organization
     */
    public function testWeCanPaginateOrganizationList()
    {
        $perPage = (new Organization())->getPerPage();
        $baseRecordCount = Organization::withoutGlobalScopes()->count();
        $expectedCount =  $perPage + 3;
        $totalRecordCount = $baseRecordCount + $expectedCount;
        $lastPage = (int) ceil($totalRecordCount / $perPage);

        // Bulk insert
        factory(Organization::class, $expectedCount)->create();

        // First page
        $this
            ->getJsonRequest(route('organizations.index', ['page' => 1]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($perPage, 'data')
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => $perPage,
                        'current_page' => 1,
                        'total_pages' => $lastPage,
                        'per_page' => $perPage,
                        'total' => $totalRecordCount
                    ]
                ]
            ]);

        // Last page
        $this
            ->getJsonRequest(route('organizations.index', ['page' => $lastPage]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($totalRecordCount - $perPage, 'data')
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => $totalRecordCount - $perPage,
                        'current_page' => $lastPage,
                        'total_pages' => $lastPage,
                        'per_page' => $perPage,
                        'total' => $totalRecordCount
                    ]
                ]
            ]);
    }

    /**
     * @group organization
     */
    public function testWeCanGetOrganizationListWithoutPaginate()
    {
        $perPage = (new Organization())->getPerPage();
        $baseRecordCount = Organization::withoutGlobalScopes()->count();
        $recordCount = $perPage + 3;

        // Bulk insert
        factory(Organization::class, $recordCount)->create();

        $this
            ->getJsonRequest(route('organizations.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertDontSee('pagination')
            ->assertJsonCount($baseRecordCount + $recordCount, 'data');
    }
}
