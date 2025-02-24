<?php

namespace App\Http\Requests\User;

use App\Http\Requests\LoggedInRequest;
use App\Rules\UniqueUser;

class StoreUserRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|between:7,9',
            'data.attributes.first_name' => ['required', 'string', 'max:255'],
            'data.attributes.middle_name' => ['nullable', 'string', 'max:255'],
            'data.attributes.last_name' => ['required', 'string', 'max:255'],
            'data.attributes.email' => ['required', 'email', 'max:255', new UniqueUser],
            'data.attributes.phone' => ['nullable', 'string', 'max:255'],
            'data.attributes.role_id' => ['required', 'integer'],
            'data.attributes.color_id' => ['nullable', 'integer', 'exists:colors,id'],
            'data.attributes.organization.id' => ['required', 'integer'],
            'data.attributes.facility.id' => ['nullable', 'integer'],
        ];
    }
}
