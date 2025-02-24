<?php

namespace App\Http\Requests\ETC;

use App\Http\Requests\LoggedInRequest;

class StoreETCRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|between:4,6',
            'data.attributes.name' => 'required|max:255',
            'data.attributes.color_id' => 'required|integer|exists:colors,id',
            'data.attributes.emails' => 'required|string|max:255',
            'data.attributes.phone' => 'max:255',
            'data.attributes.location_id' => 'integer|exists:locations,id',
            'data.attributes.facility_id' => 'required|integer|exists:facilities,id',
        ];
    }
}
