<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Policy::class => \App\Policies\PolicyPolicy::class,

        \App\Models\Organization\Organization::class => \App\Policies\Organization\OrganizationPolicy::class,
        \App\Models\Organization\Facility::class => \App\Policies\Organization\FacilityPolicy::class,

        \App\Models\Client\Client::class => \App\Policies\Client\ClientPolicy::class,
        \App\Models\Event\Event::class => \App\Policies\Event\EventPolicy::class,
        \App\Models\Event\Passenger::class => \App\Policies\Event\PassengerPolicy::class,
        \App\Models\Event\Driver::class => \App\Policies\Event\DriverPolicy::class,
        \App\Models\Event\Appointment::class => \App\Policies\Event\AppointmentPolicy::class,
        \App\Models\Location\Location::class => \App\Policies\Location\LocationPolicy::class,

        \App\Models\Logs\TransportLog::class => \App\Policies\Logs\TransportLogPolicy::class,
        \App\Models\Logs\TransportBillingLog::class => \App\Policies\Logs\TransportBillingLogPolicy::class,

        \App\Models\ETC\ExternalTransportationCompany::class => \App\Policies\ETC\ETCPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('authUserProvider', function ($app, $config) {
            return new AuthUserProvider($app['hash'], $config['model']);
        });
    }
}
