<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Organization\Facility;
use App\Traits\PolicyProtected;

class Policy extends Model
{
    use PolicyProtected;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'view', 'create', 'update', 'delete'
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
