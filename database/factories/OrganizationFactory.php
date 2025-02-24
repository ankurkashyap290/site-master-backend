<?php

use App\Models\Organization\Organization;
use Faker\Generator as Faker;

$factory->define(
    Organization::class, function (Faker $faker) {
    return [
        'name' => $faker->text(90),
        'facility_limit' => 3,
    ];
});
