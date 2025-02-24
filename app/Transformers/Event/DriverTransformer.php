<?php

namespace App\Transformers\Event;

use League\Fractal\TransformerAbstract;
use App\Models\Event\Driver;
use App\Transformers\TransformerInterface;

class DriverTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param Driver $driver
     * @param bool $verbose
     * @return array
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function transform($driver, $verbose = true): array
    {
        if (!$verbose) {
            return [
                'id' => $driver->id,
                'etc_id' => $driver->etc_id,
                'user_id' => $driver->user_id,
                'name' => $driver->name,
                'fee' => $driver->fee,
            ];
        }
        return [
            'id' => $driver->id,
            'event_id' => $driver->event_id,
            'etc_id' => $driver->etc_id,
            'user_id' => $driver->user_id,
            'status' => $driver->status,
            'hash' => $driver->hash,
            'name' => $driver->name,
            'emails' => $driver->emails,
            'pickup_time' => $driver->pickup_time,
            'fee' => $driver->fee,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'drivers';
    }
}
