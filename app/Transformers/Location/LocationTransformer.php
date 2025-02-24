<?php

namespace App\Transformers\Location;

use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;

class LocationTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \Illuminate\Database\Eloquent\Model $response
     * @return array
     */
    public function transform($response): array
    {
        return [
            'id' => $response->id,
            'name' => $response->name,
            'phone' => $response->phone,
            'address' => $response->address,
            'city' => $response->city,
            'state' => $response->state,
            'postcode' => $response->postcode,
            'facility_id' => (int)$response->facility_id,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'locations';
    }
}
