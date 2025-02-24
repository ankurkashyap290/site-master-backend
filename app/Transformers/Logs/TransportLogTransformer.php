<?php

namespace App\Transformers\Logs;

use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;

class TransportLogTransformer extends TransformerAbstract implements TransformerInterface
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
            'equipment' => $response->equipment,
            'equipment_secured' => (int)$response->equipment_secured,
            'signature' => $response->signature,
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
        return 'transport-logs';
    }
}
