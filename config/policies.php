<?php

/**
 * Default custom policies to be used when creating a new Facility
 */

return [
    \App\Models\Client\Client::class => [
        'Master User' => ['view'],
        'Administrator' => ['view'],
    ],
    \App\Models\Event\Event::class => [
        'Master User' => ['view', 'create', 'update'],
        'Administrator' => ['view'],
    ],
    \App\Models\Event\Passenger::class => [
        'Master User' => ['view', 'create', 'update', 'delete'],
        'Administrator' => ['view'],
    ],
    \App\Models\Event\Driver::class => [
        'Master User' => ['view', 'create', 'update', 'delete'],
        'Administrator' => ['view'],
    ],
    \App\Models\Event\Appointment::class => [
        'Master User' => ['view', 'create', 'update', 'delete'],
        'Administrator' => ['view'],
    ],
    \App\Models\Location\Location::class => [
        'Master User' => ['view', 'create', 'update', 'delete'],
        'Administrator' => ['view'],
    ],
    \App\Models\Logs\TransportBillingLog::class => [
        'Master User' => ['view', 'create', 'update', 'delete'],
        'Administrator' => ['view', 'create', 'update', 'delete'],
    ],
    \App\Models\Logs\TransportLog::class => [
        'Master User' => ['view', 'create', 'update', 'delete'],
        'Administrator' => ['view', 'create', 'update', 'delete'],
    ],
    \App\Models\ETC\ExternalTransportationCompany::class => [
        'Master User' => ['view', 'create', 'update', 'delete'],
        'Administrator' => ['view'],
    ],
];
