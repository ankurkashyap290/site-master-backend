<?php

namespace Tests\Feature\Event;

use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use App\Models\Event\Event;
use App\Models\Event\Passenger;
use App\Models\Client\Client;

class PassengerTest extends ApiTestBase
{
    public function setUp()
    {
        parent::setUp();
        $this->login('fa@silverpine.test');
    }

    /**
     * @group passenger
     */
    public function testWeCanCreateEventWithOneTimePassengers()
    {
        $event = factory(Event::class)->make([
            'name' => 'Ann goes to the Dentist',
        ]);
        $attributes = $event->getAttributes();
        unset($attributes['transportation_type']);
        $attributes['passengers'] = [
            [
                'id' => null,
                'client_id' => null,
                'name' => 'Ann Smith',
                'room_number' => 'A113',
                'appointments' => [
                    [
                        'id' => null,
                        'time' => '11:30:00',
                        'location_id' => 1,
                    ],
                ],
            ],
        ];
        $response = $this->postJsonRequest(route('events.store'), ['data' => ['attributes' => $attributes]]);

        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(1, $jsonData['data']['attributes']['passengers']);
        $passengerData = $jsonData['data']['attributes']['passengers'][0];
        $this->assertNotNull($passengerData['id']);
        $this->assertNull($passengerData['client_id']);
        $this->assertEquals('Ann Smith', $passengerData['name']);
        $this->assertEquals('A113', $passengerData['room_number']);
    }

    /**
     * @group passenger
     */
    public function testWeCanCreateEventWithClientPassengers()
    {
        $event = factory(Event::class)->make([
            'name' => 'Client goes to the Dentist',
        ]);
        $attributes = $event->getAttributes();
        unset($attributes['transportation_type']);
        $client = auth()->user()->facility->clients[0];
        $attributes['passengers'] = [
            [
                'id' => null,
                'client_id' => $client->id,
                'name' => $client->getFullName(),
                'room_number' => $client->room_number,
                'appointments' => [
                    [
                        'id' => null,
                        'time' => '11:30:00',
                        'location_id' => 1,
                    ],
                ],
            ]
        ];
        $response = $this->postJsonRequest(route('events.store'), ['data' => ['attributes' => $attributes]]);

        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(1, $jsonData['data']['attributes']['passengers']);
        $passengerData = $jsonData['data']['attributes']['passengers'][0];
        $this->assertNotNull($passengerData['id']);
        $this->assertEquals($client->id, $passengerData['client_id']);
        $this->assertEquals($client->getFullName(), $passengerData['name']);
        $this->assertEquals($client->room_number, $passengerData['room_number']);
    }

    /**
     * @group passenger
     */
    public function testWeCannotCreateEventWithoutPassengers()
    {
        $event = factory(Event::class)->make([
            'name' => 'Client goes to the Dentist',
        ]);
        $attributes = $event->getAttributes();
        unset($attributes['transportation_type']);
        $attributes['passengers'] = [];
        $response = $this->postJsonRequest(route('events.store'), ['data' => ['attributes' => $attributes]]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group passenger
     */
    public function testWeCannotCreateEventWithDuplicatedPassengers()
    {
        $event = factory(Event::class)->make([
            'name' => 'Ann goes to the Dentist',
        ]);
        $attributes = $event->getAttributes();
        unset($attributes['transportation_type']);
        $attributes['passengers'] = [
            [
                'id' => null,
                'client_id' => null,
                'name' => 'Ann Smith',
                'room_number' => 'A113',
                'appointments' => [
                    [
                        'id' => null,
                        'time' => '11:30:00',
                        'location_id' => 1,
                    ],
                ],
            ],
            [
                'id' => null,
                'client_id' => null,
                'name' => 'Ann Smith',
                'room_number' => 'A113',
                'appointments' => [
                    [
                        'id' => null,
                        'time' => '11:30:00',
                        'location_id' => 1,
                    ],
                ],
            ]
        ];
        $response = $this->postJsonRequest(route('events.store'), ['data' => ['attributes' => $attributes]]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group passenger
     */
    public function testWeCanAddPassengerToExistingEvent()
    {
        $event = factory(Event::class)->make([
            'name' => 'Ann goes to the Dentist',
            'transportation_type' => 'external',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Ann Smith', 'room_number' => 'A113']);
        $passenger->save(['unprotected' => true]);

        $response = $this->putJsonRequest(
            route('events.update', ['id' => $event->id]),
            ['data' => ['attributes' =>
                [
                    'name' => $event->name,
                    'date' => $event->date,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'transport_type' => $event->transport_type,
                    'description' => $event->description,
                    'facility_id' => $event->facility_id,
                    'location_id' => $event->location_id,
                    'passengers' => [
                        [
                            'id' => $event->passengers[0]->id,
                            'client_id' => null,
                            'name' => 'Rebeca Black',
                            'room_number' => 'A114',
                            'appointments' => [
                                [
                                    'id' => null,
                                    'time' => '11:30:00',
                                    'location_id' => 1,
                                ],
                            ],
                        ],
                    ],
                ],
            ]]
        );

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(1, $jsonData['data']['attributes']['passengers']);
        $passengerData = $jsonData['data']['attributes']['passengers'][0];
        $this->assertNotNull($passengerData['id']);
        $this->assertNull($passengerData['client_id']);
        $this->assertEquals('Rebeca Black', $passengerData['name']);
        $this->assertEquals('A114', $passengerData['room_number']);
    }

    /**
     * @group passenger
     */
    public function testWeCannotAddDuplicatedPassengerToExistingEvent()
    {
        $event = factory(Event::class)->make([
            'name' => 'Ann goes to the Dentist',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Ann Smith', 'room_number' => 'A113']);
        $passenger->save(['unprotected' => true]);

        $response = $this->putJsonRequest(
            route('events.update', ['id' => $event->id]),
            ['data' => ['attributes' =>
                [
                    'name' => $event->name,
                    'date' => $event->date,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'transport_type' => $event->transport_type,
                    'description' => $event->description,
                    'facility_id' => $event->facility_id,
                    'location_id' => $event->location_id,
                    'passengers' => [
                        [
                            'id' => $event->passengers[0]->id,
                            'client_id' => null,
                            'name' => 'Rebeca Black',
                            'room_number' => 'A114',
                            'appointments' => [
                                [
                                    'id' => null,
                                    'time' => '11:30:00',
                                    'location_id' => 1,
                                ],
                            ],
                        ],
                        [
                            'id' => null,
                            'client_id' => null,
                            'name' => 'Rebeca Black',
                            'room_number' => 'A114',
                            'appointments' => [
                                [
                                    'id' => null,
                                    'time' => '11:30:00',
                                    'location_id' => 1,
                                ],
                            ],
                        ],
                    ],
                ],
            ]]
        );

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group passenger
     */
    public function testWeCanRemovePassengerFromExistingEvent()
    {
        $event = factory(Event::class)->make([
            'name' => 'Ann goes to the Dentist',
            'transportation_type' => 'external',
        ]);
        $event->save(['unprotected' => true]);
        $passenger1 = new Passenger(['event_id' => $event->id, 'name' => 'Ann Smith', 'room_number' => 'A113']);
        $passenger1->save(['unprotected' => true]);
        $passenger2 = new Passenger(['event_id' => $event->id, 'name' => 'Rebeca Black', 'room_number' => 'A113']);
        $passenger2->save(['unprotected' => true]);

        $response = $this->putJsonRequest(
            route('events.update', ['id' => $event->id]),
            ['data' => ['attributes' =>
                [
                    'name' => $event->name,
                    'date' => $event->date,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'transport_type' => $event->transport_type,
                    'description' => $event->description,
                    'facility_id' => $event->facility_id,
                    'location_id' => $event->location_id,
                    'passengers' => [
                        [
                            'id' => $passenger2->id,
                            'client_id' => null,
                            'name' => 'Rebeca Black',
                            'room_number' => 'A114',
                            'appointments' => [
                                [
                                    'id' => null,
                                    'time' => '11:30:00',
                                    'location_id' => 1,
                                ],
                            ],
                        ],
                    ],
                ],
            ]]
        );

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(1, $jsonData['data']['attributes']['passengers']);
        $passengerData = $jsonData['data']['attributes']['passengers'][0];
        $this->assertNotNull($passengerData['id']);
        $this->assertNull($passengerData['client_id']);
        $this->assertEquals('Rebeca Black', $passengerData['name']);
        $this->assertEquals('A114', $passengerData['room_number']);
    }

    /**
     * @group passenger
     */
    public function testWeCannotRemoveLastPassengerFromExistingEvent()
    {
        $event = factory(Event::class)->make([
            'name' => 'Ann goes to the Dentist',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Ann Smith', 'room_number' => 'A113']);
        $passenger->save(['unprotected' => true]);

        $response = $this->putJsonRequest(
            route('events.update', ['id' => $event->id]),
            ['data' => ['attributes' =>
                [
                    'name' => $event->name,
                    'date' => $event->date,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'transport_type' => $event->transport_type,
                    'description' => $event->description,
                    'facility_id' => $event->facility_id,
                    'location_id' => $event->location_id,
                    'passengers' => [],
                ],
            ]]
        );

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }
}
