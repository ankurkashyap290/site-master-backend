<?php

namespace App\Models\Event;

use DateTime;
use DateTimeZone;
use App\Traits\PolicyProtected;
use App\Models\User;
use App\Models\Client\Client;
use App\Models\Location\Location;
use App\Models\Organization\Facility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Recurr\Rule;
use Recurr\Recurrence;
use Recurr\Exception\InvalidRRule;
use Recurr\Exception\InvalidWeekday;
use Recurr\RecurrenceCollection;
use Recurr\Transformer\ArrayTransformer;
use Recurr\Transformer\Constraint\BetweenConstraint;

/**
 * Class Event
 *
 * @package App\Models\Event
 * @SuppressWarnings("CouplingBetweenObjects")
 */
class Event extends Model
{
    use SoftDeletes;
    use PolicyProtected;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'date', 'start_time', 'end_time', 'rrule',
        'transport_type', 'transportation_type', 'description', 'user_id', 'facility_id', 'location_id',
    ];

    /**
     * Searchable fields
     *
     * @var array
     */
    protected $searchableFields = [
        'name', 'transport_type', 'transportation_type', 'description'
    ];

    /**
     * It stores a search key for search
     *
     * @var string
     */
    protected $searchKey;

    /**
     * Sets search key (must call before search affects)
     *
     * @param mixed $searchKey
     */
    public function setSearchKey($searchKey): void
    {
        $this->searchKey = $searchKey;
    }

    /**
     * Returns searchable fields
     *
     * @return array
     */
    public function getSearchableFields(): array
    {
        return $this->searchableFields;
    }

    /**
     * Scope a query to only include events without any drivers assigned.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('drivers')
                ->whereRaw('drivers.event_id = events.id')
                ->whereRaw('drivers.status IN("pending", "submitted", "accepted")');
        });
    }

    /**
     * Scope a query to only include events with any drivers pending.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePending($query)
    {
        return $query->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('drivers')
                ->whereRaw('drivers.event_id = events.id')
                ->whereRaw('drivers.status IN("pending", "submitted")');
        });
    }

    /**
     * Scope a query to only include events with a driver accepted.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAccepted(Builder $query)
    {
        return $query->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('drivers')
                ->whereRaw('drivers.event_id = events.id')
                ->whereRaw('drivers.status = "accepted"');
        });
    }

    /**
     * Get all relevant Events corresponding searchKey (must be present before invokes this function)
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeDeepSearch(Builder $builder)
    {
        // This is a workaround for dependency injection, because 2nd arg is Builder and not $searchKey
        $searchKey = $this->searchKey;

        return $builder->whereExists(
            function ($queryBuilder) use ($searchKey) {
                $searchableFields = [
                    'event' => $this->getSearchableFields(),
                    'location' => (new Location())->getSearchableFields(),
                    'passenger' => (new Passenger())->getSearchableFields(),
                    'client' => (new Client())->getSearchableFields(),
                    'driver' => (new Driver())->getSearchableFields(),
                ];

                $queryBuilder
                    ->select(DB::raw(1))
                    ->from('events AS e')
                    ->leftJoin('passengers', 'e.id', '=', 'passengers.event_id')
                    ->leftJoin('appointments', 'passengers.id', '=', 'appointments.passenger_id')
                    ->leftJoin('clients', 'passengers.client_id', '=', 'clients.id')
                    ->leftJoin(
                        'locations',
                        function ($leftJoin) {
                            $leftJoin
                                ->on('locations.id', '=', 'e.location_id')
                                ->orOn('locations.id', '=', 'appointments.location_id');
                        }
                    )
                    ->leftJoin('drivers', 'e.id', '=', 'drivers.event_id')
                    ->whereRaw('e.id = events.id')
                    ->where(
                        function ($queryBuilder) use ($searchKey, $searchableFields) {
                            $queryBuilder
                                ->orWhere(
                                    function ($builder) use ($searchKey, $searchableFields) {
                                        foreach ($searchableFields['event'] as $searchableField) {
                                            $builder
                                                ->orWhere('e.' . $searchableField, 'LIKE', "%$searchKey%");
                                        }
                                    }
                                )
                                ->orWhere(
                                    function ($builder) use ($searchKey, $searchableFields) {
                                        foreach ($searchableFields['location'] as $searchableField) {
                                            $builder
                                                ->orWhere('locations.' . $searchableField, 'LIKE', "%$searchKey%");
                                        }
                                    }
                                )
                                ->orWhere(
                                    function ($builder) use ($searchKey, $searchableFields) {
                                        foreach ($searchableFields['passenger'] as $searchableField) {
                                            $builder
                                                ->orWhere('passengers.' . $searchableField, 'LIKE', "%$searchKey%");
                                        }
                                    }
                                )
                                ->orWhere(
                                    function ($builder) use ($searchKey, $searchableFields) {
                                        foreach ($searchableFields['client'] as $searchableField) {
                                            $builder
                                                ->orWhere('clients.' . $searchableField, 'LIKE', "%$searchKey%");
                                        }
                                    }
                                )
                                ->orWhere(
                                    function ($builder) use ($searchKey, $searchableFields) {
                                        $builder
                                            ->where('drivers.status', '=', 'accepted')
                                                ->where(
                                                    function ($builder) use ($searchKey, $searchableFields) {
                                                        foreach ($searchableFields['driver'] as $searchableField) {
                                                            $builder
                                                                ->orWhere(
                                                                    'drivers.' . $searchableField,
                                                                    'LIKE',
                                                                    "%$searchKey%"
                                                                );
                                                        }
                                                    }
                                                );
                                    }
                                );
                        }
                    );
            }
        );
    }

    /**
     * Gets the driver assignment status of the event
     *
     * @return string
     */
    public function getStatus()
    {
        $status = 'unassigned';
        $drivers = $this->drivers;
        foreach ($drivers as $driver) {
            switch ($driver->status) {
                case 'accepted':
                    return 'accepted';
                case 'pending':
                case 'submitted':
                    $status = 'pending';
            }
        }
        return $status;
    }

    /**
     * Returns count of recurrences between two days
     *
     * @param string $fromDate
     * @param string $toDate
     * @param bool $including
     * @return integer
     * @throws InvalidRRule
     * @throws InvalidWeekday
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function countRecurrencesBetweenDays(string $fromDate, string $toDate, bool $including = true)
    {
        return count($this->getAllRecurrences($fromDate, $toDate, $including));
    }

    /**
     * Returns true if the event is ongoing at the moment, false otherwise
     *
     * @return bool
     * @throws InvalidRRule
     * @throws InvalidWeekday
     * @throws InvalidRRule
     */
    public function isOngoing()
    {
        $facilityTimezone = new DateTimeZone($this->facility->timezone);
        $start = (new DateTime($this->start_time, $facilityTimezone))->getTimestamp();
        $end = (new DateTime($this->end_time, $facilityTimezone))->getTimestamp();
        $now = (new DateTime('now', $facilityTimezone))->getTimestamp();

        if ($start > $now || $end <= $now) {
            return false;
        }
        return $this->countRecurrencesBetweenDays(date('Y-m-d'), date('Y-m-d'), true) > 0;
    }

    /**
     * Return all recurrences of an event between two date
     *
     * @param string $fromDate
     * @param string $toDate
     * @param bool $including
     * @return Recurrence[]|RecurrenceCollection
     * @throws InvalidRRule
     * @throws InvalidWeekday
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getAllRecurrences(string $fromDate, string $toDate, bool $including = true)
    {
        $recurrences = [];
        if (!$this->rrule) {
            $eventTime = strtotime($this->date);
            $fromTime = strtotime($fromDate);
            $toTime = strtotime($toDate);

            $matchesInterval = $eventTime > $fromTime && $eventTime < $toTime;
            if ($including) {
                $matchesInterval = $eventTime >= $fromTime && $eventTime <= $toTime;
            }
            if ($matchesInterval) {
                $recurrences[] = new Recurrence(
                    new DateTime($this->date ." " . $this->start_time),
                    new DateTime($this->date ." " . $this->end_time),
                    1
                );
            }
            return new RecurrenceCollection($recurrences);
        }

        $rule = new Rule(
            $this->rrule,
            new DateTime("{$this->date} {$this->start_time}")
        );

        $constraint = new BetweenConstraint(
            new DateTime("{$fromDate} 0:00:00"),
            new DateTime("{$toDate} 23:59:59"),
            $including
        );
        return (new ArrayTransformer())->transform($rule, $constraint);
    }

    /**
     * @param Collection $events
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
    public function getEventRecurrencesBetweenDates(
        Collection $events,
        string $fromDate,
        string $toDate
    ) {
        $eventRecurrences = $events->map(function ($event) use ($fromDate, $toDate) {
            return [
                'id' => $event->id,
                'recurrences' => $event->getAllRecurrences($fromDate, $toDate, true)
            ];
        })->filter(function ($eventData) {
            return count($eventData['recurrences']) > 0;
        })->pluck('recurrences', 'id')->all();

        return $eventRecurrences;
    }

    /**
     * Returns true if the event is upcoming in the next 24 hours, false otherwise
     *
     * @return string|bool
     * @throws InvalidRRule
     * @throws InvalidWeekday
     * @throws InvalidRRule
     */
    public function isUpcoming()
    {
        $facilityTimezone = new DateTimeZone($this->facility->timezone);
        $start = (new DateTime($this->start_time, $facilityTimezone))->getTimestamp();
        $now = (new DateTime('now', $facilityTimezone))->getTimestamp();
        $todayString = date('Y-m-d');
        $tomorrowString = date('Y-m-d', strtotime('tomorrow'));

        if ($start > $now && $this->countRecurrencesBetweenDays($todayString, $todayString, true) > 0) {
            return $todayString;
        }

        if ($start <= $now && $this->countRecurrencesBetweenDays($tomorrowString, $tomorrowString, true) > 0) {
            return $tomorrowString;
        }

        return false;
    }

    /**
     * Apply pickup time on event
     *
     * @param string $pickupTime
     */
    public function applyPickupTime($pickupTime)
    {
        $this->end_time = date(
            'H:i:s',
            strtotime($this->end_time) - strtotime($this->start_time) + strtotime($pickupTime)
        );
        $this->start_time = $pickupTime;
    }

    /**
     * Sends out emails to responsible parties
     *
     * @param string $mailClass
     * @param mixed $nextDate
     * @return Event
     */
    public function sendEmails($mailClass, $nextDate = null)
    {
        $passengers = $this->passengers()->withoutGlobalScopes()->get();
        foreach ($passengers as $passenger) {
            $client = $passenger->client_id ? $passenger->client()->withoutGlobalScopes()->first() : null;
            if ($client && $client->responsible_party_email) {
                $mails = explode(',', $client->responsible_party_email);
                foreach ($mails as $mail) {
                    Mail::to($mail)
                        ->send(new $mailClass($passenger, $nextDate));
                }
            }
        }
        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withoutGlobalScopes();
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function acceptedDriver()
    {
        return $this->hasOne(Driver::class)->where('status', 'accepted');
    }
}
