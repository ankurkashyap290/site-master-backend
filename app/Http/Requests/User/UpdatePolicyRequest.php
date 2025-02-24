<?php

namespace App\Http\Requests\User;

use App\Http\Requests\LoggedInRequest;

class UpdatePolicyRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|size:4',
            'data.attributes.view' => ['integer', 'in:0,1'],
            'data.attributes.create' => ['integer', 'in:0,1'],
            'data.attributes.update' => ['integer', 'in:0,1'],
            'data.attributes.delete' => ['integer', 'in:0,1'],
        ];
    }
}
