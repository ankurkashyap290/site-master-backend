<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Traits\PolicyProtected;

class Organization extends Model
{
    use SoftDeletes;
    use PolicyProtected;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'budget', 'facility_limit'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
}
