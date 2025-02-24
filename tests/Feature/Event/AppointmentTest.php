<?php

namespace Tests\Feature\Event;

use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use App\Models\Event\Event;
use App\Models\Event\Passenger;
use App\Models\Event\Appointment;

class AppointmentTest extends ApiTestBase
{
    public function setUp()
    {
        parent::setUp();
        $this->login('fa@silverpine.test');
    }

    /**
     * @group appointment
     */
    public function testWeCanCreateEventWithAppointment()
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
        $this->assertCount(1, $jsonData['data']['attributes']['passengers'][0]['appointments']);
        $appointmentData = $jsonData['data']['attributes']['passengers'][0]['appointments'][0];
        $this->assertNotNull($appointmentData['id']);
        $this->assertEquals('11:30:00', $appointmentData['time']);
        $this->assertEquals(1, $appointmentData['location']['id']);
    }

    /**
     * @group appointment
     */
    public function testWeCannotCreateEventWithoutAppointments()
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
                'appointments' => [],
            ],
        ];
        $response = $this->postJsonRequest(route('events.store'), ['data' => ['attributes' => $attributes]]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group appointment
     */
    public function testWeCannotCreateAppointmentWithEmptyTime()
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
                        'time' => '',
                        'location_id' => 1,
                    ],
                ],
            ],
        ];
        $response = $this->postJsonRequest(route('events.store'), ['data' => ['attributes' => $attributes]]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group appointment
     */
    public function testWeCannotCreateAppointmentWithInvalidLocation()
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
                        'time' => '',
                        'location_id' => 0,
                    ],
                ],
            ],
        ];
        $response = $this->postJsonRequest(route('events.store'), ['data' => ['attributes' => $attributes]]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group appointment
     */
    public function testWeCanAddAppointmentToExistingPassenger()
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
                    ],
                ],
            ]]
        );

        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(1, $jsonData['data']['attributes']['passengers'][0]['appointments']);
        $appointmentData = $jsonData['data']['attributes']['passengers'][0]['appointments'][0];
        $this->assertNotNull($appointmentData['id']);
        $this->assertEquals('11:30:00', $appointmentData['time']);
        $this->assertEquals(1, $appointmentData['location']['id']);
    }

    /**
     * @group appointment
     */
    public function testWeCanRemoveAppointmentFromExistingPassenger()
    {
        $event = factory(Event::class)->make([
            'name' => 'Ann goes to the Dentist',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Ann Smith', 'room_number' => 'A113']);
        $passenger->save(['unprotected' => true]);
        $appointment1 = new Appointment(['passenger_id' => $passenger->id, 'time' => '11:30:00', 'location_id' => 1]);
        $appointment1->save(['unprotected' => true]);
        $appointment2 = new Appointment(['passenger_id' => $passenger->id, 'time' => '13:00:00', 'location_id' => 2]);
        $appointment2->save(['unprotected' => true]);

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
                            'id' => $passenger->id,
                            'client_id' => $passenger->client_id,
                            'name' => $passenger->name,
                            'room_number' => $passenger->room_number,
                            'appointments' => [
                                [
                                    'id' => $appointment1->id,
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
        $this->assertCount(1, $jsonData['data']['attributes']['passengers'][0]['appointments']);
        $appointmentData = $jsonData['data']['attributes']['passengers'][0]['appointments'][0];
        $this->assertNotNull($appointmentData['id']);
        $this->assertEquals('11:30:00', $appointmentData['time']);
        $this->assertEquals(1, $appointmentData['location']['id']);
    }

    /**
     * @group appointment
     */
    public function testWeCannotRemoveLastAppointmentFromExistingPassenger()
    {
        $event = factory(Event::class)->make([
            'name' => 'Ann goes to the Dentist',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Ann Smith', 'room_number' => 'A113']);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment(['passenger_id' => $passenger->id, 'time' => '11:30:00', 'location_id' => 1]);
        $appointment->save(['unprotected' => true]);

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
                            'id' => $passenger->id,
                            'client_id' => $passenger->client_id,
                            'name' => $passenger->name,
                            'room_number' => $passenger->room_number,
                            'appointments' => [],
                        ],
                    ],
                ],
            ]]
        );
        
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }
}
