<?php

namespace App\Http\Requests\User;

class UserResetPasswordRequest extends UpdateUserRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'id' => 'required|exists:users',
        ];
    }

    /**
     * Get data to be validated from the request and add Route parameter
     *
     * @return array
     */
    protected function validationData(): array
    {
        return array_merge($this->request->all(), [
            'id' => $this->route()->parameter('id'),
        ]);
    }
}
