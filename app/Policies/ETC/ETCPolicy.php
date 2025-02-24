<?php

namespace App\Policies\ETC;

use App\Policies\BasePolicy;
use App\Models\User;
use App\Scopes\FacilityScope;

class ETCPolicy extends BasePolicy
{
    /**
     * Returns scopes to be used for listing the model.
     *
     * @param array $moreScopes
     * @return array
     * @SuppressWarnings("unused")
     */
    public function scopes(array $moreScopes = []): array
    {
        return parent::scopes([
            new FacilityScope,
        ]);
    }

    /**
     * Determine whether the policy allows an action.
     *
     * @param  \App\Models\User  $user
     * @param string $action
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    protected function allows(User $user, string $action, $model): bool
    {
        switch ($user->role_id) {
            case $this->roles['Organization Admin']:
            case $this->roles['Upper Management']:
                return $model->facility && $user->organization_id == $model->facility->organization_id;
            case $this->roles['Facility Admin']:
                return $user->facility_id == $model->facility_id;
            case $this->roles['Master User']:
            case $this->roles['Administrator']:
                return $user->facility_id == $model->facility_id && $this->custom($user, $action, $model);
            default:
                return false;
        }
    }
}
