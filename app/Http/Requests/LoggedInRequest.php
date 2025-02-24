<?php

namespace App\Http\Requests;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class LoggedInRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user() !== null;
    }
}
