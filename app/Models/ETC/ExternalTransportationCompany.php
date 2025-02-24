<?php

namespace App\Models\ETC;

use App\Models\Event\Driver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\PolicyProtected;
use App\Models\Location\Location;
use App\Models\Organization\Facility;
use Netpok\Database\Support\RestrictSoftDeletes;

class ExternalTransportationCompany extends Model
{
    use SoftDeletes;
    use PolicyProtected;
    use RestrictSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'color_id', 'emails', 'phone', 'location_id', 'facility_id'];

    protected $restrictDeletes = ['drivers'];

    /**
     * Location
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Facility
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    /**
     * Drivers
     */
    public function drivers()
    {
        return $this->hasMany(Driver::class, "etc_id", "id");
    }
}
