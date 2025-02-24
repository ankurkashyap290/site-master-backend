<?php

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Event\Event::class, function (Faker $faker) {
    $events = [' goes to the Dentist', ' goes to the Ambulance', ' meets Dr. ' . $faker->lastName];
    $transport_type = array_keys(Config::get('transport_type'));
    $user = User::withoutGlobalScopes()->where('role_id', 4)->first();
    return [
        'name' => $faker->firstName . $faker->randomElement($events),
        'date' => date('Y-m-') . $faker->dayOfMonth(28),
        'start_time' => $faker->time('H:i:s', '12:00:00'),
        'end_time' => $faker->time('H:i:s', 'now'),
        'transport_type' => $faker->randomElement($transport_type),
        'transportation_type' => null,
        'description' => '',
        'user_id' => $user->id,
        'facility_id' => $user->facility_id,
        'location_id' => 1
    ];
});
