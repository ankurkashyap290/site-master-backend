<?php

namespace App\Http\Requests\Client;

class DeleteClientRequest extends UpdateClientRequest
{
    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [];
    }
}
