<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Event\Event;
use App\Models\Client\Client;
use App\Models\ETC\ExternalTransportationCompany;
use App\Models\Logs\TransportLog;
use App\Models\Logs\TransportBillingLog;
use App\Models\User;
use App\Models\Policy;
use App\Traits\PolicyProtected;

class Facility extends Model
{
    use SoftDeletes;
    use PolicyProtected;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'organization_id', 'timezone', 'location_id', 'budget'];

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if ($this->exists) {
            return parent::save($options);
        }
        // else
        $saved = parent::save($options);
        $this->createPolicies($options);
        return $saved;
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function externalTransportationCompanies()
    {
        return $this->hasMany(ExternalTransportationCompany::class);
    }

    public function transportLogs()
    {
        return $this->hasMany(TransportLog::class);
    }

    public function transportBillingLogs()
    {
        return $this->hasMany(TransportBillingLog::class);
    }

    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    public function createPolicies(array $options = [])
    {
        $policies = config('policies');
        $roles = config('roles');
        foreach ($policies as $className => $rules) {
            foreach ($rules as $role => $permissions) {
                $policy = new Policy();
                $policy->facility_id = $this->id;
                $policy->role_id = $roles[$role];
                $policy->class_name = $className;
                $policy->view = in_array('view', $permissions) || in_array('*', $permissions);
                $policy->create = in_array('create', $permissions) || in_array('*', $permissions);
                $policy->update = in_array('update', $permissions) || in_array('*', $permissions);
                $policy->delete = in_array('delete', $permissions) || in_array('*', $permissions);
                $policy->save($options);
            }
        }
    }
}
