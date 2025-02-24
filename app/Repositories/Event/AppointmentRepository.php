<?php

namespace App\Repositories\Event;

use App\Models\Event\Appointment;
use App\Repositories\Repository;

/**
 * Appointment Repository
 */
class AppointmentRepository extends Repository
{
    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return Appointment::class;
    }
}
