<?php

namespace App\Repositories\Event;

use App\Models\Event\Passenger;
use App\Models\Event\Appointment;
use App\Repositories\Repository;

/**
 * Passenger Repository
 */
class PassengerRepository extends Repository
{
    public function store(array $data)
    {
        $passenger = parent::store($data);
        $this->saveAppointments($passenger, $data);
        return $passenger;
    }

    public function update(array $data, $id)
    {
        $passenger = parent::update($data, $id);
        $this->saveAppointments($passenger, $data);
        return $passenger;
    }

    public function saveAppointments($passenger, $data)
    {
        $deletableIds = $passenger->appointments()->pluck('id')->all();
        foreach ($data['data']['attributes']['appointments'] as $appointment) {
            $id = $appointment['id'];
            unset($appointment['id']);
            if (($key = array_search($id, $deletableIds)) !== false) {
                unset($deletableIds[$key]);
            }
            $appointment['passenger_id'] = $passenger->id;
            if ($id) {
                (new AppointmentRepository)->update(['data' => ['attributes' => $appointment]], $id);
                continue;
            }
            (new AppointmentRepository)->store(['data' => ['attributes' => $appointment]]);
        }
        if (count($deletableIds)) {
            Appointment::destroy($deletableIds);
        }
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return Passenger::class;
    }
}
