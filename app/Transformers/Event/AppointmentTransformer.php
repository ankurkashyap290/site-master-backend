<?php

namespace App\Transformers\Event;

use App\Transformers\Location\LocationTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;
use App\Models\Event\Appointment;

class AppointmentTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\Event\Appointment $appointment
     * @return array
     */
    public function transform($appointment): array
    {
        return [
            'id' => (int)$appointment->id,
            'time' => $appointment->time,
            'location' => $this->location($appointment),
        ];
    }

    /**
     * Transform Location
     *
     * @param \App\Models\Event\Appointment $appointment
     * @return array
     */
    public function location(Appointment $appointment)
    {
        return $appointment->location ? (new LocationTransformer)->transform($appointment->location) : null;
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'appointments';
    }
}
