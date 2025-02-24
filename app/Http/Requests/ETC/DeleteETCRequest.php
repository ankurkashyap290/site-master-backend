<?php

namespace App\Http\Requests\ETC;

use App\Http\Requests\LoggedInRequest;

class DeleteETCRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [];
    }
}
