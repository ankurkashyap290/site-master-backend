<?php

namespace App\Transformers\Bidding;

use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;
use App\Models\Event\Driver;
use App\Transformers\ETC\ETCTransformer;
use Illuminate\Support\Facades\DB;

class DriverTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\Event\Driver $driver
     * @return array
     */
    public function transform($driver): array
    {
        return [
            'id' => (int)$driver->id,
            'client_id' => $driver->client_id ? (int)$driver->client_id : null,
            'etc_id' => $driver->etc_id ? (int)$driver->etc_id : null,
            'etc' => $driver->etc_id ? $this->getEtc($driver) : null,
            'user_id' => $driver->user_id ? (int)$driver->user_id : null,
            'status' => $driver->status,
            'name' => $driver->name,
            'emails' => $driver->emails,
            'pickup_time' => $driver->pickup_time,
            'fee' => $driver->fee
        ];
    }

    /**
     * Get ETC of the bid.
     *
     * @param \App\Models\Event\Driver $driver
     * @return array
     */
    protected function getEtc($driver)
    {
        $etc = DB::table('external_transportation_companies')->find($driver->etc_id);
        $etc->location_id = null;
        return (new ETCTransformer)->transform($etc);
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
