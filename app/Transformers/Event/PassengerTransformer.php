<?php

namespace App\Transformers\Event;

use League\Fractal\TransformerAbstract;
use App\Models\Event\Passenger;
use App\Transformers\TransformerInterface;

class PassengerTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\Event\Passenger $passenger
     * @return array
     */
    public function transform($passenger): array
    {
        return [
            'id' => (int)$passenger->id,
            'client_id' => $passenger->client_id ? (int)$passenger->client_id : null,
            'name' => $passenger->client_id ? $passenger->client->getFullName() : $passenger->name,
            'room_number' => $passenger->client_id ? $passenger->client->room_number : $passenger->room_number,
            'appointments' => $this->appointments($passenger),
        ];
    }

    /**
     * Transform Appointments
     *
     * @param \App\Models\Event\Passenger $passenger
     * @return array
     */
    public function appointments(Passenger $passenger)
    {
        $appointmentsData = [];
        $appointments = $passenger->appointments;
        foreach ($appointments as $appointment) {
            $appointmentsData[] = (new AppointmentTransformer)->transform($appointment);
        }
        return $appointmentsData;
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'passengers';
    }
}
