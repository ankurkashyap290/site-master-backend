<?php

namespace Tests\Feature\Location;

use App\Models\Location\Location;
use App\Models\Organization\Facility;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class LocationTest extends ApiTestBase
{
    public function setUp()
    {
        parent::setUp();
        $this->facility = Facility::withoutGlobalScopes()->first();
        $this->login('fa@silverpine.test');
    }

    /**
     * @group location
     */
    public function testWeCanAddLocation()
    {
        $locationDetails = $this->getLocationData();
        $response = $this->postJsonRequest(route('locations.store'), [
            'data' => [
                'type' => 'locations',
                'attributes' => $locationDetails,
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame([
            'data' => [
                'type' => 'locations',
                'id' => '6',
                'attributes' => $locationDetails,
                'links' => [
                    'self' => env('APP_URL') . '/locations/6',
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group location
     */
    public function testWeCanAddOneTimeLocation()
    {
        $locationDetails = $this->getLocationData();
        $this
            ->postJsonRequest(route('locations.store'), [
                'data' => [
                    'type' => 'locations',
                    'attributes' => $locationDetails + [
                        'one_time' => true,
                    ],
                ]
            ])
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonFragment([
                'data' => [
                    'type' => 'locations',
                    'id' => '6',
                    'attributes' => $locationDetails,
                    'links' => [
                        'self' => env('APP_URL') . '/locations/6',
                    ],
                ],
            ]);
        $this->assertDatabaseHas('locations', ['id' => '6', 'one_time' => true]);
    }

    /**
     * @group location
     */
    public function testRenameLocation()
    {
        $location = factory(Location::class)->create(['facility_id' => $this->facility->id]);
        $locationDetails = $this->getLocationData();
        $response = $this->putJsonRequest(route('locations.update', ['id' => $location->id]), [
            'data' => [
                'type' => 'locations',
                'attributes' => $locationDetails,
            ],
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();

        $this->assertSame([
            'data' => [
                'type' => 'locations',
                'id' => (string)$location->id,
                'attributes' => $locationDetails,
                'links' => [
                    'self' => env('APP_URL') . '/locations/' . $location->id,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group location
     */
    public function testDeleteLocation()
    {
        $location = factory(Location::class)->create(['facility_id' => $this->facility->id]);
        $response = $this->deleteJsonRequest(route('locations.destroy', ['id' => $location->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSoftDeleted('locations', ['id' => $location->id]);
    }

    /**
     * @group location
     */
    public function testGetCreatedLocation()
    {
        $locationDetails = $this->getLocationData();
        $location = factory(Location::class)->create($locationDetails);
        $response = $this->getJsonRequest(route('locations.show', ['id' => $location->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame([
            'data' => [
                'type' => 'locations',
                'id' => (string)$location->id,
                'attributes' => $locationDetails,
                'links' => [
                    'self' => env('APP_URL') . '/locations/' . $location->id,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group location
     */
    public function testWeCanSortLocationList()
    {
        $this->login('oa@silverpine.test');

        $testLocations = [
            [
                'name' => 'Dr. Craig B Ellis',
                'phone' => '708-382-1113',
                'address' => '2776 Flinderation Road',
                'city' => 'Arlington Heights',
                'state' => 'IL',
                'postcode' => '60005',
            ],
            [
                'name' => 'Mrs. Catherine S Chenier',
                'phone' => '817-289-6802',
                'address' => '788 Oliver Street',
                'city' => 'Dallas',
                'state' => 'TX',
                'postcode' => '75201',
            ]
        ];

        for ($i = 0; $i < count($testLocations); $i++) {
            $testLocations[$i]['id'] =
                factory(Location::class)
                    ->create($testLocations[$i] + [
                        'facility_id' => 2,
                    ])
                    ->id;
        }

        foreach (array_keys($testLocations[0]) as $sortingKey) {
            // Ascending order
            $this
                ->getJsonRequest(
                    route('locations.index', ['facility_id' => 2, 'order_by' => $sortingKey, 'order' => 'ASC'])
                )
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testLocations[0][$sortingKey], $testLocations[1][$sortingKey]]);

            // Descending order
            $this
                ->getJsonRequest(
                    route('locations.index', ['facility_id' => 2, 'order_by' => $sortingKey, 'order' => 'DESC'])
                )
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testLocations[1][$sortingKey], $testLocations[0][$sortingKey]]);
        }
    }

    /**
     * @group location
     */
    public function testListLocations()
    {
        factory(Location::class, 3)
            ->create(['facility_id' => $this->facility->id]);
        $this
            ->getJsonRequest(route('locations.index'), ['facility_id' => $this->facility->id])
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonCount(6, 'data');
    }

    /**
     * @group location
     */
    public function testWeCanPaginateLocationList()
    {
        $perPage = (new Location())->getPerPage();
        $baseLocationCount = Location::where('one_time', 0)->count();
        $expectedCount =  $perPage + 3;
        $totalLocationCount = $baseLocationCount + $expectedCount;
        $lastPage = (int) ceil($totalLocationCount / $perPage);

        // Bulk insert
        factory(Location::class, $expectedCount)->create(
            ['facility_id' => $this->facility->id]
        );

        // First page
        $this
            ->getJsonRequest(
                route('locations.index', ['facility_id' => $this->facility->id, 'page' => 1])
            )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($perPage, 'data')
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => $perPage,
                        'current_page' => 1,
                        'total_pages' => $lastPage,
                        'per_page' => $perPage,
                        'total' => $totalLocationCount
                    ]
                ]
            ]);

        // Last page

        $this
            ->getJsonRequest(
                route('locations.index', ['facility_id' => $this->facility->id, 'page' => $lastPage])
            )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($totalLocationCount - $perPage, 'data')
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => $totalLocationCount - $perPage,
                        'current_page' => $lastPage,
                        'total_pages' => $lastPage,
                        'per_page' => $perPage,
                        'total' => $totalLocationCount
                    ]
                ]
            ]);
    }


    /**
     * @group location
     */
    public function testWeCanGetLocationListWithoutPaginate()
    {
        $perPage = (new Location())->getPerPage();
        $baseUserCount = Location::where('one_time', 0)->count();
        $expectedCount = $perPage + 3;

        // Bulk insert
        factory(Location::class, $expectedCount)->create(
            ['facility_id' => $this->facility->id]
        );

        $this
            ->getJsonRequest(
                route('locations.index', ['facility_id' => $this->facility->id])
            )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($baseUserCount + $expectedCount, 'data')
            ->assertDontSee('pagination');
    }

    /**
     * @group location
     */
    public function testWeCanSearchForLocation()
    {
        $this->login('fa@silverpine.test');
        $baseLocationCount = Location::where('one_time', 0)->count();
        $expectedCount = $baseLocationCount + 7;

        factory(Location::class, 5)->create(
            [
                'facility_id' => $this->facility->id,
            ]
        );

        // We create 2 test locations
        factory(Location::class)->create(
            [
                'facility_id' => $this->facility->id,
                'state' => 'Oregon',
                'name' => 'Test Location',
            ]
        );

        factory(Location::class)->create(
            [
                'facility_id' => $this->facility->id,
                'state' => 'Alabama',
                'name' => 'Test Location',
            ]
        );

        $this
            ->getJsonRequest(
                route('locations.index', ['facility_id' => $this->facility->id])
            )
            ->assertJsonCount($expectedCount, 'data');

        $this
            ->getJsonRequest(
                route('locations.index', ['facility_id' => $this->facility->id, 'search_key' => ''])
            )
            ->assertJsonCount($expectedCount, 'data');

        $this
            ->getJsonRequest(
                route('locations.index', ['facility_id' => $this->facility->id, 'search_key' => 'Oregon'])
            )
            ->assertJsonCount(1, 'data');

        $this
            ->getJsonRequest(
                route('locations.index', ['facility_id' => $this->facility->id, 'search_key' => 'Test'])
            )
            ->assertJsonCount(2, 'data');
    }

    /**
     * @group location
     * @group import
     */
    public function testWeCanImportLocationsAsFacilityAdmin()
    {
        $this->login('fa@silverpine.test');
        $locationCount = Location::count();
        $firstLocation = $this->getFirstImportedLocationData();
        $path = __DIR__ . '/src/good.csv';
        $file = new UploadedFile($path, 'good.csv', 'text/csv', null, null, true);
        $response = $this->post(route('locations.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertCount($locationCount + 10, Location::get());
        $this->assertCount(1, Location::where([
            ['name', $firstLocation['name']],
            ['phone', $firstLocation['phone']],
            ['address', $firstLocation['address']],
            ['city', $firstLocation['city']],
            ['state', $firstLocation['state']],
            ['postcode', $firstLocation['postcode']],
        ])->get());
    }

    /**
     * @group location
     * @group import
     */
    public function testWeCantImportLocationsAsNotAuthorizedUser()
    {
        $this->login('oa@silverpine.test');
        $locationCount = Location::count();
        $path = __DIR__ . '/src/good.csv';
        $file = new UploadedFile($path, 'good.csv', 'text/csv', null, null, true);
        $response = $this->post(route('locations.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $this->assertCount($locationCount, Location::get());
    }

    /**
     * @group location
     * @group import
     */
    public function testWeCantImportLocationsWithWrongExtension()
    {
        $locationCount = Location::count();
        $path = __DIR__ . '/src/wrong.extension';
        $file = new UploadedFile($path, 'wrong.extension', null, null, null, true);
        $response = $this->post(route('locations.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $this->assertSame(
            'Wrong file type given, please upload a CSV file.',
            $response->decodeResponseJson()['errors'][0]['detail']
        );
        $this->assertCount($locationCount, Location::get());
    }

    /**
     * @group location
     * @group import
     */
    public function testWeCantImportLocationsWhenSevenColumnsReceived()
    {
        $locationCount = Location::count();
        $path = __DIR__ . '/src/7_columns.csv';
        $file = new UploadedFile($path, '7_columns.csv', 'text/csv', null, null, true);
        $response = $this->post(route('locations.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $this->assertSame(
            'The file must contain 6 columns.',
            $response->decodeResponseJson()['errors'][0]['detail']
        );
        $this->assertCount($locationCount, Location::get());
    }

    /**
     * @group location
     * @group import
     */
    public function testWeCantImportLocationsWhenNamesAreLongerThanExpected()
    {
        $locationCount = Location::count();
        $path = __DIR__ . '/src/long_names.csv';
        $file = new UploadedFile($path, 'long_names.csv', 'text/csv', null, null, true);
        $response = $this->post(route('locations.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $this->assertCount(2, $response->decodeResponseJson()['errors']);
        $this->assertCount($locationCount, Location::get());
    }

    /**
     * Location Import test data
     * @return array
     */
    public function getFirstImportedLocationData()
    {
        return [
            'name' => 'Edgepulse',
            'phone' => '561-735-2239',
            'address' => '008 Everett Road',
            'city' => 'Lake Worth',
            'state' => 'FL',
            'postcode' => '33467',
        ];
    }

    /**
     * Get location data
     */
    protected function getLocationData(): array
    {
        return [
            'name' => $this->faker->streetName,
            'phone' => $this->faker->tollFreePhoneNumber,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postcode' => $this->faker->postcode,
            'facility_id' => $this->facility->id,
        ];
    }
}
