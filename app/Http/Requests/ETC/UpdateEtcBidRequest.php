<?php

namespace App\Http\Requests\ETC;

use App\Http\Requests\Request;
use App\Repositories\Event\DriverRepository;
use Illuminate\Validation\Rule;

class UpdateETCBidRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $driver = (new DriverRepository)->getById($this->driver);
        return $driver->status === 'pending';
    }

    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        $id = $this->driver;
        return [
            'data.attributes' => 'required|array|between:1,4',
            'data.attributes.pickup_time' => 'required_if:status,submitted|regex:/[0-2][0-9]:[0-5][0-9]:[0-5][0-9]/',
            'data.attributes.fee' =>
                'required_if:status,submitted|numeric|min:0|max:65535|regex:/^[0-9]+(\.[0-9]{0,2})?$/',
            'data.attributes.hash' => [
                'required',
                Rule::exists('drivers', 'hash')->where(function ($query) use ($id) {
                    $query->where('id', $id);
                }),
            ],
            'data.attributes.status' => 'required|in:submitted,declined',
        ];
    }
}
