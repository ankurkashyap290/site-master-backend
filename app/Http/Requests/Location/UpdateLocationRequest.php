<?php

namespace App\Http\Requests\Location;

use App\Repositories\Location\LocationRepository;

class UpdateLocationRequest extends StoreLocationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $repository = new LocationRepository();
        return $repository->find($this->route('id')) !== null && parent::authorize();
    }
}
