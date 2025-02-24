<?php

namespace App\Transformers\Logs;

use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;

class TransportBillingLogTransformer extends TransformerAbstract implements TransformerInterface
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
            'location_name' => $response->location_name,
            'client_name' => $response->client_name,
            'destination_type' => $response->destination_type,
            'transport_type' => $response->transport_type,
            'equipment' => $response->equipment,
            'mileage_to_start' => $response->mileage_to_start,
            'mileage_to_end' => $response->mileage_to_end,
            'mileage_return_start' => $response->mileage_return_start,
            'mileage_return_end' => $response->mileage_return_end,
            'fee' => $response->fee,
            'date' => $response->date,
            'user_id' => $response->user_id,
            'facility_id' => $response->facility_id,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'transport-billing-logs';
    }
}
