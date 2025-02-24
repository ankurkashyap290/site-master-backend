<?php

namespace App\Http\Requests\Location;

class DeleteLocationRequest extends UpdateLocationRequest
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
