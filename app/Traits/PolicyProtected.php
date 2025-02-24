<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

trait PolicyProtected
{
    /**
     * The options for refining the behaviour of this model
     */
    protected $options = [
        'unprotected' => false
    ];

    /**
     * Create a new Eloquent model instance with options.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [], $options = [])
    {
        $this->options = $options;
        parent::__construct($attributes);
    }

    /**
     * Get a new query builder for the model's table, without scopes, if unprotected.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return empty($this->options['unprotected']) ?
            $this->registerGlobalScopes($this->newQueryWithoutScopes()) :
            $this->newQueryWithoutScopes();
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(array $options = [])
    {
        if (empty($options['unprotected'])) {
            $user = auth()->user();
            $action = $this->exists ? 'update' : 'create';
            if (!$user || !$user->can($action, $this)) {
                throw new AuthorizationException("You are not authorized to $action this entity!");
            }
        }
        return parent::save($options);
    }

    /**
     * Delete the model from the database.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(array $options = [])
    {
        if (empty($options['unprotected'])) {
            $user = auth()->user();
            if (!$user || !$user->can('delete', $this)) {
                throw new AuthorizationException('You are not authorized to delete this entity!');
            }
        }
        return parent::delete();
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        $scopes = Gate::getPolicyFor(__CLASS__)->scopes();
        foreach ($scopes as $scope) {
            static::addGlobalScope($scope);
        }
    }
}
