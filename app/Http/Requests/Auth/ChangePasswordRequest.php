<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\LoggedInRequest;
use App\Rules\OldPasswordMatches;

class ChangePasswordRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|size:2',
            'data.attributes.old_password' => ['required', 'string', new OldPasswordMatches],
            'data.attributes.new_password' => 'required|string',
        ];
    }
}
