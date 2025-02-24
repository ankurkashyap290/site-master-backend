<?php

namespace App\Http\Requests\Organization;

use App\Http\Requests\LoggedInRequest;
use App\Rules\UniqueOrganization;

class StoreOrganizationRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|between:2,4',
            'data.attributes.name' => ['required', 'string', 'max:255', new UniqueOrganization($this->route('id'))],
            'data.attributes.budget' => 'nullable|numeric|min:0|max:65535|regex:/^[0-9]{1,5}(\.[0-9]{0,2})?$/',
            'data.attributes.facility_limit' => 'required|integer|min:1|max:10000',
        ];
    }
}
