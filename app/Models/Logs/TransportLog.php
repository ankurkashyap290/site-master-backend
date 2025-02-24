<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\PolicyProtected;
use App\Models\Organization\Facility;
use App\Models\User;

class TransportLog extends Model
{
    use SoftDeletes;
    use PolicyProtected;

    /**
     * The attributes that are protected against mass-assignment.
     *
     * @var array
     */
    protected $guarded = ['id', 'deleted_at', 'created_at', 'updated_at'];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
