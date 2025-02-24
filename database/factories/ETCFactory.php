<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;

$factory->define(\App\Models\ETC\ExternalTransportationCompany::class, function (Faker $faker) {
    return [
        'name' => $faker->company(),
        'color_id' => array_keys(array_filter(Config::get('colors'), function ($color) {
            return $color['type'] === 'external';
        }))[3],
        'emails' => implode(',', [$faker->email(), $faker->email()]),
        'phone' => $faker->tollFreePhoneNumber(),
        'location_id' => 1,
        'facility_id' => 1,
    ];
});
