<?php

namespace App\Models\Location;

use App\Models\Event\Event;
use App\Models\Event\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;
use App\Traits\PolicyProtected;
use App\Models\Organization\Facility;
use App\Models\ETC\ExternalTransportationCompany;

class Location extends Model
{
    use SoftDeletes;
    use PolicyProtected;
    use RestrictSoftDeletes;

    /**
     * The foreign keys restricted to delete
     */
    protected $restrictDeletes = ['events', 'appointments', 'externalTransportationCompanies'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'phone', 'address', 'city', 'state', 'postcode', 'facility_id', 'one_time'];

    /**
     * This array contains the searchable column names
     *
     * @var array
     */
    protected $searchableFields = ['name', 'phone', 'address', 'city', 'state', 'postcode'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['deleted_at', 'created_at', 'updated_at', 'one_time'];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getSearchableFields(): array
    {
        return $this->searchableFields;
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function externalTransportationCompanies()
    {
        return $this->hasMany(ExternalTransportationCompany::class);
    }
}
