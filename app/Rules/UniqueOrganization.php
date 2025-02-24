<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\Organization\OrganizationRepository;

class UniqueOrganization implements Rule
{
    /**
     * @var $repository \App\Repositories\Organization\OrganizationRepository
     */
    protected $repository;

    /**
     * @var $ignoreId string
     */
    protected $ignoreId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($ignoreId = null)
    {
        $this->repository = new OrganizationRepository();
        $this->ignoreId = $ignoreId;
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
        return $this->repository->getCountByName($value, $this->ignoreId) === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Organization name must be unique.';
    }
}
