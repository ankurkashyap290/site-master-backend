<?php

namespace App\Repositories\Event;

use App\Models\Event\Driver;
use App\Repositories\Repository;

/**
 * Event Repository
 */
class DriverRepository extends Repository
{
    /**
     * Get driver by Id.
     */
    public function getById($id)
    {
        return $this->model->withoutGlobalScopes()->findOrFail($id);
    }

    /**
     * Get driver by bid hash.
     *
     * @param string $hash
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getByHash($hash)
    {
        return $this->model->withoutGlobalScopes()->where('hash', $hash)->whereNull('user_id')->get();
    }

    /**
     * Check if driver exists.
     *
     * @param string $hash
     * @return bool
     */
    public function driverExists($hash)
    {
        return $this->getByHash($hash)->count() !== 0;
    }

    /**
     * Update driver by ETC
     */
    public function updateByETC($driver, $data)
    {
        $driver = $this->model->withoutGlobalScopes()->where('id', $driver)->get()->first();
        $driver = $driver->fill($data['data']['attributes']);
        $driver->save(['unprotected' => true]);
        return $driver;
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return Driver::class;
    }
}
