<?php

namespace App\Http\Requests\ETC;

use App\Http\Requests\LoggedInRequest;

class ShowETCRequest extends LoggedInRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return parent::authorize() &&
            auth()->user()->can('view', \App\Models\ETC\ExternalTransportationCompany::findOrFail($this->route('id')));
    }
}
