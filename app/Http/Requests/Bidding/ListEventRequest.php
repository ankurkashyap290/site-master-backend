<?php

namespace App\Http\Requests\Bidding;

use App\Http\Requests\LoggedInRequest;

class ListEventRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'status' => 'nullable|string|in:"unassigned","pending","accepted"',
            'order_by' => 'required_with:order|string|in:id,name,datetime',
            'order' => 'required_with:order_by|string|in:ASC,DESC,asc,desc',
            'page' => 'integer'
        ];
    }
}
