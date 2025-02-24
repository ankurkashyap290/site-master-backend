<?php

namespace App\Http\Requests\Logs;

use App\Http\Requests\Request;

class ListTransportLogRequest extends Request
{
    protected function addRules(): array
    {
        return [
            'facilityId' => 'required|integer|exists:facilities,id'
        ];
    }
}
