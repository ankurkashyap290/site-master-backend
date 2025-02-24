<?php

use Illuminate\Database\Seeder;
use App\Models\Client\Client;
use App\Models\Event\Event;
use App\Models\Event\Driver;
use App\Models\Event\Passenger;
use App\Models\Event\Appointment;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function run()
    {
        $clients = Client::withoutGlobalScopes()->get();
        $etc1 = \App\Models\ETC\ExternalTransportationCompany::withoutGlobalScopes()->find(1);
        $etc2 = \App\Models\ETC\ExternalTransportationCompany::withoutGlobalScopes()->find(2);

        $event = factory(Event::class)->make([
            'name' => 'Alice goes to the Psychologist',
            'transportation_type' => 'external',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Alice Kingsley', 'room_number' => 'B13']);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment(['passenger_id' => $passenger->id, 'time' => '10:00:00', 'location_id' => 1]);
        $appointment->save(['unprotected' => true]);

        $event = factory(Event::class)->make([
            'name' => 'Ann goes to the Dentist',
            'transportation_type' => 'external',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Ann Smith', 'room_number' => 'A113']);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment(['passenger_id' => $passenger->id, 'time' => '10:00:00', 'location_id' => 1]);
        $appointment->save(['unprotected' => true]);
        $driver = new Driver([
            'event_id' => $event->id,
            'name' => $etc1->name,
            'emails' => $etc1->emails,
            'etc_id' => 1,
            'status' => 'pending',
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);
        $driver = new Driver([
            'event_id' => $event->id,
            'name' => $etc2->name,
            'emails' => $etc2->emails,
            'etc_id' => 2,
            'status' => 'submitted',
            'fee' => 35,
            'pickup_time' => date('H:i:s'),
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);

        $event = factory(Event::class)->make([
            'name' => 'Two residents visit the local hospital',
            'transportation_type' => 'external',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'client_id' => $clients[0]->id]);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment(['passenger_id' => $passenger->id, 'time' => '10:00:00', 'location_id' => 1]);
        $appointment->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'client_id' => $clients[1]->id]);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment(['passenger_id' => $passenger->id, 'time' => '10:30:00', 'location_id' => 1]);
        $appointment->save(['unprotected' => true]);
        $driver = new Driver([
            'event_id' => $event->id,
            'name' => $etc2->name,
            'emails' => $etc2->emails,
            'etc_id' => 2,
            'status' => 'accepted',
            'fee' => 25,
            'pickup_time' => date('H:i:s'),
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);

        $event = factory(Event::class)->make([
            'name' => 'Rose goes to the Ambulance',
            'transportation_type' => 'external',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'name' => 'Rose Smith', 'room_number' => 'B55']);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment(['passenger_id' => $passenger->id, 'time' => '10:00:00', 'location_id' => 1]);
        $appointment->save(['unprotected' => true]);
        $driver = new Driver([
            'event_id' => $event->id,
            'name' => 'Test Driver 4',
            'status' => 'accepted',
            'fee' => 10,
            'pickup_time' => date('H:i:s'),
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);

        $location = factory(\App\Models\Location\Location::class)->make(['facility_id' => 1]);
        $location->save(['unprotected' => true]);
        $event = factory(Event::class)->make([
            'name' => "{$clients[1]->first_name} goes to dialysis",
            'rrule' => 'FREQ=WEEKLY;INTERVAL=1;BYDAY=TU,FR',
            'location_id' => $location->id,
            'transportation_type' => 'internal',
        ]);
        $event->save(['unprotected' => true]);
        $passenger = new Passenger(['event_id' => $event->id, 'client_id' => $clients[1]->id]);
        $passenger->save(['unprotected' => true]);
        $appointment = new Appointment(['passenger_id' => $passenger->id, 'time' => '10:00:00', 'location_id' => 1]);
        $appointment->save(['unprotected' => true]);

        $driver = new Driver([
            'event_id' => $event->id,
            'name' => \App\Models\User::withoutGlobalScopes()->find(5)->getFullName(),
            'user_id' => 5,
            'status' => 'accepted',
            'pickup_time' => date('H:i:s'),
            'hash' => base64_encode(Hash::make('secret')),
        ]);
        $driver->save(['unprotected' => true]);
    }
}
