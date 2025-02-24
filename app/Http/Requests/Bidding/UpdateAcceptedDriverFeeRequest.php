<?php

namespace App\Http\Requests\Bidding;

use App\Http\Requests\LoggedInRequest;
use Illuminate\Validation\Rule;

class UpdateAcceptedDriverFeeRequest extends LoggedInRequest
{
    /**
     * Define validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', Rule::exists('drivers')->where('status', 'accepted')],
            'data.attributes.fee' => 'required|numeric|min:0|max:65535|regex:/^[0-9]{1,5}(\.[0-9]{0,2})?$/',
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
            'id' => $this->route()->parameter('driver_id'),
        ]);
    }
}
