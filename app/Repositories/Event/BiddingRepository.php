<?php

namespace App\Repositories\Event;

use App\Models\User;
use App\Models\Event\Driver;
use App\Models\Event\Event;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\ETC\ExternalTransportationCompany;

/**
 * Event Repository
 */
class BiddingRepository extends Repository
{
    /**
     * Return all Events by filter (using scopes).
     *
     * @param array array['status'] string $filters
     * @return array
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function listByFilters(array $filters)
    {
        $query = $this->model;
        if (!empty($filters['status'])) {
            $query = $query->{$filters['status']}();
        }
        if (array_key_exists('order', $filters)) {
            if ($filters['order_by'] === 'datetime') {
                $query
                    ->orderBy('date', $filters['order'])
                    ->orderBy('start_time', $filters['order']);
            } else {
                $query->orderBy($filters['order_by'], strtoupper($filters['order']));
            }
        }

        if (array_key_exists('page', $filters)) {
            return $query->paginate();
        }
        return $query->get();
    }

    /**
     * Assign drivers to specified event
     *
     * @param $eventId integer
     * @param $attributes array
     * @return array
     */
    public function assignDrivers($eventId, $attributes)
    {
        $event = Event::findOrFail($eventId);
        $event->transportation_type = $attributes['transportation_type'];
        $event->saveOrFail();
        if ($event->transportation_type == 'internal') {
            $this->assignInternalDriver($event, $attributes);
            return $event;
        }
        $this->assignExternalDrivers($event, $attributes);
        return $event;
    }

    /**
     * Decline all event driver this resets the event to unassigned status
     *
     * @param $eventId
     */
    public function declineAllDrivers($eventId)
    {
        $drivers = Driver::where('event_id', $eventId)->get();
        foreach ($drivers as $driver) {
            if ($driver->status === 'submitted') {
                Mail::to(explode(',', $driver->emails))->send(
                    new \App\Mail\BidDeclined($driver)
                );
            }
            $driver->delete();
        }
        $event = Event::find($eventId);
        $event->transportation_type = null;
        $event->saveOrFail();
    }

    /**
     * Accept driver by id
     *
     * @param $id integer Accepted Driver Id
     */
    public function acceptDriver($id)
    {
        $acceptedDriver = Driver::find($id);
        $acceptedDriver->status = 'accepted';
        $acceptedDriver->saveOrFail();

        $event = Event::find($acceptedDriver->event_id);
        $event->applyPickupTime($acceptedDriver->pickup_time);
        $event->saveOrFail();

        $acceptedDriver->load('event');

        Mail::to(explode(',', $acceptedDriver->emails))->send(
            new \App\Mail\BidAccepted($acceptedDriver)
        );

        $otherDrivers = Driver::where([
            ['event_id', $acceptedDriver->event_id],
            ['status', '!=', 'accepted']
        ])->get();
        foreach ($otherDrivers as $driver) {
            if ($driver->status === 'submitted') {
                Mail::to(explode(',', $driver->emails))->send(
                    new \App\Mail\BidDeclined($driver)
                );
            }
            $driver->status = 'declined';
            $driver->saveOrFail();
        }
    }

    protected function assignInternalDriver($event, $attributes)
    {
        $user = User::findOrFail($attributes['drivers'][0]['user_id']);

        $driver = new Driver;
        $driver->event_id = $event->id;
        $driver->user_id = $user->id;
        $driver->status = 'accepted';
        $driver->hash = base64_encode(Hash::make(rand()));
        $driver->name = $user->getFullName();
        $driver->emails = $user->email;
        $driver->saveOrFail();
    }

    /**
     * @SuppressWarnings(PHPMD)
     */
    protected function assignExternalDrivers($event, $attributes)
    {
        foreach ($attributes['drivers'] as $driverData) {
            $driver = new Driver;
            $driver->event_id = $event->id;
            $driver->hash = base64_encode(Hash::make(rand()));
            if (isset($driverData['etc_id'])) {
                $etc = ExternalTransportationCompany::findOrFail($driverData['etc_id']);
                $driver->status = 'pending';
                $driver->etc_id = $etc->id;
                $driver->name = $etc->name;
                $driver->emails = $etc->emails;
                $driver->pickup_time = $event->start_time;
            } else {
                $driver->status = 'accepted';
                $driver->name = $driverData['name'];
                $driver->emails = $driverData['emails'];
                $driver->pickup_time = $driverData['pickup_time'];
                $driver->fee = $driverData['fee'];

                $event->applyPickupTime($driver->pickup_time);
                $event->saveOrFail();
            }
            $driver->saveOrFail();

            if ($driver->status === 'pending') {
                Mail::to(explode(',', $driver->emails))->send(new \App\Mail\BiddingRequest($driver));
            }
        }
    }

    /**
     * Update Driver's fee
     *
     * @param $driverId
     * @param $fee
     * @SuppressWarnings("unused")
     */
    public function updateFee($driverId, $fee)
    {
        $driver = Driver::find($driverId);
        $driver->fee = $fee;
        $driver->saveOrFail();
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return Event::class;
    }
}
