<?php

namespace App\Transformers\Event;

use App\Http\Requests\Request;
use App\Transformers\Location\LocationTransformer;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\parse_request;
use Illuminate\Support\Facades\Input;
use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;
use App\Transformers\User\UserTransformer;
use App\Models\Event\Event;

class EventTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\Event\Event $event
     * @param Request|null $request
     * @return array
     * @throws \Recurr\Exception\InvalidRRule
     * @throws \Recurr\Exception\InvalidWeekday
     */
    public function transform($event): array
    {
        return [
            'id' => (int)$event->id,
            'name' => $event->name,
            'date' => $event->date,
            'start_time' => $event->start_time,
            'end_time' => $event->end_time,
            'rrule' => $event->rrule,
            'recurrences' => $this->recurrences($event),
            'transport_type' => $event->transport_type,
            'transportation_type' => $event->transportation_type,
            'description' => (string)$event->description,
            'user' => $this->user($event),
            'facility_id' => (int)$event->facility_id,
            'location' => $this->location($event),
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
     * @param Event $event
     * @return array
     * @throws \Recurr\Exception\InvalidRRule
     * @throws \Recurr\Exception\InvalidWeekday
     * @SuppressWarnings("CyclomaticComplexity")
     */
    public function recurrences(Event $event)
    {
        if (empty($event->rrule)) {
            return [[
                'date' => $event->date,
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
            ]];
        }

        $filters = [];
        if (!empty(\request()->get('fromDate'))) {
            $filters = \request()->only('fromDate', 'toDate');
        }

        $transformer = new \Recurr\Transformer\ArrayTransformer();
        $rule = new \Recurr\Rule(
            $event->rrule,
            new \DateTime("{$event->date} {$event->start_time}"),
            new \DateTime("{$event->date} {$event->end_time}")
        );
        $recurrences = $transformer->transform($rule);

        $data = [];
        foreach ($recurrences as $recurrence) {
            $date = $recurrence->getStart();

            // Reduce recurrences to filter if provided
            if (count($filters) &&
                !$this->isBetweenDate($filters['fromDate'], $filters['toDate'], $date)) {
                continue;
            }

            $data[] = [
                'date' => $date->format('Y-m-d'),
                'start_time' => $recurrence->getStart()->format('H:i:s'),
                'end_time' => $recurrence->getEnd()->format('H:i:s'),
            ];
        }

        if ((!count($data) || ($data[0]['date'] !== $event->date)) &&
            (count($filters) &&
                $this->isBetweenDate(
                    $filters['fromDate'],
                    $filters['toDate'],
                    date_create_from_format('Y-m-d', $event->date)
                )
            )
        ) {
            array_unshift(
                $data,
                [
                    'date' => $event->date,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                ]
            );
        }

        return $data;
    }

    /**
     * Transform Location
     *
     * @param \App\Models\Event\Event $event
     * @return array
     */
    public function location(Event $event)
    {
        return $event->location ? (new LocationTransformer)->transform($event->location) : null;
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
     * Test date in interval
     *
     * @param string $fromDate
     * @param string $toDate
     * @param \DateTimeInterface $inspectedDate
     * @return bool
     */
    private function isBetweenDate(string $fromDate, string $toDate, \DateTimeInterface $inspectedDate): bool
    {
        $startTimestamp = Carbon::parse($fromDate)->startOfDay()->getTimestamp();
        $endTimestamp = Carbon::parse($toDate)->endOfDay()->getTimestamp();

        return ($startTimestamp <= $inspectedDate->getTimestamp()) && ($inspectedDate->getTimestamp() <= $endTimestamp);
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
