<?php

namespace App\Http\Requests\Organization;

use App\Http\Requests\LoggedInRequest;
use App\Rules\UniqueOrganization;
use App\Models\Organization\Organization;

class UpdateOrganizationRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        $organization = Organization::findOrFail($this->id);
        if (auth()->user()->hasRole('Super Admin')) {
            return [
                'data.attributes' => 'required|array|between:2,3',
                'data.attributes.name' => ['required', 'string', 'max:255', new UniqueOrganization($this->route('id'))],
                'data.attributes.budget' => 'nullable|numeric|min:0|max:65535|regex:/^[0-9]{1,5}(\.[0-9]{0,2})?$/',
                'data.attributes.facility_limit' => 'required|integer|min:1|max:10000',
            ];
        }
        return [
            'data.attributes' => 'required|array|between:1,2',
            'data.attributes.name' => ['required', 'string', 'in:' . $organization->name],
            'data.attributes.budget' => 'nullable|numeric|min:0|max:65535|regex:/^[0-9]{1,5}(\.[0-9]{0,2})?$/',
        ];
    }
}
