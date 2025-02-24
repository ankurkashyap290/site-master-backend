<?php

namespace Tests\Traits;

use Illuminate\Support\Carbon;
use App\Models\Client\Client;
use App\Models\Event\Event;
use App\Models\Event\Driver;
use App\Models\Event\Passenger;
use App\Models\Event\Appointment;
use App\Models\ETC\ExternalTransportationCompany;
use Illuminate\Support\Facades\Hash;

/**
 * Create users for test.
 */
trait EventTrait
{
    public function createTestEvents($organizationTree)
    {
        foreach ($organizationTree as $organization) {
            foreach ($organization['facilities'] as $facility) {
                $this->addEventToFacility($facility['facility'], $facility['users'][1]);
            }
        }
    }

    /**
     * Create events.
     *
     * @SuppressWarnings(PHPMD)
     */
    protected function addEventToFacility($facility, $user)
    {
        // Add clients to facility
        $clients = $this->getClients($facility);
        // Create ETC
        $etc = factory(ExternalTransportationCompany::class)->make([
            'facility_id' => $facility->id,
        ]);
        $etc->save(['unprotected' => true]);

        $etc2 = factory(ExternalTransportationCompany::class)->make([
            'facility_id' => $facility->id,
        ]);
        $etc2->save(['unprotected' => true]);

        // Create location for event
        $location = factory(\App\Models\Location\Location::class)->make(['facility_id' => $facility->id]);
        $location->save(['unprotected' => true]);

        // Create Event in Future
        $event = factory(Event::class)->make([
            'date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'facility_id' => $facility->id,
            'transportation_type' => 'external',
            'location_id' => $location->id,
            'user_id' => $user->id,
        ]);
        $event->save(['unprotected' => true]);

        // Add passengers and appointment to event.
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Alice Kingsley', 'room_number' => 'B13']);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment([
            'passenger_id' => $passenger->id,
            'time' => '10:00:00',
            'location_id' => $location->id]);
        $appointment->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Alice Kingsley', 'room_number' => 'B13']);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment([
            'passenger_id' => $passenger->id,
            'time' => '10:00:00',
            'location_id' => $location->id]);
        $appointment->save(['unprotected' => true]);

        // Add driver to event
        $driver = new Driver([
            'event_id' => $event->id,
            'name' => 'Test Driver',
            'etc_id' => $etc->id,
            'fee' => 8,
            'status' => 'accepted',
            'pickup_time' => date('H:i:s'),
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);

        $driver = new Driver([
            'event_id' => $event->id,
            'name' => 'Test Driver2',
            'etc_id' => $etc2->id,
            'fee' => 13,
            'status' => 'declined',
            'pickup_time' => date('H:i:s'),
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);

        // Create location for event
        $location = factory(\App\Models\Location\Location::class)->make(['facility_id' => $facility->id]);
        $location->save(['unprotected' => true]);

        // Create Event in the PAST
        $event = factory(Event::class)->make([
            'date' => Carbon::now()->subMonth()->format('Y-m-d'),
            'facility_id' => $facility->id,
            'transportation_type' => 'external',
            'location_id' => $location->id,
            'rrule' => 'FREQ=DAILY;INTERVAL=1;COUNT=60',
            'user_id' => $user->id,
        ]);
        $event->save(['unprotected' => true]);

        // Add passengers and appointment to event.
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Alice Kingsley', 'room_number' => 'B13']);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment([
            'passenger_id' => $passenger->id,
            'time' => '10:00:00',
            'location_id' => $location->id]);
        $appointment->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Alice Kingsley', 'room_number' => 'B13']);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment([
            'passenger_id' => $passenger->id,
            'time' => '10:00:00',
            'location_id' => $location->id]);
        $appointment->save(['unprotected' => true]);

        // Add driver to event
        $driver = new Driver([
            'event_id' => $event->id,
            'name' => 'Test Driver',
            'etc_id' => $etc->id,
            'fee' => 12,
            'status' => 'accepted',
            'pickup_time' => date('H:i:s'),
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);

        // Create location for event
        $location = factory(\App\Models\Location\Location::class)->make(['facility_id' => $facility->id]);
        $location->save(['unprotected' => true]);

        // Create Event
        $event = factory(Event::class)->make([
            'date' => Carbon::now()->subMonth()->format('Y-m-d'),
            'facility_id' => $facility->id,
            'location_id' => $location->id,
            'transportation_type' => 'external',
            'rrule' => 'FREQ=DAILY;INTERVAL=1;COUNT=30',
            'user_id' => $user->id,
        ]);
        $event->save(['unprotected' => true]);

        // Add passengers and appointment to event.
        $passenger = new Passenger(['event_id' => $event->id, 'client_id' => $clients[0]->id]);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment([
            'passenger_id' => $passenger->id,
            'time' => '10:00:00',
            'location_id' => $location->id]);
        $appointment->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'client_id' => $clients[1]->id]);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment([
            'passenger_id' => $passenger->id,
            'time' => '10:00:00',
            'location_id' => $location->id]);
        $appointment->save(['unprotected' => true]);

        // Add driver to event
        $driver = new Driver([
            'event_id' => $event->id,
            'name' => 'Test Driver 5',
            'user_id' => 5,
            'status' => 'accepted',
            'fee' => 4,
            'pickup_time' => date('H:i:s'),
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);

        // Create Event in Future
        $event = factory(Event::class)->make([
            'date' => Carbon::now()->addMonth()->format('Y-m-d'),
            'facility_id' => $facility->id,
            'transportation_type' => 'external',
            'location_id' => $location->id,
            'user_id' => $user->id,
        ]);
        $event->save(['unprotected' => true]);

        // Add passengers and appointment to event.
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Alice Kingsley', 'room_number' => 'B13']);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment([
            'passenger_id' => $passenger->id,
            'time' => '10:00:00',
            'location_id' => $location->id]);
        $appointment->save(['unprotected' => true]);

        // Add driver to event with submitted status
        $driver = new Driver([
            'event_id' => $event->id,
            'name' => 'Test Driver',
            'etc_id' => $etc->id,
            'fee' => 13,
            'status' => 'submitted',
            'pickup_time' => date('H:i:s'),
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);
    }

    protected function getClients($facility)
    {
        $clients = [];
        $clients[] = factory(Client::class)
            ->make([
                'facility_id' => $facility->id,
            ]);
        $clients[] = factory(Client::class)
            ->make([
                'facility_id' => $facility->id,
            ]);
        $clients[] = factory(Client::class)
            ->make([
                'facility_id' => $facility->id,
            ]);
        foreach (array_keys($clients) as $key) {
            $clients[$key]->save(['unprotected' => true]);
        }
        return $clients;
    }
}
