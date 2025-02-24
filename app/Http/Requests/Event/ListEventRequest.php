<?php

namespace App\Http\Requests\Event;

use App\Http\Requests\LoggedInRequest;

class ListEventRequest extends LoggedInRequest
{
    protected function addRules(): array
    {
        return [
            'fromDate' => 'required_with:toDate|date_format:Y-m-d|before_or_equal:toDate',
            'toDate' => 'required_with:fromDate|date_format:Y-m-d|after_or_equal:fromDate',
            'searchKey' => 'string',
        ];
    }
}
