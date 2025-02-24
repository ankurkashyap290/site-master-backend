<?php

namespace App\Policies;

use App\Models\User;
use App\Scopes\FacilityScope;

class PolicyPolicy extends BasePolicy
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
     * Determine whether the user can list the models.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $emptyModel
     * @return mixed
     */
    public function list(User $user, $emptyModel)
    {
        switch ($user->role_id) {
            case $this->roles['Super Admin']:
            case $this->roles['Organization Admin']:
            case $this->roles['Upper Management']:
            case $this->roles['Facility Admin']:
                return parent::list($user, $emptyModel);
            case $this->roles['Master User']:
            case $this->roles['Administrator']:
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     * @SuppressWarnings("unused")
     */
    public function delete(User $user, $model)
    {
        return false;
    }

    /**
     * Determine whether the policy allows an action.
     *
     * @param  \App\Models\User $user
     * @param string $action
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return bool
     * @SuppressWarnings("unused")
     */
    protected function allows(User $user, string $action, $model)
    {
        switch ($user->role_id) {
            case $this->roles['Super Admin']:
                return true;
            case $this->roles['Organization Admin']:
                return $user->organization_id == $model->facility->organization_id;
            case $this->roles['Upper Management']:
                return false;
            case $this->roles['Facility Admin']:
                return $user->facility_id == $model->facility_id;
            case $this->roles['Master User']:
            case $this->roles['Administrator']:
            default:
                return false;
        }
    }
}
