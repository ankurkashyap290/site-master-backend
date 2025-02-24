<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\LoggedInRequest;

class StoreClientRequest extends LoggedInRequest
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
            'data.attributes.first_name' => 'required|string|max:255',
            'data.attributes.middle_name' => 'max:255',
            'data.attributes.last_name' => 'required|string|max:255',
            'data.attributes.room_number' => 'required|string|max:255',
            'data.attributes.responsible_party_email' => 'nullable|string|max:255',
            'data.attributes.facility_id' => 'required|integer|exists:facilities,id',
        ];
    }
}
