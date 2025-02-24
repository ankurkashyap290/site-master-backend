<?php

namespace App\Http\Requests\Report;

use App\Http\Requests\LoggedInRequest;

class ViewReportRequest extends LoggedInRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return parent::authorize() && (int)auth()->user()->role_id !== config()->get('roles')['Administrator'];
    }
}
