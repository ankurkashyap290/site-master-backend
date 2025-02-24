<?php

namespace App\Http\Requests\Bidding;

use App\Http\Requests\LoggedInRequest;
use Illuminate\Validation\Rule;

class AcceptDriverRequest extends LoggedInRequest
{
    /**
     * Define validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', Rule::exists('drivers')->where('status', 'submitted')],
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
