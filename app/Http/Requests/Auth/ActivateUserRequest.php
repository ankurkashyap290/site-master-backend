<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ActivateUserRequest extends Request
{

    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|size:3',
            'data.attributes.id' => 'required|int',
            'data.attributes.token' => 'required|string',
            'data.attributes.password' => 'required|string',
        ];
    }
}
