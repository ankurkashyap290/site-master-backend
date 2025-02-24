@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.frontend_url')])
            Bid not accepted
        @endcomponent
    @endslot
{{-- Body --}}
    <div>
        <p>
            Thank you for quoting the transport listed below. While your quote was not accepted,
            we do appreciate your time to submit a quote and we look forward to continuing working together.
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
    </div>
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}
        @endcomponent
    @endslot
@endcomponent