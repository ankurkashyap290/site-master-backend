<?php

use App\Models\Client\Client;
use Faker\Generator as Faker;

$factory->define(
    Client::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'room_number' => $faker->numberBetween(1, 100),
        'responsible_party_email' => $faker->email,
    ];
});
