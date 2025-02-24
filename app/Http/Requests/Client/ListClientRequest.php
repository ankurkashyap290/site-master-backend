<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\LoggedInRequest;

class ListClientRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'facility_id' => 'integer|exists:facilities,id',
            'search_key' => 'nullable|string:255',
            'order_by' => 'required_with:order|string|in:first_name,room_number,responsible_party_email',
            'order' => 'required_with:order_by|string|in:ASC,DESC,asc,desc',
        ];
    }
}
