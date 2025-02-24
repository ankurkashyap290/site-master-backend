<?php

namespace App\Http\Requests\User;

use App\Http\Requests\LoggedInRequest;

class UpdateUserRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|between:5,6',
            'data.attributes.first_name' => ['required', 'string', 'max:255'],
            'data.attributes.middle_name' => ['nullable', 'string', 'max:255'],
            'data.attributes.last_name' => ['required', 'string', 'max:255'],
            'data.attributes.color_id' => ['nullable', 'integer', 'exists:colors,id'],
            'data.attributes.role_id' => ['required', 'integer'],
            'data.attributes.phone' => ['nullable', 'string', 'max:255'],
        ];
    }
}
