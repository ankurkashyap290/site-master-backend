<?php

namespace App\Scopes;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseScope implements Scope
{
    /**
     * Checks if the application is run from CLI
     *
     * @return bool
     */
    protected function isEnabled()
    {
        return Config::get('auth.defaults.scopes') === 'enabled';
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    abstract public function apply(Builder $builder, Model $model);
}
