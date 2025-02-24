<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Logs\TransportLog::class, function (Faker $faker) {
    $equipment = array_keys(Config::get('equipment'));
    shuffle($equipment);
    $secured = round(rand(1, 100) / 100);
    return [
        'location_name' => $faker->streetAddress(),
        'client_name' => $faker->name(),
        'equipment' => $equipment[0],
        'equipment_secured' => $secured,
        'signature' => $faker->name(),
        'date' => date('Y-m-d H:i:s', $faker->unixTime()),
        'user_id' => 1,
        'facility_id' => 1,
    ];
});

$factory->define(\App\Models\Logs\TransportBillingLog::class, function (Faker $faker) {
    $equipment = array_keys(Config::get('equipment'));
    shuffle($equipment);
    $transport_type = array_keys(Config::get('transport_type'));
    shuffle($transport_type);
    return [
        'location_name' => $faker->streetAddress(),
        'client_name' => $faker->name(),
        'destination_type' => $faker->text(30),
        'transport_type' => $transport_type[0],
        'equipment' => $equipment[0],
        'mileage_to_start' => 1,
        'mileage_to_end' => 10,
        'mileage_return_start' => 11,
        'mileage_return_end' => 20,
        'fee' => $faker->randomDigitNotNull(),
        'date' => date('Y-m-d H:i:s', $faker->unixTime()),
        'user_id' => 1,
        'facility_id' => 1,
    ];
});
