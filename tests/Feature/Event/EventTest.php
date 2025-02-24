<?php

namespace Tests\Feature\Event;

use App\Mail\EventCreated;
use App\Mail\EventModified;
use App\Models\Event\Event;
use App\Models\Location\Location;
use App\Models\Client\Client;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Tests\Feature\ApiTestBase;
use Tests\Traits\UserTrait;
use Illuminate\Support\Facades\Mail;

class EventTest extends ApiTestBase
{
    use UserTrait;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        Mail::fake();
        $this->login('fa@silverpine.test');
    }

    /**
     * @group event
     */
    public function testWeCanCreateEvent()
    {
        $eventDataAttributes = $this->getEventDataAttributes();

        $response = $this->postJsonRequest(
            route('events.store'),
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => $eventDataAttributes + [
                        'facility_id' => (int)auth()->user()->facility_id,
                        'location_id' => (int)$this->getLocationData()['id'],
                    ],
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();

        $eventId = Event::count();
        $user = auth()->user();
        $this->assertSame([
            'data' => [
                'type' => 'events',
                'id' => (string)$eventId,
                'attributes' => [
                    'name' => $eventDataAttributes['name'],
                    'date' => $eventDataAttributes['date'],
                    'start_time' => $eventDataAttributes['start_time'],
                    'end_time' => $eventDataAttributes['end_time'],
                    'rrule' => $eventDataAttributes['rrule'],
                    'recurrences' => [
                        [
                            'date' => $eventDataAttributes['date'],
                            'start_time' => $eventDataAttributes['start_time'],
                            'end_time' => $eventDataAttributes['end_time'],
                        ],
                    ],
                    'transport_type' => $eventDataAttributes['transport_type'],
                    'transportation_type' => null,
                    'description' => $eventDataAttributes['description'],
                    'user' => [
                        'id' => auth()->user()->id,
                        'name' => "{$user->first_name} {$user->middle_name} {$user->last_name}",
                        'first_name' => $user->first_name,
                        'middle_name' => $user->middle_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'color_id' => $user->color_id,
                    ],
                    'facility_id' => (int)$user->facility_id,
                    'location' => $this->getLocationData(),
                    'passengers' => [
                        [
                            'id' => 7,
                            'client_id' => null,
                            'name' => 'Ann Lee',
                            'room_number' => 'A112',
                            'appointments' => [
                                [
                                    'id' => 7,
                                    'time' => '11:30:00',
                                    'location' => $this->getLocationData(),
                                ],
                            ],
                        ],
                    ],
                    'accepted_driver' => null,
                ],
                'links' => [
                    'self' => env('APP_URL') . '/events/' . $eventId,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group event
     */
    public function testWeCanSendEventCreatedMail()
    {
        $client = Client::first();
        $eventDataAttributes = $this->getEventDataAttributes($client);

        $response = $this->postJsonRequest(
            route('events.store'),
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => $eventDataAttributes + [
                        'facility_id' => (int)auth()->user()->facility_id,
                        'location_id' => (int)$this->getLocationData()['id'],
                    ],
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_CREATED);

        Mail::assertSent(
            EventCreated::class,
            function ($mail) use ($client) {
                return $mail->hasTo($client->responsible_party_email);
            }
        );
    }

    /**
     * @group event
     */
    public function testWeCanModifyEvent()
    {
        $event = factory(Event::class)->create();
        $eventDataAttributes = $this->getEventDataAttributes();

        $response = $this->putJsonRequest(
            route('events.update', ['event' => $event->id]),
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'location_id' => (int)$this->getLocationData()['id'],
                        'transportation_type' => 'external',
                    ] + $eventDataAttributes,
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $user = auth()->user();
        $this->assertSame([
            'data' => [
                'type' => 'events',
                'id' => (string)$event->id,
                'attributes' => [
                    'name' => $eventDataAttributes['name'],
                    'date' => $eventDataAttributes['date'],
                    'start_time' => $eventDataAttributes['start_time'],
                    'end_time' => $eventDataAttributes['end_time'],
                    'rrule' => $eventDataAttributes['rrule'],
                    'recurrences' => [
                        [
                            'date' => $eventDataAttributes['date'],
                            'start_time' => $eventDataAttributes['start_time'],
                            'end_time' => $eventDataAttributes['end_time'],
                        ],
                    ],
                    'transport_type' => $eventDataAttributes['transport_type'],
                    'transportation_type' => 'external',
                    'description' => $eventDataAttributes['description'],
                    'user' => [
                        'id' => $user->id,
                        'name' => "{$user->first_name} {$user->middle_name} {$user->last_name}",
                        'first_name' => $user->first_name,
                        'middle_name' => $user->middle_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'color_id' => $user->color_id,
                    ],
                    'facility_id' => (int)$user->facility_id,
                    'location' => $this->getLocationData(),
                    'passengers' => [
                        [
                            'id' => 7,
                            'client_id' => null,
                            'name' => 'Ann Lee',
                            'room_number' => 'A112',
                            'appointments' => [
                                [
                                    'id' => 7,
                                    'time' => '11:30:00',
                                    'location' => $this->getLocationData(),
                                ],
                            ],
                        ],
                    ],
                    'accepted_driver' => null,
                ],
                'links' => [
                    'self' => env('APP_URL') . '/events/' . $event->id,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group event
     */
    public function testWeCanSendEventModifiedMail()
    {
        $event = factory(Event::class)->create();
        $client = Client::first();
        $eventDataAttributes = $this->getEventDataAttributes($client);

        $response = $this->putJsonRequest(
            route('events.update', ['event' => $event->id]),
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'location_id' => (int)$this->getLocationData()['id'],
                        'transportation_type' => 'external',
                    ] + $eventDataAttributes,
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);

        Mail::assertSent(
            EventModified::class,
            function ($mail) use ($client) {
                return $mail->hasTo($client->responsible_party_email);
            }
        );
    }

    /**
     * @group event
     */
    public function testWeCanGetSpecificEvent()
    {
        $eventDataAttributes = $this->getEventDataAttributes();
        unset($eventDataAttributes['passengers']);
        $event = factory(Event::class)->create($eventDataAttributes);

        $response = $this->getJsonRequest(route('events.show', ['event' => $event->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $user = auth()->user();
        $this->assertSame([
            'data' => [
                'type' => 'events',
                'id' => (string)$event->id,
                'attributes' => [
                    'name' => $eventDataAttributes['name'],
                    'date' => $eventDataAttributes['date'],
                    'start_time' => $eventDataAttributes['start_time'],
                    'end_time' => $eventDataAttributes['end_time'],
                    'rrule' => $eventDataAttributes['rrule'],
                    'recurrences' => [
                        [
                            'date' => $eventDataAttributes['date'],
                            'start_time' => $eventDataAttributes['start_time'],
                            'end_time' => $eventDataAttributes['end_time'],
                        ],
                    ],
                    'transport_type' => $eventDataAttributes['transport_type'],
                    'transportation_type' => null,
                    'description' => $eventDataAttributes['description'],
                    'user' => [
                        'id' => $user->id,
                        'name' => "{$user->first_name} {$user->middle_name} {$user->last_name}",
                        'first_name' => $user->first_name,
                        'middle_name' => $user->middle_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'color_id' => $user->color_id,
                    ],
                    'facility_id' => (int)$user->facility_id,
                    'location' => $this->getLocationData(),
                    'passengers' => [],
                    'accepted_driver' => null,
                ],
                'links' => [
                    'self' => env('APP_URL') . '/events/' . $event->id,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group event
     */
    public function testWeCanDeleteEvent()
    {
        $event = factory(Event::class)->create();
        $response = $this->deleteJsonRequest(route('events.destroy', ['event' => $event->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSoftDeleted('events', ['id' => $event->id]);
    }

    /**
     * @group event
     */
    public function testWeCanListEvents()
    {
        $eventCount = Event::count();
        $response = $this->getJsonRequest(route('events.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($eventCount, count($jsonData['data']));
    }

    /**
     * @group event
     */
    public function testWeCantPaginateEventsWithReversedInterval()
    {
        $this->login('fa@silverpine.test');

        $dateFormat = 'Y-m-d';
        $testDate = [2200, 03, 18];
        $testCarbonDate = Carbon::create(...$testDate);

        $mtdStart = $testCarbonDate->startOfMonth()->format($dateFormat);
        $mtdEnd = $testCarbonDate->endOfMonth()->format($dateFormat);

        $this
            ->getJsonRequest(route('events.index', ['fromDate' => $mtdEnd, 'toDate' => $mtdStart]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @group event
     */
    public function testWeCanPaginateEventsByMonth()
    {
        $this->login('fa@silverpine.test');

        $dateFormat = 'Y-m-d';
        $testDate = [2200, 03, 18];
        $testCarbonDate = Carbon::create(...$testDate);

        $mtdStart = $testCarbonDate->startOfMonth()->format($dateFormat);
        $mtdEnd = $testCarbonDate->endOfMonth()->format($dateFormat);

        $eventDataAttributes = $this->getEventDataAttributes();
        $eventDataAttributes['date'] = Carbon::create(...$testDate)->format($dateFormat);
        $eventDataAttributes['rrule'] = 'FREQ=WEEKLY;INTERVAL=1;UNTIL=22000426T220000Z;BYDAY=WE';

        $this
            ->postJsonRequest(
                route('events.store'),
                [
                    'data' => [
                        'type' => 'events',
                        'attributes' => $eventDataAttributes + [
                                'facility_id' => (int)auth()->user()->facility_id,
                                'location_id' => (int)$this->getLocationData()['id'],
                            ],
                    ],
                ]
            )
            ->assertStatus(Response::HTTP_CREATED);

        $response = $this
            ->getJsonRequest(route('events.index', ['fromDate' => $mtdStart, 'toDate' => $mtdEnd]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        $this->assertCount(3, $response->decodeResponseJson()['data'][0]['attributes']['recurrences']);
    }

    /**
     * @group event
     */
    public function testWeCanPaginateEventsByWeek()
    {
        $this->login('fa@silverpine.test');

        $dateFormat = 'Y-m-d';
        $testDate = [2200, 03, 18];
        $testCarbonDate = Carbon::create(...$testDate);

        $wtdStart = $testCarbonDate->startOfWeek()->format($dateFormat);
        $wtdEnd = $testCarbonDate->endOfWeek()->format($dateFormat);

        $eventDataAttributes = $this->getEventDataAttributes();
        $eventDataAttributes['date'] = Carbon::create(...$testDate)->format($dateFormat);
        $eventDataAttributes['rrule'] = 'FREQ=WEEKLY;INTERVAL=1;UNTIL=22000426T220000Z;BYDAY=WE';

        $this
            ->postJsonRequest(
                route('events.store'),
                [
                    'data' => [
                        'type' => 'events',
                        'attributes' => $eventDataAttributes + [
                                'facility_id' => (int)auth()->user()->facility_id,
                                'location_id' => (int)$this->getLocationData()['id'],
                            ],
                    ],
                ]
            )
            ->assertStatus(Response::HTTP_CREATED);

        $response = $this
            ->getJsonRequest(route('events.index', ['fromDate' => $wtdStart, 'toDate' => $wtdEnd]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        $this->assertCount(2, $response->decodeResponseJson()['data'][0]['attributes']['recurrences']);
    }

    /**
     * @group event
     */
    public function testWeCanPaginateEventsByDay()
    {
        $this->login('fa@silverpine.test');

        $dateFormat = 'Y-m-d';
        $eventDate = [2200, 03, 18];
        $testDate = [2200, 03, 19];

        $testCarbonDate = Carbon::create(...$testDate);

        $dtdStart = $testCarbonDate->format($dateFormat);
        $dtdEnd = $dtdStart;

        $eventDataAttributes = $this->getEventDataAttributes();
        $eventDataAttributes['date'] = Carbon::create(...$eventDate)->format($dateFormat);
        $eventDataAttributes['rrule'] = 'FREQ=WEEKLY;INTERVAL=1;UNTIL=22000426T220000Z;BYDAY=WE';

        $this
            ->postJsonRequest(
                route('events.store'),
                [
                    'data' => [
                        'type' => 'events',
                        'attributes' => $eventDataAttributes + [
                                'facility_id' => (int)auth()->user()->facility_id,
                                'location_id' => (int)$this->getLocationData()['id'],
                            ],
                    ],
                ]
            )
            ->assertStatus(Response::HTTP_CREATED);

        $response = $this
            ->getJsonRequest(route('events.index', ['fromDate' => $dtdStart, 'toDate' => $dtdEnd]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        $this->assertCount(1, $response->decodeResponseJson()['data'][0]['attributes']['recurrences']);
    }

    /**
     * @group event
     */
    public function testWeCanSearchEventWithoutPaginate()
    {
        $this->login('fa@silverpine.test');
        $facilityId = auth()->user()->facility_id;

        $dateFormat = 'Y-m-d';
        $testDate = [2200, 03, 19];

        $client = factory(Client::class)->create([
            'first_name' => 'Cassandra',
            'facility_id' => 1,
            'room_number' => 'A51'
        ]);

        $locationData = factory(Location::class)->create([
            'name' => 'Somewhere',
            'facility_id' => $facilityId,
        ]);

        $eventData = array_except(
            $this->getEventDataAttributes($client),
            [
                'name',
                'date',
                'rrule',
                'facility_id',
                'location_id',
            ]
        );

        $searchValues = [
            'eventName' => 'Test Event',
            'clientName' => $client->first_name,
            'locationName' => $locationData->name
        ];

        $this
            ->postJsonRequest(
                route(
                    'events.store',
                    ['facility_id' => $facilityId]
                ),
                [
                    'data' => [
                        'type' => 'events',
                        'attributes' => $eventData + [
                            'name' => $searchValues['eventName'],
                            'date' => Carbon::create(...$testDate)->format($dateFormat),
                            'rrule' => 'FREQ=WEEKLY;INTERVAL=1;UNTIL=22000426T220000Z;BYDAY=WE',
                            'facility_id' => $facilityId,
                            'location_id' => $locationData->id,
                        ]
                    ],
                ]
            )
            ->assertStatus(Response::HTTP_CREATED);

        // By name
        $this
            ->getJsonRequest(route('events.index', ['searchKey' => $searchValues['eventName']]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        // By client
        $this
            ->getJsonRequest(route('events.index', ['searchKey' => $searchValues['clientName']]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        // By location
        $this
            ->getJsonRequest(route('events.index', ['searchKey' => $searchValues['locationName']]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');
    }

    /**
     * @group event
     */
    public function testWeCanSearchEventWithPaginateByMonth()
    {
        $this->login('fa@silverpine.test');
        $facilityId = (int)auth()->user()->facility_id;

        $dateFormat = 'Y-m-d';
        $testDate = [2200, 03, 19];

        $testCarbonDate = Carbon::create(...$testDate);

        $mtdStart = $testCarbonDate->startOfMonth()->format($dateFormat);
        $mtdEnd = $testCarbonDate->endOfMonth()->format($dateFormat);

        $client = (new Client())->first();

        $eventDataAttributes = $this->getEventDataAttributes($client);
        $eventDataAttributes['name'] = 'Test Event';
        $eventDataAttributes['date'] = Carbon::create(...$testDate)->format($dateFormat);
        $eventDataAttributes['rrule'] = 'FREQ=WEEKLY;INTERVAL=1;UNTIL=22000426T220000Z;BYDAY=WE';

        $locationData = factory(Location::class)->create([
            'name' => 'Somewhere',
            'facility_id' => $facilityId,
        ]);

        $this
            ->postJsonRequest(
                route('events.store'),
                [
                    'data' => [
                        'type' => 'events',
                        'attributes' => $eventDataAttributes + [
                                'facility_id' => $facilityId,
                                'location_id' => $locationData['id'],
                            ],
                    ],
                ]
            )
            ->assertStatus(Response::HTTP_CREATED);

        // By name
        $this
            ->getJsonRequest(
                route(
                    'events.index',
                    [
                        'searchKey' => $eventDataAttributes['name'],
                        'fromDate' => $mtdStart,
                        'toDate' => $mtdEnd,
                    ]
                )
            )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        // By client
        $this
            ->getJsonRequest(
                route(
                    'events.index',
                    [
                        'searchKey' => $client->first_name,
                        'fromDate' => $mtdStart,
                        'toDate' => $mtdEnd,
                    ]
                )
            )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        // By location
        $this
            ->getJsonRequest(
                route(
                    'events.index',
                    [
                        'searchKey' => $locationData['name'],
                        'fromDate' => $mtdStart,
                        'toDate' => $mtdEnd,
                    ]
                )
            )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');
    }

    /**
     * @group event
     */
    public function testWeCanPaginateEventsByDayOnNotRecurringDay()
    {
        $this->login('fa@silverpine.test');

        $dateFormat = 'Y-m-d';
        $eventDate = [2200, 03, 18];
        $testDate = [2200, 03, 20];

        $testCarbonDate = Carbon::create(...$testDate);

        $dtdStart = $testCarbonDate->format($dateFormat);
        $dtdEnd = $dtdStart;

        $eventDataAttributes = $this->getEventDataAttributes();
        $eventDataAttributes['date'] = Carbon::create(...$eventDate)->format($dateFormat);
        $eventDataAttributes['rrule'] = 'FREQ=WEEKLY;INTERVAL=1;UNTIL=22000426T220000Z;BYDAY=WE';

        $this
            ->postJsonRequest(
                route('events.store'),
                [
                    'data' => [
                        'type' => 'events',
                        'attributes' => $eventDataAttributes + [
                                'facility_id' => (int)auth()->user()->facility_id,
                                'location_id' => (int)$this->getLocationData()['id'],
                            ],
                    ],
                ]
            )
            ->assertStatus(Response::HTTP_CREATED);

        $this
            ->getJsonRequest(route('events.index', ['fromDate' => $dtdStart, 'toDate' => $dtdEnd]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(0, 'data');
    }

    /**
     * @group event
     */
    public function testWeCantPaginateEventsByMonthWithMissingParameters()
    {
        $this->login('fa@silverpine.test');

        $this
            ->getJsonRequest(route('events.index', ['fromDate' => '2019-03-01']))
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this
            ->getJsonRequest(route('events.index', ['toDate' => '2019-03-31']))
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @group event
     */
    public function testListEventsByFacility()
    {
        $clientCount = Event::where('facility_id', auth()->user()->facility->id)->count();
        $response = $this->getJsonRequest(route('events.index', ['facility_id' => auth()->user()->facility->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($clientCount, count($jsonData['data']));
    }

    /**
     * @group event
     */
    public function testWeCantGetSpecifiedEventsWithWrongId()
    {
        $eventCount = Event::count();
        $response = $this->getJsonRequest(route('events.show', ['id' => $eventCount + 1 ]));
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->getJsonRequest(route('events.show', ['id' => 0 ]));
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * @group event
     */
    public function testWeCantCreateEventWithWrongOrLessParameters()
    {
        $eventDataAttributes = $this->getEventDataAttributes();
        $eventDataAttributes['facility_id'] = null;

        $response = $this->postJsonRequest(
            route('events.store'),
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => $eventDataAttributes,
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);

        $eventDataAttributes = $this->getEventDataAttributes();
        unset($eventDataAttributes['name']);

        $response = $this->postJsonRequest(
            route('events.store'),
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => $eventDataAttributes,
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group event
     */
    public function testWeCantDeleteEventsWithWrongId()
    {
        $eventId = Event::count();
        $response = $this->deleteJsonRequest(route('events.destroy', ['id' => $eventId + 1]));
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->deleteJsonRequest(route('events.destroy', ['id' => 0]));
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->deleteJsonRequest(route('events.destroy', ['id' => null]));
        $response->assertStatus(JsonResponse::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * @group event
     */
    public function testWeCantModifyFacility()
    {
        $event = factory(Event::class)->create();
        $this->createTestFacilityAndUser();
        $response = $this->putJsonRequest(
            route('events.update', ['event' => $event->id]),
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'facility_id' => $this->facility->id,
                    ] + $this->getEventDataAttributes(),
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group event
     */
    public function testWeCantModifyDatasWithWrongId()
    {
        $eventCount = Event::count();

        $response = $this->putJsonRequest(route('events.update', ['event' => $eventCount + 1]), []);
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->putJsonRequest(route('events.update', ['event' => 0]), []);
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->putJsonRequest(route('events.update', ['event' => null]), []);
        $response->assertStatus(JsonResponse::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * New data
     */
    protected function getEventDataAttributes(Client $client = null)
    {
        $passengerData = [
            'id' => null,
            'client_id' => $client ? $client->id : null,
            'name' => $client ? $client->getFullName() : 'Ann Lee',
            'room_number' => $client ? $client->room_number : 'A112',
            'appointments' => [
                [
                    'id' => null,
                    'time' => '11:30:00',
                    'location_id' => $this->getLocationData()['id'],
                ],
            ],
        ];

        return [
            'name' => $this->faker->text('50'),
            'date' => $this->faker->date(),
            'start_time' => $this->faker->time('H:i:s', '12:00:00'),
            'end_time' => $this->faker->time('H:i:s', 'now'),
            'rrule' => null,
            'transport_type' => $this->faker->randomElement(array_keys(Config::get('transport_type'))),
            'description' => '',
            'facility_id' => auth()->user()->facility_id,
            'passengers' => [ $passengerData ],
        ];
    }

    protected function getLocationData()
    {
        $location = Location::withoutGlobalScopes()->find(1)->first()->toArray();
        $location['facility_id'] = (int)$location['facility_id'];
        return $location;
    }
}
