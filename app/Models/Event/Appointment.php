<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location\Location;
use App\Traits\PolicyProtected;

class Appointment extends Model
{
    use PolicyProtected;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['passenger_id', 'time', 'location_id'];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
