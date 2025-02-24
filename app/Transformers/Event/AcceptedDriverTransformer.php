<?php

namespace App\Transformers\Event;

use App\Repositories\ETC\ETCRepository;
use App\Repositories\User\UserRepository;
use App\Transformers\ETC\ETCTransformer;
use App\Transformers\User\UserTransformer;
use League\Fractal\TransformerAbstract;
use App\Models\Event\Driver;
use App\Transformers\TransformerInterface;

class AcceptedDriverTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param Driver $driver
     * @return array
     */
    public function transform($driver): array
    {
        return (new DriverTransformer())->transform($driver, false) +
        [
            'details' => $this->driverDetails($driver),
        ];
    }

    public function driverDetails($driver)
    {
        if ($driver['etc_id']) {
            return (new ETCTransformer)->transform((new ETCRepository)->find($driver['etc_id']), false);
        }
        if ($driver['user_id']) {
            return (new UserTransformer)->transform((new UserRepository)->find($driver['user_id']), false);
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
        return 'drivers';
    }
}
