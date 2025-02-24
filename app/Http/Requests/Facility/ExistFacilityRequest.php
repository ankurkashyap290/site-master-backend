<?php

namespace App\Http\Requests\Facility;

use App\Http\Requests\LoggedInRequest;

class ExistFacilityRequest extends LoggedInRequest
{
    /**
     * Define validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:facilities',
        ];
    }

    /**
     * Get data to be validated from the request and add Route parameter
     *
     * @return array
     */
    protected function validationData(): array
    {
        return array_merge($this->request->all(), [
            'id' => $this->route()->parameter('id'),
        ]);
    }
}
