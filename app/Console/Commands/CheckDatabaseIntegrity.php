<?php
/**
 * Created by PhpStorm.
 * User: blackice
 * Date: 2018.12.13.
 * Time: 15:13
 */

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Event\Event;
use App\Models\Event\Driver;
use App\Models\Client\Client;
use App\Models\Event\Passenger;
use Illuminate\Console\Command;
use App\Models\Event\Appointment;
use App\Models\Location\Location;
use App\Models\ETC\ExternalTransportationCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use phpDocumentor\Reflection\Types\Boolean;

class CheckDatabaseIntegrity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks Database integrity for soft deleted relations in Event ONLY';

    /**
     * Print error in red color
     *
     * @param $text string
     * @SuppressWarnings("PHPMD")
     */
    protected function printError($text)
    {
        if ($this->output->isDecorated()) {
            echo "\033[01;31m{$text}\033[0m";
            return;
        }
        echo $text;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Checking database integrity, please wait...\n");

        $this->info("Checking events\n");

        $this->checkEventRoots();
        $this->checkPassengers();
        $this->checkDriversWithoutDeclined();
    }

    /**
     * Check Events root relations
     *
     * @SuppressWarnings("else")
     */
    public function checkEventRoots()
    {
        $this->info('Checking location relations...');
        $events = Event::withoutGlobalScopes()->where('deleted_at', null)->get();

        $corruptedData = [];

        foreach ($events as $event) {
            if (Location::withoutGlobalScopes()->find($event->location_id)->deleted_at !== null) {
                $corruptedData[] = [
                    'location_id' => $event->location_id,
                    'context' => [
                        'facility_id' => $event->facility_id,
                    ],
                    'related' => [
                        'event_id' => $event->id,
                    ],
                ];
                $this->printError('F');
            } elseif (User::withoutGlobalScopes()->find($event->user_id)->deleted_at !== null) {
                $corruptedData[] = [
                    'user_id' => $event->user_id,
                    'context' => [
                        'facility_id' => $event->facility_id,
                    ],
                    'related' => [
                        'event_id' => $event->id,
                    ],
                ];
                $this->printError('F');
            } else {
                echo '.';
            }
        }

        echo "\n";
        if (count($corruptedData)) {
            $this->warn("\nFollowing entries has soft deleted and resource for the corresponding event");
            print_r($corruptedData);
        }
        echo "\n";
    }

    public function checkPassengers()
    {
        $this->info('Checking passenger relations...');
        $passengers = Passenger::withoutGlobalScopes()->get();

        $corruptedData = [];

        try {
            foreach ($passengers as $passenger) {
                $event = Event::withoutGlobalScopes()
                    ->findOrFail($passenger->event_id);

                if ($event->deleted_at === null) {
                    if ($passenger->client_id !== null &&
                        Client::withoutGlobalScopes()
                            ->find($passenger->client_id)->deleted_at !== null
                    ) {
                        $corruptedData[] = [
                            'client_id' => $passenger->client_id,
                            'related' => [
                                'event_id' => $passenger->event_id,
                                'passenger_id' => $passenger->id,
                            ],
                        ];
                        $this->printError('F');
                        continue;
                    }

                    $location_id = Appointment::withoutGlobalScopes()
                        ->where('passenger_id', $passenger->id)->firstOrFail()->location_id;
                    if (Location::withoutGlobalScopes()
                            ->find($location_id)->deleted_at !== null
                    ) {
                        $corruptedData[] = [
                            'location_id' => $location_id,
                            'related' => [
                                'event_id' => $passenger->event_id,
                                'passenger_id' => $passenger->id,
                            ],
                        ];
                        $this->printError('F');
                        continue;
                    }
                    echo '.';
                }
            }
        } catch (ModelNotFoundException $e) {
            echo $e->getMessage();
        }

        echo "\n";
        if (count($corruptedData)) {
            $this->warn("\nFollowing entries has soft deleted and resource for the corresponding event");
            print_r($corruptedData);
        }
        echo "\n";
    }

    /**
     * Check all drivers (without declined) with not-deleted events
     *
     * @SuppressWarnings("CyclomaticComplexity")
     */
    public function checkDriversWithoutDeclined()
    {
        $this->info('Checking drivers without declined status...');
        $drivers = Driver::withoutGlobalScopes()->get();

        $corruptedData = [];

        foreach ($drivers as $driver) {
            $event = Event::withoutGlobalScopes()->find($driver->event_id);

            if ($driver->status !== 'declined' && $event->deleted_at === null) {
                // Check internal driver
                if ($driver->user_id !== null &&
                    User::withoutGlobalScopes()
                        ->find($driver->user_id)->deleted_at !== null
                ) {
                    $corruptedData[] = [
                        'user_id' => $driver->user_id,
                        'driver_status' => $driver->status,
                        'context' => [
                            'facility_id' => $event->facility_id,
                        ],
                        'related' => [
                            'event_id' => $event->id,
                            'driver_id' => $driver->id,
                        ],
                    ];
                    $this->printError('F');
                    continue;
                }
                // Check external driver
                if ($driver->etc_id !== null) {
                    $etc = ExternalTransportationCompany::withoutGlobalScopes()
                        ->find($driver->etc_id);
                    if ($etc->deleted_at !== null
                    ) {
                        $corruptedData[] = [
                            'etc_id' => $driver->etc_id,
                            'driver_status' => $driver->status,
                            'context' => [
                                'facility_id' => $event->facility_id,
                            ],
                            'related' => [
                                'event_id' => $event->id,
                                'driver_id' => $driver->id,
                            ],
                        ];
                        $this->printError('F');
                        continue;
                    } elseif ($etc->location_id !== null &&
                            Location::withoutGlobalScopes()
                                ->find($etc->location_id)->deleted_at !== null
                    ) {
                        $corruptedData[] = [
                            'location_id' => $etc->location_id,
                            'context' => [
                                'facility_id' => $event->facility_id,
                            ],
                            'related' => [
                                'event_id' => $event->id,
                                'driver_id' => $driver->id,
                                'etc_id' => $driver->etc_id,
                                'driver_status' => $driver->status,
                            ],
                        ];
                        $this->printError('F');
                        continue;
                    }
                }
            }
            echo ".";
        }

        echo "\n";
        if (count($corruptedData)) {
            $this->warn("\nFollowing entries has soft deleted and resource for the corresponding event");
            print_r($corruptedData);
        }
        echo "\n";
    }
}
