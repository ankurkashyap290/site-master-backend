<?php

namespace App\Repositories\Report;

use App\Models\ETC\ExternalTransportationCompany;
use App\Models\Event\Event;
use App\Models\Event\Driver;
use Carbon\Carbon;

/**
 * Etc Report Repository
 */
class EtcReportRepository extends BaseReportRepository
{
    /**
     * Get ETC report
     *
     * @return mixed
     */
    public function getEtcReport()
    {
        $ytdSummaries = $this->getEtcSummariesBetween(
            $this->ytdStart->format('Y-m-d'),
            $this->ytdEnd->format('Y-m-d')
        );
        $mtdSummaries = $this->getEtcSummariesBetween(
            $this->mtdStart->format('Y-m-d'),
            $this->mtdEnd->format('Y-m-d')
        );
        $projectedSummaries = $this->getEtcSummariesBetween(
            $this->projectedStart->format('Y-m-d'),
            $this->projectedEnd->format('Y-m-d')
        );
        $etcs = $this->model->orderBy('name', 'asc')->whereIn('facility_id', $this->facilityIds)->get();

        return $etcs->map(function ($etc) use ($ytdSummaries, $mtdSummaries, $projectedSummaries) {
            return [
                'id' => $etc->id,
                'name' => $etc->name,
                'ytd' => $ytdSummaries[$etc->id] ?? ['cost' => 0, 'passengers' => 0],
                'mtd' => $mtdSummaries[$etc->id] ?? ['cost' => 0, 'passengers' => 0],
                'projected' => $projectedSummaries[$etc->id] ?? ['cost' => 0, 'passengers' => 0],
            ];
        })->toArray();
    }

    /**
     * Get specific ETC details
     *
     * @param $id
     * @return mixed
     */
    public function getEtcDetails($id)
    {
        $etc = ExternalTransportationCompany::findOrFail($id);
        $events = Event::where('facility_id', $etc->facility_id)->get();

        $ytdDates = [];
        $this->getEventRecurrencesBetweenWithSummaries(
            $events,
            $this->ytdStart->format('Y-m-d'),
            $this->ytdEnd->format('Y-m-d')
        )->each(function ($event) use (&$ytdDates, $id) {
            foreach ($event['recurrences']->toArray() as $occurence) {
                if ($event['etc_id'] != $id) {
                    continue;
                }
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
        )->each(function ($event) use (&$mtdDates, $id) {
            foreach ($event['recurrences']->toArray() as $occurence) {
                if ($event['etc_id'] != $id) {
                    continue;
                }
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
        )->each(function ($event) use (&$projectedDates, $id) {
            foreach ($event['recurrences']->toArray() as $occurence) {
                if ($event['etc_id'] != $id) {
                    continue;
                }
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
        $etc['ytd'] = $mtdDates;
        $etc['mtd'] = $mtdDates;
        $etc['projected'] = $projectedDates;
        return $etc;
    }

    /**
     * Get ETC summary in specific time range
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    private function getEtcSummariesBetween(string $startDate, string $endDate): array
    {
        $eventSummaries = $this->getEventSummariesBetween($startDate, $endDate);
        $etcSummaries = [];
        foreach ($eventSummaries as $eventSummary) {
            if (!isset($etcSummaries[$eventSummary['etc_id']])) {
                $etcSummaries[$eventSummary['etc_id']] = ['cost' => 0, 'passengers' => 0];
            }
            $etcSummaries[$eventSummary['etc_id']]['cost'] +=
                $eventSummary['fee'] * $eventSummary['count'];
            $etcSummaries[$eventSummary['etc_id']]['passengers'] +=
                $eventSummary['passenger_count'] * $eventSummary['count'];
        }
        return $etcSummaries;
    }

    /**
     * Get monthly performance data for an ETC
     *
     * @param ExternalTransportationCompany $etc
     * @return array
     */
    public function getMonthlyPerformanceData(ExternalTransportationCompany $etc)
    {
        $driversQuery = Driver::withoutGlobalScopes()->where('etc_id', $etc->id);
        $eventIds = $driversQuery->where('status', 'accepted')->pluck('event_id');
        $events = Event::withoutGlobalScopes()->whereIn('id', $eventIds)->get();

        $firstDayOfLastMonth = Carbon::parse('first day of last month')->format('Y-m-d');
        $lastDayOfLastMonth = Carbon::parse('last day of last month')->format('Y-m-d');
        $firstDayOfThisYear = Carbon::now()->startOfYear()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        return [
            'num_of_accepted_bids' => $driversQuery->where('status', 'accepted')->count(),
            'num_of_received_bids' => $driversQuery->whereIn('status', ['pending', 'accepted', 'denied'])->count(),
            'total_earned_last_month' => $this->getEarningsBetween($events, $firstDayOfLastMonth, $lastDayOfLastMonth),
            'total_earned_ytd' => $this->getEarningsBetween($events, $firstDayOfThisYear, $yesterday),
        ];
    }

    private function getEarningsBetween($events, $fromDate, $toDate): float
    {
        return $this
            ->getEventRecurrencesBetweenWithSummaries($events, $fromDate, $toDate)
            ->sum(function ($event) {
                return $event['fee'] * count($event['recurrences']);
            });
    }
    
    /**
     * ETC daily view.
     */
    public function getEtcDailyView($id, $date)
    {
        $driversQuery = Driver::withoutGlobalScopes()->where('etc_id', $id);
        $eventIds = $driversQuery->where('status', 'accepted')->pluck('event_id');
        $events = Event::withoutGlobalScopes()->whereIn('id', $eventIds)->get();

        $filteredEventIds = $this->getEventRecurrencesBetweenWithSummaries(
            $events,
            $date,
            $date
        )->pluck('id')->toArray();

        return Event::whereIn('id', $filteredEventIds)->with('facility')->get();
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return ExternalTransportationCompany::class;
    }
}
