<?php

namespace App\Http\Requests\Location;

use App\Http\Requests\LoggedInRequest;

class DeleteTransportLogRequest extends LoggedInRequest
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
