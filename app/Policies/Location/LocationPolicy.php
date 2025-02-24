<?php

namespace App\Policies\Location;

use App\Policies\BasePolicy;
use App\Models\User;
use App\Scopes\FacilityScope;

class LocationPolicy extends BasePolicy
{

    /**
     * Returns scopes to be used for listing the model.
     * @param array $moreScopes
     * @return array
     * @SuppressWarnings("unused")
     */
    public function scopes(array $moreScopes = [])
    {
        return parent::scopes([
            new FacilityScope,
        ]);
    }

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
                return !is_null($model->facility) && $user->organization_id == $model->facility->organization_id;
            case $this->roles['Master User']:
            case $this->roles['Facility Admin']:
                return $user->facility_id == $model->facility_id;
            case $this->roles['Administrator']:
                return $user->facility_id == $model->facility_id && $this->custom($user, $action, $model);
            default:
                return false;
        }
    }
}
