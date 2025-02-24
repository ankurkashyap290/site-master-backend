<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\User\UserRepository;

class UniqueUser implements Rule
{
    /**
     * @var $repository UserRepository
     */
    protected $repository;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     *
     * @SuppressWarnings("unused")
     */
    public function passes($attribute, $value): bool
    {
        return $this->repository->getCountByEmail($value) === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'User email must be unique in system.';
    }
}
