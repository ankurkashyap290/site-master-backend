<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
