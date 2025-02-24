<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Organization\Facility::class, function (Faker $faker) {
    return [
        'name' => substr($faker->company, 0, 200),
        'location_id' => null,
    ];
});
