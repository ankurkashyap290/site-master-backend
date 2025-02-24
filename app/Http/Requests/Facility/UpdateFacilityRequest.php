<?php

namespace App\Http\Requests\Facility;

use App\Http\Requests\LoggedInRequest;
use App\Rules\UniqueFacility;
use App\Rules\ValidTimezone;

class UpdateFacilityRequest extends LoggedInRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|between:1,4',
            'data.attributes.name' => ['required', 'string', 'max:255', new UniqueFacility($this->route('id'))],
            'data.attributes.location_id' => ['nullable', 'integer', 'exists:locations,id'],
            'data.attributes.timezone' => ['string', 'max:255', new ValidTimezone()],
            'data.attributes.budget' => 'nullable|numeric|min:0|max:65535|regex:/^[0-9]{1,5}(\.[0-9]{0,2})?$/',
        ];
    }
}
