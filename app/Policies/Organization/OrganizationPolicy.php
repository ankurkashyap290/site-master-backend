<?php

namespace App\Policies\Organization;

use App\Policies\BasePolicy;
use App\Models\User;
use App\Scopes\OrganizationScope;

class OrganizationPolicy extends BasePolicy
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
                return in_array($action, ['view', 'update']) && $user->organization_id == $model->id;
            case $this->roles['Facility Admin']:
            case $this->roles['Master User']:
            case $this->roles['Administrator']:
                return $action === 'view' && $user->organization_id == $model->id;
            default:
                return false;
        }
    }
}
