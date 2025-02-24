<?php

namespace App\Http\Requests\Client;

use App\Rules\ValidClientCSV;

class ImportClientRequest extends StoreClientRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'csv' => [ 'required', 'file', 'max:2048', new ValidClientCSV ],
        ];
    }
}
