@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.frontend_url')])
            Journey is requesting your services!
        @endcomponent
    @endslot
{{-- Body --}}
    <div>
        <p>
            Please let us know your availability for the following transport:
        </p>
        <p>
            Facility:
            <strong>{{ $event->facility->name }}</strong>
        </p>
        <p>
            Event Date &amp; Time:
            <strong>
                {{ date('m/d/Y', strtotime($event->date)) }}
                {{ date('h:i A', strtotime($event->start_time)) }} -
                {{ date('h:i A', strtotime($event->end_time)) }}
            </strong>
        </p>
        <p>
            Transport Type:
            <strong>{{ $event->transport_type }}</strong>
        </p>
        <p>
            From Location:
            <strong>{{ $event->location->name }}</strong>
            <br>
            <small>
                {{ $event->location->address }}
                <br>
                {{ $event->location->city }}, {{ $event->location->state }}
                {{ $event->location->postcode }}
                <br>
                {{ $event->location->phone }}
            </small>
        </p>
        <p>
            Appointments
        </p>
        @foreach ($event->passengers as $passenger)
        <p>
            Passenger name:
            <strong>
                {{ $passenger->client_id ?
                    preg_replace('/[a-z]+\s/', '. ', $passenger->client->getFullName()) :
                    preg_replace('/[a-z]+\s/', '. ', $passenger->name)
                }}
            </strong>
            @foreach ($passenger->appointments as $appointment)
            <p>
                <strong>{{ date('h:i A', strtotime($appointment->time)) }}</strong>
                <br>
                <strong>{{ $appointment->location->name }}</strong>
                <br>
                <small>
                    {{ $appointment->location->address }}
                    <br>
                    {{ $appointment->location->city }}, {{ $appointment->location->state }}
                    {{ $appointment->location->postcode }}
                    <br>
                    {{ $appointment->location->phone }}
                </small>
            </p>
            @endforeach
        </p>
        @endforeach
        <p>
            Are you available?
        </p>
        <table width="100%">
            <tr>
                <td align="center">
                    @component(
                        'mail::button',
                        [
                            'url' => config('app.frontend_url') . "/etc-bid/{$driver->hash}/submitted"
                        ]
                    )
                        Yes
                    @endcomponent
                </td>
                <td align="center">
                    @component(
                        'mail::button',
                        [
                            'url' => config('app.frontend_url') . "/etc-bid/{$driver->hash}/declined"
                        ]
                    )
                        No
                    @endcomponent
                </td>
            </tr>
        </table>
        <p>
            Thank you for your service to our organization and for being an active Journey participant.
        </p>
    </div>
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}
        @endcomponent
    @endslot
@endcomponent