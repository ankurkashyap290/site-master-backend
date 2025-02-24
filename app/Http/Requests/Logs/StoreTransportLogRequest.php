<?php

namespace App\Http\Requests\Logs;

use App\Http\Requests\LoggedInRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class StoreTransportLogRequest extends LoggedInRequest
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
            'data.attributes' => 'required|array|size:8',
            'data.attributes.location_name' => 'required|max:255',
            'data.attributes.client_name' => 'max:255',
            'data.attributes.equipment' => [
                'required',
                Rule::in(array_keys(Config::get('equipment'))),
            ],
            'data.attributes.equipment_secured' => 'required|boolean',
            'data.attributes.signature' => 'required|string|max:255',
            'data.attributes.date' => 'required|string',
            'data.attributes.user_id' => 'required|integer|in:' . ($user ? $user->id : '0'),
            'data.attributes.facility_id' => 'required|integer|exists:facilities,id',
        ];
    }
}
