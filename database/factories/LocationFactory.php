<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Location\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => 'CA',
        'postcode' => $faker->postcode
    ];
});
