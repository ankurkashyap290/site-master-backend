<?php

namespace App\Http\Requests\Organization;

/**
 * @SuppressWarnings(PHPMD)
 */
class GetOrganizationRequest extends ExistOrganizationRequest
{
    /**
     * Define validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
