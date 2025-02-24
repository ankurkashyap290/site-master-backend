<?php

namespace App\Models\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class PasswordReset extends Model
{
    public static function dropExpiredResetEmailTokens()
    {
        PasswordReset::where('created_at', '<', Carbon::now()
            ->subMinutes(Config::get('auth.passwords.users.expire')))
            ->delete();
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
