<?php

namespace App\Http\Requests\User;

use App\Http\Requests\LoggedInRequest;

class ListUserRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    protected function addRules(): array
    {
        return [
            'organization_id' => 'integer|exists:organizations,id',
            'facility_id' => 'integer|exists:facilities,id',
            'role_id' => 'integer|exists:roles,id',
            'order_by' => 'required_with:order|string|in:id,first_name,role_id,email',
            'order' => 'required_with:order_by|string|in:ASC,DESC,asc,desc',
            'page' => 'integer'
        ];
    }
}
