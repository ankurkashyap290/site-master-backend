<?php

namespace App\Http\Requests\Event;

use App\Http\Requests\LoggedInRequest;
use App\Rules\ValidPassengers;

class StoreEventRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|between:7,10',
            'data.attributes.name' => 'required|string|max:255',
            'data.attributes.passengers' => new ValidPassengers,
            'data.attributes.date' => 'required|date_format:Y-m-d',
            'data.attributes.start_time' => 'required|date_format:H:i:s',
            'data.attributes.end_time' => 'required|date_format:H:i:s',
            'data.attributes.rrule' => 'nullable|string|max:255',
            'data.attributes.transport_type' => 'required|string',
            'data.attributes.description' => 'nullable|string|max:255',
            'data.attributes.facility_id' => 'required|integer|exists:facilities,id',
            'data.attributes.location_id' => 'required|integer|exists:locations,id',
        ];
    }
}
