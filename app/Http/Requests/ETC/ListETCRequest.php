<?php

namespace App\Http\Requests\ETC;

use App\Http\Requests\LoggedInRequest;

class ListETCRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'facility_id' => 'required|integer|exists:facilities,id',
            'page' => 'integer',
            'order_by' => 'required_with:order|string|in:id,name',
            'order' => 'required_with:order_by|string|in:ASC,DESC,asc,desc',
        ];
    }
}
