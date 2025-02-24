<?php

namespace App\Http\Requests\Location;

use App\Rules\ValidLocationCSV;

class ImportLocationRequest extends StoreLocationRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'csv' => [ 'required', 'file', 'max:2048', new ValidLocationCSV ],
        ];
    }
}
