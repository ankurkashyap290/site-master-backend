<?php

namespace App\Transformers\ETC;

use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;
use App\Transformers\Location\LocationTransformer;

class ETCTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \Illuminate\Database\Eloquent\Model $response
     * @param bool $verbose
     * @return array
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function transform($response, $verbose = true): array
    {
        if (!$verbose) {
            return [
                'id' => $response->id,
                'name' => $response->name,
                'color_id' => (int)$response->color_id,
                'emails' => $response->emails,
                'phone' => $response->phone ? $response->phone : '',
            ];
        }
        return [
            'id' => $response->id,
            'name' => $response->name,
            'color_id' => (int)$response->color_id,
            'emails' => $response->emails,
            'phone' => $response->phone ? $response->phone : '',
            'location_id' => (int)$response->location_id,
            'facility_id' => (int)$response->facility_id,
            'location' => $this->getLocation($response),
        ];
    }

    /**
     * Get ETC location
     */
    protected function getLocation($response)
    {
        if ($response->location_id) {
            return (new LocationTransformer)->transform($response->location);
        }
        return null;
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'etcs';
    }
}
