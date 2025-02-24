<?php

namespace App\Transformers\Bidding;

use App\Transformers\Location\LocationTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;
use App\Transformers\User\UserTransformer;
use App\Transformers\Event\PassengerTransformer;
use App\Models\Event\Event;

class EventTransformer extends \App\Transformers\Event\EventTransformer implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\Event\Event $event
     * @return array
     */
    public function transform($event): array
    {
        return parent::transform($event) + [
            'status' => $event->getStatus(),
            'drivers' => $this->drivers($event),
        ];
    }

    /**
     * Transform Drivers
     *
     * @param \App\Models\Event\Event $event
     * @return array
     */
    public function drivers(Event $event)
    {
        $driversData = [];
        $drivers = $event->drivers;
        foreach ($drivers as $driver) {
            $driversData[] = (new DriverTransformer)->transform($driver);
        }
        return $driversData;
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'events';
    }
}
