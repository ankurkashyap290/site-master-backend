<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ActivableUserRequest extends Request
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
            'data.attributes.id' => 'required|int',
            'data.attributes.token' => 'required|string',
        ];
    }
}
