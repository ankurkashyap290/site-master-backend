<?php

namespace Tests\Feature\Event;

use App\Models\Event\Event;
use App\Models\Location\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Tests\Feature\ApiTestBase;
use Tests\Traits\UserTrait;

class BiddingTest extends ApiTestBase
{
    use UserTrait;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->login('mu@silverpine.test');
    }

    /**
     * @group bidding
     */
    public function testListEventsWithoutDriver()
    {
        $response = $this->getJsonRequest(route('bidding.index'), ['status' => 'unassigned']);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(1, $jsonData['data']);
    }

    /**
     * @group bidding
     */
    public function testListEventsWithPendingDrivers()
    {
        $response = $this->getJsonRequest(route('bidding.index'), ['status' => 'pending']);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(1, $jsonData['data']);
    }

    /**
     * @group bidding
     */
    public function testListEventsWithAcceptedDriver()
    {
        $response = $this->getJsonRequest(route('bidding.index'), ['status' => 'accepted']);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(3, $jsonData['data']);
    }

    /**
     * @group bidding
     */
    public function testListEventsWithInvalidStatus()
    {
        $response = $this->getJsonRequest(route('bidding.index'), ['status' => 'non-existant']);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group bidding
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function testWeCanSortEventsWithAcceptedDriver()
    {
        $fromDate = Carbon::create()->startOfWeek()->format('Y-m-d');
        $endDate = Carbon::create()->endOfWeek()->format('Y-m-d');

        $response = $this->getJsonRequest(
            route(
                'bidding.index',
                [
                    'status' => 'accepted',
                    'fromDate' => $fromDate,
                    'toDate' => $endDate,
                ]
            )
        );
        $jsonData = $response->decodeResponseJson()['data'];

        for ($i = 0; $i < count($jsonData); $i++) {
            $idHelper[$i] = $i;
            $nameHelper[$i] = $jsonData[$i]['attributes']['name'];
            $dateHelper[$i] =
                    "{$jsonData[$i]['attributes']['date']} {$jsonData[$i]['attributes']['start_time']}";
        }

        sort($idHelper);
        sort($nameHelper);
        sort($dateHelper);

        $testData = [
            'id' =>
                array_splice($idHelper, 0, 2),
            'name' =>
                array_splice($nameHelper, 0, 2),
            'datetime' =>
                array_splice($dateHelper, 0, 2),
        ];

        foreach (array_keys($testData) as $sortingKey) {
            // Ascending order
            $response = $this
                ->getJsonRequest(
                    route(
                        'bidding.index',
                        [
                            'status' => 'accepted',
                            'fromDate' => $fromDate,
                            'toDate' => $endDate,
                            'facility_id' => 2,
                            'order_by' => $sortingKey,
                            'order' => 'ASC',
                        ]
                    )
                )
                ->assertStatus(Response::HTTP_OK);
            if ($sortingKey === 'datetime') {
                for ($i = 0; $i < 2; $i++) {
                    $response->assertSeeTextInOrder(
                        [
                            explode(' ', $testData[$sortingKey][0])[$i],
                            explode(' ', $testData[$sortingKey][1])[$i]
                        ]
                    );
                }
            } else {
                $response->assertSeeTextInOrder([$testData[$sortingKey][0], $testData[$sortingKey][1]]);
            }

            // Descending order
            $response = $this
                ->getJsonRequest(
                    route(
                        'bidding.index',
                        [
                            'status' => 'accepted',
                            'fromDate' => $fromDate,
                            'toDate' => $endDate,
                            'facility_id' => 2,
                            'order_by' => $sortingKey,
                            'order' => 'DESC'
                        ]
                    )
                )
                ->assertStatus(Response::HTTP_OK);

            if ($sortingKey === 'datetime') {
                for ($i = 0; $i < 2; $i++) {
                    $response->assertSeeTextInOrder(
                        [
                            explode(' ', $testData[$sortingKey][1])[$i],
                            explode(' ', $testData[$sortingKey][0])[$i]
                        ]
                    );
                }
            } else {
                $response->assertSeeTextInOrder([$testData[$sortingKey][1], $testData[$sortingKey][0]]);
            }
        }
    }

    /**
     * @group bidding
     */
    public function testWeCanPaginateUnassignedBiddingList()
    {
        $baseEventCount = Event::unassigned()->count();
        $perPage = (new Event())->getPerPage();
        $recordCount = $perPage + 3;
        $totalRecordCount = $baseEventCount + $recordCount;

        $totalPage = (int) ceil($totalRecordCount / $perPage);
        $lastPageItemCount = $totalRecordCount - ($totalPage - 1) * $perPage;

        // Bulk insert
        factory(Event::class, $recordCount)->create();

        // First page
        $this
            ->getJsonRequest(route('bidding.index'), ['status' => 'unassigned', 'page' => 1])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($perPage, 'data')
            ->assertJsonFragment([
                'pagination' => [
                    'total' => $totalRecordCount,
                    'count' => $perPage,
                    'per_page' => $perPage,
                    'current_page' => 1,
                    'total_pages' => $totalPage,
                ],
            ], 'meta');

        // Last page
        $this
            ->getJsonRequest(route('bidding.index'), ['status' => 'unassigned', 'page' => $totalPage])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($lastPageItemCount, 'data')
            ->assertJsonFragment([
                'pagination' => [
                    'total' => $totalRecordCount,
                    'count' => $lastPageItemCount,
                    'per_page' => $perPage,
                    'current_page' => $totalPage,
                    'total_pages' => $totalPage,
                ],
            ], 'meta');
    }

    /**
     * @group bidding
     */
    public function testWeCanGetUnassignedBiddingListWithoutPaginate()
    {
        $baseEventCount = Event::unassigned()->count();
        $perPage = (new Event())->getPerPage();
        $recordCount =  $perPage + 3;
        $totalRecordCount = $baseEventCount + $recordCount;

        // Bulk insert
        factory(Event::class, $recordCount)->create();

        $this
            ->getJsonRequest(route('bidding.index', ['status' => 'unassigned']))
            ->assertStatus(Response::HTTP_OK)
            ->assertDontSee('pagination')
            ->assertJsonCount($totalRecordCount, 'data');
    }

    /**
     * @group bidding
     */
    public function testWeCanAddAnInternalDriverToEvent()
    {
        $internalDriver = User::where('email', 'mu@silverpine.test')->first();
        $event = factory(Event::class)->create();

        $response = $this->postJsonRequest(
            "api/bidding/assign-drivers/{$event->id}",
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'internal',
                        'drivers' => [
                            [
                                'user_id' => $internalDriver->id,
                            ]
                        ]
                    ],
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals('accepted', $jsonData['data']['attributes']['status']);
        $this->assertCount(1, $jsonData['data']['attributes']['drivers']);
        $this->assertEquals($internalDriver->id, $jsonData['data']['attributes']['drivers'][0]['user_id']);
        $this->assertEquals('accepted', $jsonData['data']['attributes']['drivers'][0]['status']);
    }

    /**
     * @group bidding
     */
    public function testWeCantAddMultipleInternalDriversToEvent()
    {
        $internalDriver = User::where('email', 'mu@silverpine.test')->first();
        $internalDriver2 = User::where('email', 'mu2@silverpine.test')->first();
        $event = factory(Event::class)->create();

        $response = $this->postJsonRequest(
            "api/bidding/assign-drivers/{$event->id}",
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'internal',
                        'drivers' => [
                            [
                                'user_id' => $internalDriver->id,
                            ],
                            [
                                'user_id' => $internalDriver2->id,
                            ],
                        ]
                    ],
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group bidding
     */
    public function testWeCantAddInvalidInternalDriverToEvent()
    {
        $internalDriver = $this->createTestFacilityAndUser();
        $event = factory(Event::class)->create();
        $eventDataAttributes = $this->getEventDataAttributes();
        $response = $this->postJsonRequest(
            "api/bidding/assign-drivers/{$event->id}",
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'internal',
                        'drivers' => [
                            [
                                'user_id' => $internalDriver->id,
                            ]
                        ]
                    ] + $eventDataAttributes,
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group bidding
     */
    public function testWeCanAddExternalDriversToEvent()
    {
        $response = $this->postJsonRequest(
            'api/bidding/assign-drivers/1',
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'external',
                        'drivers' => [
                            [
                                'etc_id' => 1,
                            ],
                            [
                                'etc_id' => 2,
                            ],
                        ],
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals('pending', $jsonData['data']['attributes']['status']);
        $this->assertCount(2, $jsonData['data']['attributes']['drivers']);
    }

    /**
     * @group bidding
     */
    public function testWeCanAddUnapprovedExternalDriverToEvent()
    {
        $response = $this->postJsonRequest(
            'api/bidding/assign-drivers/1',
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'external',
                        'drivers' => [
                            [
                                'name' => $this->faker->name,
                                'emails' => $this->faker->email,
                                'pickup_time' => $this->faker->time(),
                                'fee' => 120,
                            ],
                        ],
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals('accepted', $jsonData['data']['attributes']['status']);
        $this->assertCount(1, $jsonData['data']['attributes']['drivers']);
    }

    /**
     * @group bidding
     */
    public function testWeCantAddMultipleUnapprovedExternalDriverToEvent()
    {
        $response = $this->postJsonRequest(
            'api/bidding/assign-drivers/1',
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'external',
                        'drivers' => [
                            [
                                'name' => $this->faker->name,
                                'emails' => $this->faker->email,
                                'pickup_time' => $this->faker->time(),
                                'fee' => 120,
                            ],
                            [
                                'name' => $this->faker->name,
                                'emails' => $this->faker->email,
                                'pickup_time' => $this->faker->time(),
                                'fee' => 120,
                            ],
                        ],
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group bidding
     */
    public function testWeCantAddZeroExternalDriverToEvent()
    {
        $response = $this->postJsonRequest(
            'api/bidding/assign-drivers/1',
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'external',
                        'drivers' => [],
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group bidding
     */
    public function testWeCantAddInvalidUnapprovedExternalDriverToEvent()
    {
        $response = $this->postJsonRequest(
            'api/bidding/assign-drivers/1',
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'external',
                        'drivers' => [
                            [
                                'name' => $this->faker->name,
                                'emails' => $this->faker->email,
                                'fee' => 120,
                            ],
                        ],
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group bidding
     */
    public function testWeCantAddUnapprovedExternalDriverWithoutNameToEvent()
    {
        $response = $this->postJsonRequest(
            'api/bidding/assign-drivers/1',
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'external',
                        'drivers' => [
                            [
                                'emails' => $this->faker->email,
                                'pickup_time' => $this->faker->time(),
                                'fee' => 120,
                            ],
                        ],
                    ]
                ]
            ]
        );

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group bidding
     */
    public function testWeCantAddInvalidExternalDriverToEvent()
    {
        $response = $this->postJsonRequest(
            'api/bidding/assign-drivers/1',
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'transportation_type' => 'external',
                        'drivers' => [
                            [
                                'etc_id' => 12,
                            ],
                        ],
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group bidding
     * @group decline-all
     */
    public function testWeCanDeclineAllExternalDriverOnEvent()
    {
        $pendingEvent = Event::pending()->first();
        $this->assertNotCount(0, $pendingEvent->drivers);

        $response = $this->deleteJsonRequest(
            \route('bidding.decline-all-drivers', ['event_id' => $pendingEvent->id])
        );
        $response->assertStatus(JsonResponse::HTTP_OK);

        $unassignedEvent = Event::find($pendingEvent->id);
        $this->assertNull($unassignedEvent->transportation_type);
        $this->assertCount(0, $unassignedEvent->drivers);
    }

    /**
     * @group bidding
     * @group decline-all
     */
    public function testWeCantDeclineAllExternalDriverOnUnassignedEvent()
    {
        $unassignedEvent = Event::unassigned()->first();
        $this->assertCount(0, $unassignedEvent->drivers);

        $response = $this->deleteJsonRequest(
            \route('bidding.decline-all-drivers', ['event_id' => $unassignedEvent->id])
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group bidding
     * @group accept
     */
    public function testWeCanAcceptSubmittedDriver()
    {
        $pendingEvent = Event::pending()->first();
        $drivers = $pendingEvent->drivers();
        $submittedDriver = $drivers->where('status', 'submitted')->first();

        $response = $this->putJsonRequest(
            \route('bidding.accept-driver', ['id' => $submittedDriver->id]),
            []
        );
        $response->assertStatus(JsonResponse::HTTP_OK);

        $acceptedEvent = Event::find($pendingEvent->id);
        $this->assertEquals($submittedDriver->id, $acceptedEvent->acceptedDriver()->first()->id);
        $this->assertCount($drivers->where('status', 'declined')->count(), $drivers->get());
        $this->assertEquals($submittedDriver->pickup_time, $acceptedEvent->start_time);
    }

    /**
     * @group bidding
     * @group accept
     */
    public function testWeCantAcceptNotSubmittedDriver()
    {
        $pendingEvent = Event::pending()->first();
        $notSubmittedDriver = $pendingEvent->drivers()->where('status', '!=', 'submitted')->first();

        $reponse = $this->putJsonRequest(
            \route('bidding.accept-driver', ['id' => $notSubmittedDriver->id]),
            []
        );
        $reponse->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * New data
     */
    protected function getEventDataAttributes()
    {
        $eventName = $this->faker->text('50');
        $date = $this->faker->date();
        $start_time = $this->faker->time('H:i:s', '12:00:00');
        $end_time = $this->faker->time('H:i:s', 'now');
        $transport_type = $this->faker->randomElement(array_keys(Config::get('transport_type')));
        $transportation_type = $this->faker->randomElement(array_keys(Config::get('transportation_type')));

        return [
            'name' => $eventName,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'rrule' => null,
            'transport_type' => $transport_type,
            'transportation_type' => $transportation_type,
            'description' => '',
            'facility_id' => auth()->user()->facility_id,
            'passengers' => [
                [
                    'id' => null,
                    'client_id' => null,
                    'name' => 'Ann Lee',
                    'room_number' => 'A112',
                    'appointments' => [
                        [
                            'id' => null,
                            'time' => '11:30:00',
                            'location_id' => $this->getLocationData()['id'],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getLocationData()
    {
        $location = Location::withoutGlobalScopes()->find(1)->first()->toArray();
        $location['facility_id'] = (int)$location['facility_id'];
        return $location;
    }
}
