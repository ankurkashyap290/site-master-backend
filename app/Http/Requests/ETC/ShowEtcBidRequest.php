<?php

namespace App\Http\Requests\ETC;

use App\Http\Requests\Request;
use App\Repositories\Event\DriverRepository;

class ShowETCBidRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return (new DriverRepository)->driverExists($this->hash);
    }
}
