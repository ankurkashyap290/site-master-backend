<?php

use Faker\Generator as Faker;
use \App\Models\ETC\ExternalTransportationCompany;

$factory->define(\App\Models\Event\Driver::class, function (Faker $faker) {
    $etcs = ExternalTransportationCompany::withoutGlobalScopes()->get();
    $etc = $etcs->find(rand(1, count($etcs)));
    return [
        'event_id' => 1,
        'etc_id' => $etc->id,
        'name' => $etc->name,
        'emails' => $etc->emails,
        'status' => 'pending',
        'hash' => base64_encode(Hash::make(rand())),
    ];
});
