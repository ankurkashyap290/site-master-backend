<?php

namespace App\Policies;

use App\Scopes\CustomPolicyScope;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Policy;

abstract class BasePolicy
{
    use HandlesAuthorization;

    protected $roles;

    public function __construct()
    {
        $this->roles = config()->get('roles');
    }

    /**
     * Returns scopes to be used for listing the model.
     * @param array $moreScopes
     * @return array
     */
    public function scopes(array $moreScopes = [])
    {
        return array_merge(
            [
                new CustomPolicyScope($this)
            ],
            $moreScopes
        );
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
        return $this->custom($user, 'view', $emptyModel);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function view(User $user, $model)
    {
        return $this->allows($user, 'view', $model);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function create(User $user, $model)
    {
        return $this->allows($user, 'create', $model);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function update(User $user, $model)
    {
        return $this->allows($user, 'update', $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function delete(User $user, $model)
    {
        return $this->allows($user, 'delete', $model);
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
            case $this->roles['Upper Management']:
            case $this->roles['Facility Admin']:
            case $this->roles['Master User']:
            case $this->roles['Administrator']:
            default:
                return false;
        }
    }

    /**
     * Determine whether there is a custom policy that allows an action.
     *
     * @param  \App\Models\User $user
     * @param string $action
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    protected function custom(User $user, string $action, $model)
    {
        if (empty(config('policies')[get_class($model)])) {
            return true;
        }
        if (!in_array($user->role_id, [$this->roles['Master User'], $this->roles['Administrator']])) {
            return true;
        }

        $policy = Policy::withoutGlobalScopes()
            ->where('facility_id', $user->facility_id)
            ->where('role_id', $user->role_id)
            ->where('class_name', get_class($model))
            ->first();

        return $policy ? $policy->$action : false;
    }
}
