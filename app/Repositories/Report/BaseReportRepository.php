<?php
namespace App\Repositories\Report;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Repositories\Repository;
use Illuminate\Support\Carbon;
use App\Models\Event\Event;

/**
 *  Base Report Repository
 */
abstract class BaseReportRepository extends Repository
{
    protected $mtdStart;
    protected $mtdEnd;
    protected $ytdStart;
    protected $ytdEnd;
    protected $projectedStart;
    protected $projectedEnd;
    protected $facilityIds;

    /**
     * Init repository settings
     */
    public function __construct()
    {
        parent::__construct();

        $this->mtdStart = Carbon::now()->startOfMonth();
        $this->mtdEnd = Carbon::yesterday()->endOfDay();
        $this->ytdStart = Carbon::now()->startOfYear();
        $this->ytdEnd = Carbon::yesterday()->endOfDay();
        $this->projectedStart = Carbon::today();
        $this->projectedEnd = Carbon::now()->endOfMonth();
        $this->facilityIds = auth()->user() ? auth()->user()->getRelatedFacilities()->pluck('id') : null;
    }

    /**
     * @param string $fromDate
     * @param string $toDate
     * @return Collection
     */
    protected function getEventSummariesBetween(string $fromDate, string $toDate): Collection
    {
        $events = Event::whereIn('facility_id', $this->facilityIds)->get();
        $eventCounts = $events->map(function ($event) use ($fromDate, $toDate) {
            return [
                'id' => $event->id,
                'count' => $event->countRecurrencesBetweenDays($fromDate, $toDate, true)
            ];
        })->filter(function ($eventData) {
            return $eventData['count'] > 0;
        })->pluck('count', 'id')->all();

        return $this->getEventSummaries(array_keys($eventCounts))
          ->map(function ($eventData) use ($eventCounts) {
              return get_object_vars($eventData) + [
                  'count' => $eventCounts[$eventData->id]
              ];
          });
    }

    /**
     * @param Collection $events
     * @param string $fromDate
     * @param string $toDate
     * @return Collection
     */
    protected function getEventRecurrencesBetweenWithSummaries(
        Collection $events,
        string $fromDate,
        string $toDate
    ): Collection {
        $eventRecurrences = (new Event())->getEventRecurrencesBetweenDates($events, $fromDate, $toDate);

        return $this->getEventSummaries(array_keys($eventRecurrences))
          ->map(function ($eventData) use ($eventRecurrences) {
              return get_object_vars($eventData) + [
                  'recurrences' => $eventRecurrences[$eventData->id]
              ];
          });
    }

    /**
     * @param array $eventIds
     * @return Collection
     */
    private function getEventSummaries(array $eventIds): Collection
    {
        return DB::table('events')
            ->join('passengers', 'events.id', '=', 'passengers.event_id')
            ->join('drivers', 'events.id', '=', 'drivers.event_id')
            ->whereIn('events.id', $eventIds)
            ->whereNotNull('drivers.etc_id')
            ->where('drivers.status', 'accepted')
            ->groupBy('events.id')
            ->select(
                'events.id',
                'events.facility_id',
                DB::raw('MAX(drivers.etc_id) AS etc_id'),
                DB::raw('MAX(drivers.fee) AS fee'),
                DB::raw('COUNT(passengers.id) AS passenger_count')
            )
            ->get();
    }
}
