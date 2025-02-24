<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client\Client;
use App\Traits\PolicyProtected;

class Passenger extends Model
{
    use PolicyProtected;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['event_id', 'client_id', 'name', 'room_number'];

    /**
     * Searchable fields
     *
     * @var array
     */
    protected $searchableFields = ['name', 'room_number'];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getSearchableFields(): array
    {
        return $this->searchableFields;
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
