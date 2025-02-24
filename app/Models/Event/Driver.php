<?php

namespace App\Models\Event;

use App\Models\ETC\ExternalTransportationCompany;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PolicyProtected;

class Driver extends Model
{
    use PolicyProtected;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'etc_id', 'user_id', 'status', 'hash', 'name', 'emails', 'pickup_time', 'fee',
    ];

    /**
     * Searchable fields
     *
     * @var array
     */
    protected $searchableFields = [
        'name', 'emails',
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

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function etc()
    {
        return $this->belongsTo(ExternalTransportationCompany::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
