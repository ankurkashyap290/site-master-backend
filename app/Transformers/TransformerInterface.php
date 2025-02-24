<?php

/**
 * Transformer interface.
 */

namespace App\Transformers;

interface TransformerInterface
{

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string;

    /**
     * Transform object to array.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    public function transform($model): array;
}
