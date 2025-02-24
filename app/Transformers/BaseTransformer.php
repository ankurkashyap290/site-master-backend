<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Support\Arrayable;

class BaseTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \Illuminate\Database\Eloquent\Model $response
     * @return array
     */
    public function transform($response): array
    {
        if ($response instanceof Arrayable) {
            return $response->toArray();
        }
        return (array) $response;
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'model';
    }
}
