<?php

namespace App\Models;

use App\Models\Auth\PasswordReset;
use App\Models\Event\Driver;
use App\Models\Event\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

use App\Models\Organization\Organization;
use App\Models\Organization\Facility;
use App\Traits\PolicyProtected;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    use PolicyProtected;
    use RestrictSoftDeletes;

    protected $restrictDeletes = ['events', 'drivers'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'remember_token', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getNewResetEmailToken()
    {
        $token = base64_encode(Hash::make(rand()));
        PasswordReset::insert([
            'email' => $this->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        return $token;
    }

    public static function getUserByResetLinkToken($token)
    {
        $row = PasswordReset::select('email')
            ->where('token', $token)
            ->first();
        return self::withoutGlobalScopes()->where('email', $row->email)->first();
    }

    public function deleteResetEmailToken()
    {
        PasswordReset::where('email', $this->email)
            ->delete();
        return $this;
    }

    public function getNewActivationToken()
    {
        $token = base64_encode(Hash::make(rand()));
        DB::table('user_activations')->insert([
            'user_id' => $this->id,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        return $token;
    }

    public function checkActivationToken($actualToken)
    {
        $activation = DB::table('user_activations')
            ->select('token')
            ->where('user_id', $this->id)
            ->first();
        return $activation && $activation->token === $actualToken;
    }

    public function deleteActivationToken()
    {
        DB::table('user_activations')
            ->where('user_id', $this->id)
            ->delete();
        return $this;
    }

    public function getFullName()
    {
        return implode(' ', array_filter([$this->first_name, $this->middle_name, $this->last_name]));
    }

    public function isAuthorizedForLogin()
    {
        if (!is_null($this->deleted_at)) {
            return false;
        }
        $roles = Config::get('roles');
        switch ($this->role_id) {
            case $roles['Super Admin']:
                return true;
            case $roles['Organization Admin']:
            case $roles['Upper Management']:
                return !is_null($this->organization);
            default:
                return !is_null($this->organization) && !is_null($this->facility);
        }
    }

    public function isBlocked()
    {
        $failedCount = Config::get('auth.attempts.failed_count');
        $attempts = DB::table('user_login_attempts')
            ->select(['created_at', 'status'])
            ->where('user_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->limit($failedCount)
            ->get()
            ->toArray();
        
        $failedAttemptsCount = count(array_filter(
            $attempts,
            function ($attempt) {
                return $attempt->status == 'failed';
            }
        ));
        if ($failedAttemptsCount < 5) {
            return false;
        }

        $blockTime = Config::get('auth.attempts.block_time');
        $lastAttemptInTime =
            strtotime($attempts[0]->created_at) > strtotime("-{$blockTime} minutes");
        $allAttemptsInRange =
            strtotime($attempts[4]->created_at) > strtotime("{$attempts[0]->created_at} - {$blockTime} minutes");

        return $lastAttemptInTime && $allAttemptsInRange;
    }

    public function logLoginAttempt($isSuccessful)
    {
        DB::table('user_login_attempts')->insert([
            'user_id' => $this->id,
            'status' => $isSuccessful ? 'successful' : 'failed',
        ]);
        return $this;
    }

    public function hasRole($roleName)
    {
        $roles = config('roles');
        return (int)$this->role_id === (int)$roles[$roleName];
    }

    public function getRelatedFacilities(): \Illuminate\Support\Collection
    {
        $roles = config('roles');
        switch ($this->role_id) {
            case $roles['Super Admin']:
                return collect([]);
            case $roles['Organization Admin']:
            case $roles['Upper Management']:
                return $this->organization->facilities;
            case $roles['Facility Admin']:
            case $roles['Master User']:
            case $roles['Administrator']:
                return collect([$this->facility]);
            default:
                return collect([]);
        }
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function resetToken()
    {
        return $this->belongsTo(PasswordReset::class);
    }

    public function color()
    {
        return $this->hasOne(Color::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public static function getByEmail($email)
    {
        return User::where('email', $email)->where('deleted_at', null)->withoutGlobalScopes()->first();
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
}
