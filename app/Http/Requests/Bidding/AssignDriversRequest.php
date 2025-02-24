<?php

namespace App\Http\Requests\Bidding;

use App\Http\Requests\Request;
use App\Rules\ValidDrivers;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

class AssignDriversRequest extends Request
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|size:2',
            'data.attributes.transportation_type' => [
                'required',
                'string',
                Rule::in(array_keys(Config::get('transportation_type'))),
            ],
            'data.attributes.drivers' => new ValidDrivers,
        ];
    }
}
