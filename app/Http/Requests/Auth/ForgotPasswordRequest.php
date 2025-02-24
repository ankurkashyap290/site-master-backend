<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ForgotPasswordRequest extends Request
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|size:1',
            'data.attributes.email' => 'required|email|exists:users,email',
        ];
    }
}
