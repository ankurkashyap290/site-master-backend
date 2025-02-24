<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Policy::class, function (Faker $faker) {
    return [
        'facility_id' => null,
        'role_id' => null,
        'class_name' => null,
        'view' => $faker->numberBetween(0, 1),
        'create' => $faker->numberBetween(0, 1),
        'update' => $faker->numberBetween(0, 1),
        'delete' => $faker->numberBetween(0, 1),
    ];
});
