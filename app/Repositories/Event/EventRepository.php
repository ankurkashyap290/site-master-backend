<?php

namespace App\Repositories\Event;

use App\Mail\EventCreated;
use App\Mail\EventModified;
use App\Models\Event\Event;
use App\Models\Event\Passenger;
use App\Repositories\Repository;

/**
 * Event Repository
 */
class EventRepository extends Repository
{
    /**
     * List all event if not filter, or return back a filtered list if filters are been
     *
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters)
    {
        $query = $this->model;

        if (array_key_exists('fromDate', $filters)) {
            $fromDate = $filters['fromDate'];
            $toDate = $filters['toDate'];

            $recurrences = $this->model
                ->getEventRecurrencesBetweenDates($query->get(), $fromDate, $toDate);

            // Query for virtual and physical events
            $query = $query
                ->whereIn('id', array_keys($recurrences))
                ->orWhere(function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('date', [$fromDate, $toDate]);
                });
        }

        if (array_key_exists('searchKey', $filters)) {
            // This is a workaround for unnecessary dependency injection, because 2nd arg is Builder and not $searchKey
            $this->model->setSearchKey($filters['searchKey']);

            $query = $query->deepSearch($query);
        }

        return $query->get();
    }

    public function store(array $data)
    {
        if (empty($data['data']['attributes']['user_id'])) {
            $data['data']['attributes']['user_id'] = auth()->user()->id;
        }

        $event = parent::store($data);
        $this->savePassengers($event, $data);
        $event->sendEmails(EventCreated::class);

        return $event;
    }

    public function update(array $data, $event)
    {
        $event = parent::update($data, $event->id);
        $this->savePassengers($event, $data);
        $event->sendEmails(EventModified::class);

        return $event;
    }

    public function delete($event)
    {
        $this->find($event->id)->delete();
    }

    public function savePassengers($event, $data)
    {
        $deletableIds = $event->passengers()->pluck('id')->all();
        foreach ($data['data']['attributes']['passengers'] as $passenger) {
            $id = $passenger['id'];
            unset($passenger['id']);
            if (($key = array_search($id, $deletableIds)) !== false) {
                unset($deletableIds[$key]);
            }
            $passenger['event_id'] = $event->id;
            if ($id) {
                (new PassengerRepository)->update(['data' => ['attributes' => $passenger]], $id);
                continue;
            }
            (new PassengerRepository)->store(['data' => ['attributes' => $passenger]]);
        }
        if (count($deletableIds)) {
            Passenger::destroy($deletableIds);
        }
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
