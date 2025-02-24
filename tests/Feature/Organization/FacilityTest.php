<?php

namespace Tests\Feature\Organization\Facility;

use App\Models\Organization\Facility;
use App\Models\Organization\Organization;
use App\Models\User;
use Illuminate\Http\Response;
use Psy\Util\Json;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use Tests\Traits\UserTrait;

class FacilityTest extends ApiTestBase
{
    use UserTrait;

    public function setUp()
    {
        parent::setUp();
        $this->login();
    }

    /**
     * @group facility
     */
    public function testWeCanAddFacility()
    {
        $facilityName = $this->faker->company;
        $this
            ->postJsonRequest(
                route('facilities.store'),
                [
                    'data' => [
                        'type' => 'facilities',
                        'attributes' => [
                            'name' => $facilityName,
                            'timezone' => 'America/Detroit',
                            'organization_id' => 1,
                        ]
                    ]
                ]
            )
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonFragment([
                'data' => [
                    'type' => 'facilities',
                    'id' => '4',
                    'attributes' => [
                        'name' => $facilityName,
                        'budget' => 0,
                        'organization_id' => 1,
                        'timezone' => 'America/Detroit',
                        'location_id' => null,
                    ],
                    'links' => [
                        'self' => env('APP_URL') . '/facilities/4',
                    ],
                ],
            ]);
    }

    /**
     * @group facility
     */
    public function testWeCanAddFacilityWithBudget()
    {
        $facilityName = $this->faker->company;

        $this
            ->postJsonRequest(
                route('facilities.store'),
                [
                    'data' => [
                        'type' => 'facilities',
                        'attributes' => [
                            'name' => $facilityName,
                            'organization_id' => 1,
                            'timezone' => 'America/Detroit',
                            'budget' => 5000,
                        ]
                    ]
                ]
            )
            ->assertStatus(JsonResponse::HTTP_CREATED)

            ->assertJsonFragment([
                'data' => [
                    'type' => 'facilities',
                    'id' => '4',
                    'attributes' => [
                        'name' => $facilityName,
                        'budget' => 5000,
                        'organization_id' => 1,
                        'timezone' => 'America/Detroit',
                        'location_id' => null,
                    ],
                    'links' => [
                        'self' => env('APP_URL') . '/facilities/4',
                    ],
                ],
            ]);
    }

    /**
     * @group facility
     */
    public function testWeCantAddFacilityWithoutLoggedIn()
    {
        $this->logout();
        $facilityName = $this->faker->company();
        $response = $this->postJson(
            route('facilities.store'),
            [
                'data' => [
                    'type' => 'facilities',
                    'attributes' => [
                        'name' => $facilityName,
                        'organization_id' => 1,
                        'location_id' => 1,
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group facility
     */
    public function testCantAddFacilityWithSameName()
    {
        $this->login('oa@silverpine.test');
        $facilityName = $this->faker->company();

        $this
            ->postJsonRequest(
                route('facilities.store'),
                [
                    'data' => [
                        'type' => 'facilities',
                        'attributes' => [
                            'name' => $facilityName,
                            'organization_id' => 1,
                            'timezone' => 'America/Detroit',
                        ]
                    ]
                ]
            )
            ->assertStatus(JsonResponse::HTTP_CREATED);

        $this
            ->postJsonRequest(
                route('facilities.store'),
                [
                    'data' => [
                        'type' => 'facilities',
                        'attributes' => [
                            'name' => $facilityName,
                            'organization_id' => 1,
                            'timezone' => 'America/Detroit',
                        ]
                    ]
                ]
            )
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group facility
     */
    public function testCantAddFacilityOverLimit()
    {
        $this->login('oa@goldenyears.test');

        $facilityName = $this->faker->company();
        $this
            ->postJsonRequest(
                route('facilities.store'),
                [
                    'data' => [
                        'type' => 'facilities',
                        'attributes' => [
                            'name' => $facilityName,
                            'organization_id' => 2,
                            'timezone' => 'America/Detroit',
                        ]
                    ]
                ]
            )
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * @group facility
     */
    public function testCantAddWithLongerNameThanFiveHundred()
    {
        $facilityName = $this->longText;
        $response = $this->postJsonRequest(
            route('facilities.store'),
            [
                'data' => [
                    'type' => 'facilities',
                    'attributes' => [
                        'name' => $facilityName,
                        'organization_id' => 1,
                        'location_id' => 1,
                        'timezone' => 'America/Detroit',
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group facility
     */
    public function testRenameFacility()
    {
        $facility = factory(Facility::class)->create();
        $user = factory(User::class)->make(['role_id' => 2, 'facility_id' => $facility->id]);
        $user->save(['unprotected' => true]);
        $this->login($user->email);
        $response = $this->putJsonRequest(
            route('facilities.update', ['id' => $facility->id]),
            [
                'data' => [
                    'type' => 'facilities',
                    'attributes' => [
                        'name' => 'Golden House',
                        'location_id' => 1,
                    ],
                ],
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame('Golden House', $jsonData['data']['attributes']['name']);
    }

    /**
     * @group facility
     */
    public function testWeCanChangeTimezone()
    {
        $this->login('fa@silverpine.test');
        $facility = auth()->user()->facility;

        $this
            ->getJsonRequest(
                route('facilities.show', ['id' => $facility->id])
            )
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonCount(1)
            ->assertJsonFragment(
                [
                    'timezone' => 'America/Los_Angeles',
                ]
            );

        $this
            ->putJsonRequest(
                route('facilities.update', ['id' => $facility->id]),
                [
                    'data' => [
                        'type' => 'facilities',
                        'attributes' => [
                            'name' => $facility->name,
                            'location_id' => $facility->location_id,
                            'timezone' => 'America/Detroit',
                        ],
                    ],
                ]
            )
            ->assertStatus(JsonResponse::HTTP_OK);
    }

    /**
     * @group facility
     */
    public function testAddBudgetToFacility()
    {
        $this->createTestFacilityAndUser();
        $user = factory(User::class)->make([
            'role_id' => 3,
            'organization_id' => $this->organization->id
        ]);
        $user->save(['unprotected' => true]);
        $this->login($user->email);
        $response = $this->putJsonRequest(
            route('facilities.update', ['id' => $this->facility->id]),
            [
                'data' => [
                    'type' => 'facilities',
                    'attributes' => [
                        'name' => $this->facility->name,
                        'location_id' => $this->facility->location_id,
                        'budget' => 5000,
                    ],
                ],
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame(5000, $jsonData['data']['attributes']['budget']);
    }

    /**
     * @group facility
     */
    public function testDeleteFacility()
    {
        $facility = factory(Facility::class)->create();
        $user = factory(User::class)->make(['role_id' => 2, 'facility_id' => $facility->id]);
        $user->save(['unprotected' => true]);
        $this->login($user->email);
        $response = $this->deleteJsonRequest(
            route('facilities.destroy', ['id' => $facility->id])
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSoftDeleted('facilities', ['id' => $facility->id]);
    }

    /**
     * @group facility
     */
    public function testGetCreatedFacility()
    {
        $facilityName = $this->faker->company();
        $facility = factory(Facility::class)->create([
            'name' => $facilityName,
        ]);
        $user = factory(User::class)->make(['role_id' => 2, 'facility_id' => $facility->id]);
        $user->save(['unprotected' => true]);
        $this->login($user->email);
        $response = $this->getJsonRequest(
            route('facilities.show', ['id' => $facility->id])
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($facilityName, $jsonData['data']['attributes']['name']);
    }

    /**
     * @group facility
     */
    public function testListAllFacility()
    {
        factory(Facility::class, 3)->create();
        $response = $this->getJsonRequest(
            route('facilities.index')
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();

        // With authentication user organization
        $this->assertSame(6, count($jsonData['data']));
    }

    /**
     * @group facility
     */
    public function testWeCanSortFacilityList()
    {
        $this->login('oa@silverpine.test');

        $testFacilities = [
            [
                'name' => 'GreenPine',
                'timezone' => 'America/Detroit'
            ],
            [
                'name' => 'SilverWood',
                'timezone' => 'America/Los_Angeles'
            ]
        ];

        for ($i = 0; $i < count($testFacilities); $i++) {
            // We need to sort by id already
            $testFacilities[$i]['id'] =
                factory(Facility::class)
                    ->create($testFacilities[$i] + [
                            'organization_id' => 1,
                        ])
                    ->id;
        }

        foreach (array_keys($testFacilities[0]) as $sortingKey) {
            $value1 = strpos($testFacilities[0][$sortingKey], '/') === false ?:
                explode('/', $testFacilities[0][$sortingKey])[1];

            $value2 = strpos($testFacilities[1][$sortingKey], '/') === false ?:
                explode('/', $testFacilities[1][$sortingKey])[1];

            // Ascending order
            $this
                ->getJsonRequest(
                    route('facilities.index', ['order_by' => $sortingKey, 'order' => 'ASC'])
                )
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$value1, $value2]);

            // Descending order
            $this
                ->getJsonRequest(
                    route('facilities.index', ['order_by' => $sortingKey, 'order' => 'DESC'])
                )
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$value2, $value1]);
        }
    }

    /**
     * @group facility
     */
    public function testWeCanPaginateFacilityList()
    {
        $perPage = (new Facility())->getPerPage();
        $baseFacilityCount = Facility::withoutGlobalScopes()->count();
        $expectedCount =  $perPage + 3;
        $totalFacilityCount = $baseFacilityCount + $expectedCount;
        $lastPage = (int) ceil($totalFacilityCount / $perPage);

        // Bulk insert
        factory(Facility::class, $expectedCount)->create();

        // First page
        $this
            ->getJsonRequest(route('facilities.index', ['page' => 1]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($perPage, 'data')
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => $perPage,
                        'current_page' => 1,
                        'total_pages' => $lastPage,
                        'per_page' => $perPage,
                        'total' => $totalFacilityCount
                    ]
                ]
            ]);

        // Last page
        $this
            ->getJsonRequest(route('facilities.index', ['page' => $lastPage]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($totalFacilityCount - $perPage, 'data')
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => $totalFacilityCount - $perPage,
                        'current_page' => $lastPage,
                        'total_pages' => $lastPage,
                        'per_page' => $perPage,
                        'total' => $totalFacilityCount
                    ]
                ]
            ]);
    }

    /**
     * @group facility
     */
    public function testWeCanGetFacilityListWithoutPaginate()
    {
        $perPage = (new Facility())->getPerPage();
        $baseFacilityCount = Facility::withoutGlobalScopes()->count();
        $recordCount = $perPage + 3;

        // Bulk insert
        factory(Facility::class, $recordCount)->create([
            'name' => $this->faker->company(),
            'organization_id' => 1,
            'budget' => 5000,
        ]);

        $this
            ->getJsonRequest(route('facilities.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertDontSee('pagination')
            ->assertJsonCount($baseFacilityCount + $recordCount, 'data');
    }

    /**
     * @group facility
     */
    public function testListFacilityByOrganizationId()
    {
        $bananaMedics = factory(Organization::class)->create([
            'name' => 'Banana Medics'
        ]);

        factory(Facility::class)->create([
            'organization_id' => $bananaMedics->id,
        ]);
        $user = factory(User::class)->make(['role_id' => 2, 'organization_id' => $bananaMedics->id]);
        $user->save(['unprotected' => true]);
        $this->login($user->email);
        $response = $this->getJsonRequest(route('facilities.index'));

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame(1, count($jsonData['data']));
    }
}
