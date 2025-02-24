<?php

namespace App\Policies\Event;

use App\Policies\BasePolicy;
use App\Models\User;

class AppointmentPolicy extends BasePolicy
{
    /**
     * Determine whether the policy allows an action.
     *
     * @param  \App\Models\User $user
     * @param string $action
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    protected function allows(User $user, string $action, $model)
    {
        switch ($user->role_id) {
            case $this->roles['Super Admin']:
                return true;
            case $this->roles['Organization Admin']:
            case $this->roles['Upper Management']:
                return $user->organization_id == $model->passenger->event->facility->organization_id;
            case $this->roles['Facility Admin']:
                return $user->facility_id == $model->passenger->event->facility_id;
            case $this->roles['Master User']:
            case $this->roles['Administrator']:
                return $user->facility_id == $model->passenger->event->facility_id
                    && $this->custom($user, $action, $model);
            default:
                return false;
        }
    }
}
