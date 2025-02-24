<?php

namespace App\Transformers\Client;

use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;
use App\Transformers\Event\EventTransformer;
use App\Models\Client\Client;

class ClientTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \Illuminate\Database\Eloquent\Model $client
     * @return array
     */
    public function transform($client): array
    {
        $ongoingEvent = $client->getOngoingEvent();
        return [
            'id' => (int)$client->id,
            'first_name' => $client->first_name,
            'middle_name' => (string)$client->middle_name,
            'last_name' => $client->last_name,
            'room_number' => $client->room_number,
            'responsible_party_email' => $client->responsible_party_email,
            'facility_id' => (int)$client->facility_id,
            'transport_status' => $ongoingEvent ? 'on' : 'off',
            'ongoing_event' => $ongoingEvent ? (new EventTransformer)->transform($ongoingEvent) : null,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'clients';
    }
}
