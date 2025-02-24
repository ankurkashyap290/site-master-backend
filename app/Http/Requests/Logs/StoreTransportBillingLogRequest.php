<?php

namespace App\Http\Requests\Logs;

use App\Http\Requests\LoggedInRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class StoreTransportBillingLogRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        $user = Auth::user();
        return [
            'data.attributes' => 'required|array|size:13',
            'data.attributes.location_name' => 'required|max:255',
            'data.attributes.client_name' => 'max:255',
            'data.attributes.destination_type' => 'required|string|max:255',
            'data.attributes.transport_type' => [
                'required',
                Rule::in(array_keys(Config::get('transport_type'))),
            ],
            'data.attributes.equipment' => [
                'required',
                Rule::in(array_keys(Config::get('equipment'))),
            ],
            'data.attributes.mileage_to_start' => 'required|integer',
            'data.attributes.mileage_to_end' => 'required|integer',
            'data.attributes.mileage_return_start' => 'required|integer',
            'data.attributes.mileage_return_end' => 'required|integer',
            'data.attributes.fee' => 'required|numeric|min:0|max:65535|regex:/^[0-9]{1,5}(\.[0-9]{0,2})?$/',
            'data.attributes.date' => 'required|string',
            'data.attributes.user_id' => 'required|integer|in:' . ($user ? $user->id : '0'),
            'data.attributes.facility_id' => 'required|integer|exists:facilities,id',
        ];
    }
}
