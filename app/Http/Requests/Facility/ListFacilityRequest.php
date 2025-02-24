<?php

namespace App\Http\Requests\Facility;

use App\Http\Requests\LoggedInRequest;

class ListFacilityRequest extends LoggedInRequest
{
    protected function addRules(): array
    {
        return [
            'order_by' => 'required_with:order|string|in:id,name,timezone',
            'order' => 'required_with:order_by|string|in:ASC,DESC,asc,desc',
            'page' => 'integer',
        ];
    }
}
