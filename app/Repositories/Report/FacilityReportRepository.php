<?php

namespace App\Repositories\Report;

use App\Models\Organization\Facility;
use App\Models\Event\Event;

/**
 * FacilityReport Repository
 */
class FacilityReportRepository extends BaseReportRepository
{

    /**
     * Get facility report.
     */
    public function getFacilityReport()
    {
        $ytdSummaries = $this->getEventSummariesBetween(
            $this->ytdStart->format('Y-m-d'),
            $this->ytdEnd->format('Y-m-d')
        )->mapToGroups(function ($event) {
            return [$event['facility_id'] => [
                    'fee_summary' => (float)$event['fee'] * (int)$event['count'],
                    'passenger_count' => (int)$event['passenger_count'] * (int)$event['count'],
                ] + $event];
        });

        $mtdSummaries = $this->getEventSummariesBetween(
            $this->mtdStart->format('Y-m-d'),
            $this->mtdEnd->format('Y-m-d')
        )->mapToGroups(function ($event) {
            return [$event['facility_id'] => [
                'fee_summary' => (float)$event['fee'] * (int)$event['count'],
                'passenger_count' => (int)$event['passenger_count'] * (int)$event['count'],
            ] + $event];
        });

        $projectedSummaries = $this->getEventSummariesBetween(
            $this->projectedStart->format('Y-m-d'),
            $this->projectedEnd->format('Y-m-d')
        )->mapToGroups(function ($event) {
            return [$event['facility_id'] => [
                'fee_summary' => (float)$event['fee'] * (int)$event['count'],
                'passenger_count' => (int)$event['passenger_count'] * (int)$event['count'],
            ] + $event];
        });

        return $this->model->with('organization')
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($facility) use ($ytdSummaries, $mtdSummaries, $projectedSummaries) {
                return $facility->toArray() + [
                    'ytd' => [
                        'cost' => $ytdSummaries->get($facility['id']) ?
                            $ytdSummaries->get($facility['id'])->sum('fee_summary') : 0,
                        'passengers' => $ytdSummaries->get($facility['id']) ?
                            $ytdSummaries->get($facility['id'])->sum('passenger_count') : 0,
                    ],
                    'mtd' => [
                        'cost' => $mtdSummaries->get($facility['id']) ?
                            $mtdSummaries->get($facility['id'])->sum('fee_summary') : 0,
                        'passengers' => $mtdSummaries->get($facility['id']) ?
                            $mtdSummaries->get($facility['id'])->sum('passenger_count') : 0,
                    ],
                    'projected' => [
                        'cost' => $projectedSummaries->get($facility['id']) ?
                            $projectedSummaries->get($facility['id'])->sum('fee_summary') : 0,
                        'passengers' => $projectedSummaries->get($facility['id']) ?
                            $projectedSummaries->get($facility['id'])->sum('passenger_count') : 0,
                    ],
                ];
            });
    }

    /**
     * Get details for one facility.
     */
    public function getFacilityDetails($id)
    {
        $facility = $this->model->findOrFail($id);
        $events = Event::where('facility_id', $facility->id)->get();

        $ytdDates = [];
        $this->getEventRecurrencesBetweenWithSummaries(
            $events,
            $this->ytdStart->format('Y-m-d'),
            $this->ytdEnd->format('Y-m-d')
        )->each(function ($event) use (&$ytdDates) {
            foreach ($event['recurrences']->toArray() as $occurence) {
                $ytdDates[$occurence->getStart()->format('Y-m-d')][] = [
                    'id' => $event['id'],
                    'facility_id' => $event['facility_id'],
                    'etc_id' => $event['etc_id'],
                    'fee' => $event['fee'],
                    'passenger_count' => $event['passenger_count'],
                ];
            }
        });

        $mtdDates = [];
        $this->getEventRecurrencesBetweenWithSummaries(
            $events,
            $this->mtdStart->format('Y-m-d'),
            $this->mtdEnd->format('Y-m-d')
        )->each(function ($event) use (&$mtdDates) {
            foreach ($event['recurrences']->toArray() as $occurence) {
                $mtdDates[$occurence->getStart()->format('Y-m-d')][] = [
                    'id' => $event['id'],
                    'facility_id' => $event['facility_id'],
                    'etc_id' => $event['etc_id'],
                    'fee' => $event['fee'],
                    'passenger_count' => $event['passenger_count'],
                ];
            }
        });

        $projectedDates = [];
        $this->getEventRecurrencesBetweenWithSummaries(
            $events,
            $this->projectedStart->format('Y-m-d'),
            $this->projectedEnd->format('Y-m-d')
        )->each(function ($event) use (&$projectedDates) {
            foreach ($event['recurrences']->toArray() as $occurence) {
                $projectedDates[$occurence->getStart()->format('Y-m-d')][] = [
                    'id' => $event['id'],
                    'facility_id' => $event['facility_id'],
                    'etc_id' => $event['etc_id'],
                    'fee' => $event['fee'],
                    'passenger_count' => $event['passenger_count'],
                ];
            }
        });
        ksort($ytdDates);
        ksort($mtdDates);
        ksort($projectedDates);
        $facility['ytd'] = $ytdDates;
        $facility['mtd'] = $mtdDates;
        $facility['projected'] = $projectedDates;
        return $facility;
    }

    /**
     * Facility daily view.
     */
    public function getFacilityDailyView($id, $date)
    {
        $facility = $this->model->findOrFail($id);
        $events = Event::where('facility_id', $facility->id)->get();

        $eventIds = $this->getEventRecurrencesBetweenWithSummaries(
            $events,
            $date,
            $date
        )->pluck('id')->toArray();
        return Event::whereIn('id', $eventIds)->with('facility')->get();
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return Facility::class;
    }
}
