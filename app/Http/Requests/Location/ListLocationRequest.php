<?php

namespace App\Http\Requests\Location;

use App\Http\Requests\LoggedInRequest;

class ListLocationRequest extends LoggedInRequest
{
    protected function addRules(): array
    {
        return [
            'facility_id' => 'integer|exists:facilities,id',
            'order_by' => 'required_with:order|string|in:id,name,phone,address,city,state,postcode',
            'order' => 'required_with:order_by|string|in:ASC,DESC,asc,desc',
            'page' => 'integer',
        ];
    }
}
