<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Organization\Organization;

class OrganizationScope extends BaseScope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     * @SuppressWarnings("unused")
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $user = auth()->user();
        if (!$user) {
            $builder->whereRaw(0);
            return;
        }
        
        if ($user && $user->organization_id) {
            $key = get_class($model) === Organization::class ? 'id' : 'organization_id';
            $builder->where($key, $user->organization_id);
        }
    }
}
