<?php

namespace App\Http\Requests\Bidding;

use App\Http\Requests\LoggedInRequest;

class DeclineAllDriversRequest extends LoggedInRequest
{
    /**
     * Define validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'event_id' => 'required|integer|exists:drivers',
        ];
    }

    /**
     * Get data to be validated from the request and add Event id from Route parameter
     *
     * @return array
     */
    protected function validationData(): array
    {
        return array_merge($this->request->all(), [
            'event_id' => $this->route()->parameter('event_id'),
        ]);
    }
}
