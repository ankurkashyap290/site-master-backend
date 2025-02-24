<?php

namespace App\Http\Requests\Organization;

class ExistOrganizationRequest extends StoreOrganizationRequest
{
    /**
     * Define validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:organizations',
        ];
    }

    /**
     * Get data to be validated from the request and add Route parameter
     *
     * @return array
     */
    protected function validationData(): array
    {
        return array_merge($this->request->all(), [
            'id' => $this->route()->parameter('id'),
        ]);
    }
}
