<?php

namespace App\Models\Client;

use App\Models\Event\Passenger;
use App\Models\Organization\Facility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;
use App\Traits\PolicyProtected;

class Client extends Model
{
    use SoftDeletes;
    use PolicyProtected;
    use RestrictSoftDeletes;

    /**
     * The foreign keys restricted to delete
     */
    protected $restrictDeletes = ['passengers'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'room_number', 'responsible_party_email', 'facility_id'
    ];

    /**
     * Searchable fields
     *
     * @var array
     */
    protected $searchableFields = [
        'first_name', 'middle_name', 'last_name', 'room_number', 'responsible_party_email',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getSearchableFields(): array
    {
        return $this->searchableFields;
    }

    /**
     * Return concatenated (full) name
     *
     * @return string
     */
    public function getFullName()
    {
        return implode(' ', array_filter([$this->first_name, $this->middle_name, $this->last_name]));
    }

    public function getOngoingEvent()
    {
        foreach ($this->passengers as $passenger) {
            if ($passenger->event && $passenger->event->isOngoing()) {
                return $passenger->event;
            }
        }
        return null;
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
}
