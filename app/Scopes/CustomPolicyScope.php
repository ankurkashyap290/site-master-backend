<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CustomPolicyScope extends BaseScope
{
    protected $policy;

    public function __construct($policy)
    {
        $this->policy = $policy;
    }

    /**
     * Apply the custom policy scope to the model.
     * All non-custom scopes must be added in the model-specific policy itself!
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
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
        $builder->whereRaw((int)$this->policy->list($user, $model));
    }
}
