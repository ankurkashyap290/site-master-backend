<?php

namespace App\Policies;

use App\Models\User;
use App\Scopes\FacilityScope;
use App\Scopes\OrganizationScope;

class UserPolicy extends BasePolicy
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
            new OrganizationScope,
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
     * @SuppressWarnings("unused")
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function allows(User $user, string $action, $model)
    {
        if ($user->id == $model->id && $user->role_id == $model->role_id) {
            return true;
        }
        switch ($user->role_id) {
            case $this->roles['Super Admin']:
                return in_array($model->role_id, [$this->roles['Super Admin'], $this->roles['Organization Admin']]);
            case $this->roles['Organization Admin']:
            case $this->roles['Upper Management']:
                return
                    $user->organization_id == $model->organization_id &&
                    !in_array($model->role_id, [$this->roles['Super Admin'], $this->roles['Organization Admin']]);
            case $this->roles['Facility Admin']:
                return
                    $user->facility_id == $model->facility_id &&
                    in_array($model->role_id, [$this->roles['Master User'], $this->roles['Administrator']]);
            case $this->roles['Master User']:
            case $this->roles['Administrator']:
            default:
                return false;
        }
    }
}
