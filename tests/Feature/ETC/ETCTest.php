<?php

namespace Tests\Feature\Location;

use App\Models\Location\Location;
use App\Models\User;
use App\Models\ETC\ExternalTransportationCompany;
use Illuminate\Http\Response;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Tests\Traits\UserTrait;
use Illuminate\Support\Facades\DB;

class ETCTest extends ApiTestBase
{
    use UserTrait;

    protected $location;

    public function setUp()
    {
        parent::setUp();
        $this->email = $this->createTestFacilityAndUser(4)->email;
        $this->login();
    }

    /**
     * @group etc
     */
    public function testWeCanAddETC()
    {
        $etcData = $this->getETCData();
        $response = $this->postJsonRequest(route('etcs.store'), [
            'data' => [
                'type' => 'etc',
                'attributes' => $etcData,
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();
        $etcData['location'] = $this->getLocationData();
        $this->assertSame([
            'data' => [
                'type' => 'etcs',
                'id' => '3',
                'attributes' => $etcData,
                'links' => [
                    'self' => env('APP_URL') . '/etcs/3',
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group etc
     */
    public function testETCAccess()
    {
        $organizationTree = $this->createOrganizationTree();
        $etcData = $this->getETCData();
        // TODO: Validate location to be selected only from its own scope.
        $facility = $organizationTree['organizationOne']['facilities'][0]['facility'];
        $location = factory(Location::class)->make(['facility_id' => $facility->id]);
        $location->save(['unprotected' => true]);
        $etcData['facility_id'] = $facility->id;
        $etcData['location_id'] = $location->id;
        $ownScope = [
            2 => $this->getExpectedBehavior(1, 1, 1, 1),
            3 => $this->getExpectedBehavior(1, 1, 1, 1),
            4 => $this->getExpectedBehavior(1, 1, 1, 1),
            5 => $this->getExpectedBehavior(1, 1, 1, 1),
            6 => $this->getExpectedBehavior(0, 1),
        ];
        $foreignScope = [
            1 => $this->getExpectedBehavior(0, 2, 2, 2),
            2 => $this->getExpectedBehavior(0, 2, 2, 2),
            3 => $this->getExpectedBehavior(0, 2, 2, 2),
            4 => $this->getExpectedBehavior(0, 2, 2, 2),
            5 => $this->getExpectedBehavior(0, 2, 2, 2),
            6 => $this->getExpectedBehavior(0, 2, 2, 2),
        ];

        $usersInScope = array_merge(
            $organizationTree['organizationOne']['users'],
            $organizationTree['organizationOne']['facilities'][0]['users']
        );

        $usersNotInScope = array_merge(
            [User::withoutGlobalScopes()->where('role_id', 1)->get()->first()],
            $organizationTree['organizationOne']['facilities'][1]['users'],
            $organizationTree['organizationTwo']['users'],
            $organizationTree['organizationTwo']['facilities'][0]['users'],
            $organizationTree['organizationTwo']['facilities'][1]['users']
        );
        $this->checkAccess($usersInScope, $ownScope, $etcData);
        $this->checkAccess($usersNotInScope, $foreignScope, $etcData);
    }

    public function checkAccess($users, $scope, $etcData)
    {
        // CREATE
        foreach ($users as $user) {
            $this->logout();
            $this->login($user->email);
            $response = $this->postJsonRequest(route('etcs.store'), [
                'data' => [
                    'type' => 'etc',
                    'attributes' => $etcData,
                ]
            ]);
            if ($response->status() != $scope[$user->role_id]['create']) {
                $this->debugError($scope, $user, $response, 'create');
            }
            $response->assertStatus($scope[$user->role_id]['create']);
        }

        // UPDATE
        foreach ($users as $user) {
            $this->logout();
            $etcId = DB::table('external_transportation_companies')->insertGetId($etcData);
            $this->login($user->email);
            $response = $this->putJsonRequest(route('etcs.update', ['id' => $etcId]), [
                'data' => [
                    'type' => 'etc',
                    'attributes' => $etcData,
                ]
            ]);
            if ($response->status() != $scope[$user->role_id]['update']) {
                $this->debugError($scope, $user, $response, 'update');
            }
            $response->assertStatus($scope[$user->role_id]['update']);
        }

        // DELETE
        foreach ($users as $user) {
            $this->logout();
            $etcId = DB::table('external_transportation_companies')->insertGetId($etcData);
            $this->login($user->email);
            $response = $this->deleteJsonRequest(route('etcs.destroy', ['id' => $etcId]));
            if ($response->status() != $scope[$user->role_id]['delete']) {
                $this->debugError($scope, $user, $response, 'delete');
            }
            $response->assertStatus($scope[$user->role_id]['delete']);
        }
        $this->checkListAndRead($users, $scope, $etcData);
    }

    protected function checkListAndRead($users, $scope, $etcData)
    {
        // READ
        foreach ($users as $user) {
            $this->logout();
            $etcId = DB::table('external_transportation_companies')->insertGetId($etcData);
            $this->login($user->email);
            $response = $this->getJsonRequest(route('etcs.show', ['id' => $etcId]));

            if ($response->status() != $scope[$user->role_id]['read']) {
                $this->debugError($scope, $user, $response, 'read');
            }
            $response->assertStatus($scope[$user->role_id]['read']);
        }

        // LIST
        foreach ($users as $user) {
            $this->logout();
            $etcId = DB::table('external_transportation_companies')->insertGetId($etcData);
            $etcId = DB::table('external_transportation_companies')->insertGetId($etcData);
            $etcId = DB::table('external_transportation_companies')->insertGetId($etcData);
            $this->login($user->email);
            $response = $this->getJsonRequest(route('etcs.index'), ['facility_id' => $etcData['facility_id']]);
            $jsonData = $response->decodeResponseJson();
            if (JsonResponse::HTTP_OK != $scope[$user->role_id]['read']) {
                $this->assertCount(0, $jsonData['data']);
                continue;
            }
            $this->assertNotEquals(0, count($jsonData['data']));
        }
    }

    protected function debugError($scope, $user, $response, $type)
    {
        echo "\r\nExpected: " . $scope[$user->role_id][$type];
        echo "\r\nGot: " . $response->status();
        echo "\r\n Role id: " . $user->role_id;
        echo "\r\n User id: " . $user->id . "\r\n";
        print_r($response->decodeResponseJson());
    }

    protected function getExpectedBehavior($create = 0, $read = 0, $update = 0, $delete = 0)
    {
        $behavior = [
            'create' => $create ? JsonResponse::HTTP_CREATED : JsonResponse::HTTP_UNAUTHORIZED,
            'read' => $read ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNAUTHORIZED,
            'update' => $update ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNAUTHORIZED,
            'delete' => $delete ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNAUTHORIZED,
        ];
        if ($update == 2) {
            $behavior['update'] = JsonResponse::HTTP_NOT_FOUND;
        }
        if ($read == 2) {
            $behavior['read'] = JsonResponse::HTTP_NOT_FOUND;
        }
        if ($delete == 2) {
            $behavior['delete'] = JsonResponse::HTTP_NOT_FOUND;
        }
        return $behavior;
    }


    /**
     * @group etc
     */
    public function testWeCanGetETC()
    {
        $etcData = $this->getETCData();
        $etcId = DB::table('external_transportation_companies')->insertGetId($etcData);
        $etcData['location'] = $this->location->toArray();
        $response = $this->getJsonRequest(route('etcs.show', ['id' => $etcId]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $etcData['location'] = $this->getLocationData();
        $this->assertSame([
            'data' => [
                'type' => 'etcs',
                'id' => '3',
                'attributes' => $etcData,
                'links' => [
                    'self' => env('APP_URL') . '/etcs/3',
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group etc
     */
    public function testWeCanUpdateETC()
    {
        $etcData = $this->getETCData();
        $etcId = DB::table('external_transportation_companies')->insertGetId($etcData);
        $newName = $this->faker->name();
        $etcData['name'] = $newName;
        $response = $this->putJsonRequest(route('etcs.update', ['id' => $etcId]), [
            'data' => [
                'type' => 'etc',
                'attributes' => $etcData,
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $etcData['location'] = $this->getLocationData();
        $this->assertSame([
            'data' => [
                'type' => 'etcs',
                'id' => '3',
                'attributes' => $etcData,
                'links' => [
                    'self' => env('APP_URL') . '/etcs/3',
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group etc
     */
    public function testWeCanDeleteETC()
    {
        $etcData = $this->getETCData();
        $etcId = DB::table('external_transportation_companies')->insertGetId($etcData);
        $response = $this->deleteJsonRequest(route('etcs.destroy', ['id' => $etcId]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSoftDeleted('external_transportation_companies', ['id' => $etcId]);
    }

    /**
     * @group etc
     */
    public function testWeCanSortETCList()
    {
        $this->login('oa@silverpine.test');

        $testETCs = [
            [
                'name' => 'EverGreen Transportation Co.',
            ],
            [
                'name' => 'SilverPine Transportation Co.',
            ]
        ];

        for ($i = 0; $i < count($testETCs); $i++) {
            $testETCs[$i]['id'] =
                factory(ExternalTransportationCompany::class)
                    ->create($testETCs[$i] + [
                            'facility_id' => 2,
                        ])->id;
        }

        foreach (array_keys($testETCs[0]) as $sortingKey) {
            // Ascending order
            $this
                ->getJsonRequest(
                    route('etcs.index', ['facility_id' => 2, 'order_by' => $sortingKey, 'order' => 'ASC'])
                )
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testETCs[0][$sortingKey], $testETCs[1][$sortingKey]]);


            // Descending order
            $this
                ->getJsonRequest(
                    route('etcs.index', ['facility_id' => 2, 'order_by' => $sortingKey, 'order' => 'DESC'])
                )
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testETCs[1][$sortingKey], $testETCs[0][$sortingKey]]);
        }
    }

    /**
     * @group etc
     */
    public function testListETCs()
    {
        $etcData = $this->getETCData();
        for ($i = 0; $i < 3; $i++) {
            DB::table('external_transportation_companies')->insertGetId($etcData);
        }
        $response = $this->getJsonRequest(route('etcs.index'), ['facility_id' => $this->facility->id]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals(3, count($jsonData['data']));
    }

    /**
     * @group etc
     */
    public function testWeCanGotBadRequestForGetWithoutFacilityId()
    {
        $response = $this->getJsonRequest(route('etcs.index'));
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }


    /**
     * @group etc
     */
    public function testWeCanPaginateETCList()
    {
        $perPage = (new ExternalTransportationCompany())->getPerPage();
        $recordCount =  $perPage + 3;
        $lastPage = (int) ceil($recordCount / $perPage);

        // Bulk insert
        factory(ExternalTransportationCompany::class, $recordCount)->create($this->getETCData());

        // First page
        $this
            ->getJsonRequest(route('etcs.store', ['facility_id' => $this->facility->id, 'page' => 1]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($perPage, 'data')
            ->assertJsonFragment([
               'meta' => [
                   'pagination' => [
                       'count' => $perPage,
                       'current_page' => 1,
                       'total_pages' => $lastPage,
                       'per_page' => $perPage,
                       'total' => $recordCount
                   ]
               ]
            ]);

        // Last page
        $this
            ->getJsonRequest(
                route(
                    'etcs.store',
                    [
                        'facility_id' => $this->facility->id,
                        'page' => $lastPage
                    ]
                )
            )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($recordCount - $perPage, 'data')
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => $recordCount - $perPage,
                        'current_page' => $lastPage,
                        'total_pages' => $lastPage,
                        'per_page' => $perPage,
                        'total' => $recordCount
                    ]
                ]
            ]);
    }

    /**
     * @group etc
     */
    public function testWeCanGetETCListWithoutPaginate()
    {
        $perPage = (new ExternalTransportationCompany())->getPerPage();
        $recordCount =  $perPage + 3;

        // Bulk insert
        factory(ExternalTransportationCompany::class, $recordCount)->create($this->getETCData());

        $this
            ->getJsonRequest(route('etcs.store', ['facility_id' => $this->facility->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertDontSee('pagination')
            ->assertJsonCount($recordCount, 'data');
    }

    protected function getLocationData()
    {
        if (!$this->location) {
            return [];
        }
        return [
            'id' => $this->location->id,
            'name' => $this->location->name,
            'phone' => $this->location->phone,
            'address' => $this->location->address,
            'city' => $this->location->city,
            'state' => $this->location->state,
            'postcode' => $this->location->postcode,
            'facility_id' => $this->location->facility_id,
        ];
    }

    protected function getETCData()
    {
        $this->location = factory(Location::class)
            ->create(['facility_id' => $this->facility->id]);
        $emails = [];
        for ($i = 0; $i < 3; $i++) {
            $emails[] = $this->faker->email();
        }
        return [
            'name' => $this->faker->name(),
            'color_id' => array_keys(array_filter(Config::get('colors'), function ($color) {
                return $color['type'] === 'external';
            }))[0],
            'emails' => implode(',', $emails),
            'phone' => $this->faker->tollFreePhoneNumber(),
            'location_id' => $this->location->id,
            'facility_id' => $this->facility->id,
        ];
    }
}
