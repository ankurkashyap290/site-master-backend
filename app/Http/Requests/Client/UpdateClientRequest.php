<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\LoggedInRequest;
use App\Repositories\Client\ClientRepository;

class UpdateClientRequest extends LoggedInRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $repository = new ClientRepository();
        return $repository->find($this->route('id')) !== null && parent::authorize();
    }

    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|size:5',
            'data.attributes.first_name' => 'required|string|max:255',
            'data.attributes.middle_name' => 'nullable|string|max:255',
            'data.attributes.last_name' => 'required|string|max:255',
            'data.attributes.room_number' => 'required|string|max:255',
            'data.attributes.responsible_party_email' => 'nullable|string|max:255',
        ];
    }
}
