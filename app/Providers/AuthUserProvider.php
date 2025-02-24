<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;

class AuthUserProvider extends EloquentUserProvider
{
    /**
     * Create a new instance of the model with all scopes switched off.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');
        return new $class([], ['unprotected' => true]);
    }
}
