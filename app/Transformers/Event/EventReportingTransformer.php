<?php

namespace App\Transformers\Event;

use App\Transformers\Location\LocationTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;
use App\Transformers\User\UserTransformer;
use App\Models\Event\Event;

class EventReportingTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\Event\Event $event
     * @return array
     * @throws \Recurr\Exception\InvalidWeekday
     */
    public function transform($event): array
    {
        return [
            'id' => (int)$event->id,
            'name' => $event->name,
            'user' => $this->user($event),
            'facility_name' => $event->facility->name,
            'passengers' => $this->passengers($event),
            'accepted_driver' => $this->acceptedDriver($event),
        ];
    }

    /**
     * Transform Accepted Driver
     *
     * @param Event $event
     * @return array|null
     */
    public function acceptedDriver(Event $event)
    {
        return $event->acceptedDriver ?
            (new AcceptedDriverTransformer)->transform($event->acceptedDriver) :
            null;
    }

    /**
     * Transform User
     *
     * @param \App\Models\Event\Event $event
     * @return array
     */
    public function user(Event $event)
    {
        return (new UserTransformer)->transform($event->user, false);
    }

    /**
     * Transform Passengers
     *
     * @param \App\Models\Event\Event $event
     * @return array
     */
    public function passengers(Event $event)
    {
        $passengersData = [];
        $passengers = $event->passengers;
        foreach ($passengers as $passenger) {
            $passengersData[] = (new PassengerTransformer)->transform($passenger);
        }
        return $passengersData;
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
