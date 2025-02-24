<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
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
            'data.attributes.token' => 'required|string|exists:password_resets,token',
            'data.attributes.password' => 'required|string',
        ];
    }
}
