<?php

namespace App\Http\Requests\Location;

use App\Http\Requests\Request;

class StoreLocationRequest extends Request
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|between:6,8',
            'data.attributes.name' => 'required|max:255',
            'data.attributes.phone' => 'max:255',
            'data.attributes.city' => 'required|string|max:255',
            'data.attributes.state' => 'required|string|max:255',
            'data.attributes.address' => 'required|string|max:255',
            'data.attributes.postcode' => 'required|string|max:255',
            'data.attributes.facility_id' => 'required|integer|exists:facilities,id',
            'data.attributes.one_time' => 'boolean',
        ];
    }
}
