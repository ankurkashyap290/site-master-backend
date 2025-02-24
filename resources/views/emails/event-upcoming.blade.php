@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.frontend_url')])
            Upcoming event
        @endcomponent
    @endslot
{{-- Body --}}
    <div>
        <p>
            As the responsible party for a resident at {{ $passenger->event->facility->name }},
            we strive to keep you informed of any appointments scheduled to provide the highest
            quality of care possible. Below are details for an upcoming appointment that has been
            scheduled.
        </p>
        <p>
            Event Date &amp; Time:
            <strong>
                {{ date('m/d/Y', strtotime($nextDate ?: $passenger->event->date)) }}
                {{ date('h:i A', strtotime($passenger->event->start_time)) }} -
                {{ date('h:i A', strtotime($passenger->event->end_time)) }}
            </strong>
        </p>
        <p>
            Transport Type:
            <strong>{{ $passenger->event->transport_type }}</strong>
        </p>
        <p>
            From Location:
            <strong>{{ $passenger->event->location->name }}</strong>
            <br>
            <small>
                {{ $passenger->event->location->address }}
                <br>
                {{ $passenger->event->location->city }}, {{ $passenger->event->location->state }}
                {{ $passenger->event->location->postcode }}
                <br>
                {{ $passenger->event->location->phone }}
            </small>
        </p>
        <p>
            Appointments
        </p>
        <blockquote>
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
        </blockquote>
    </div>
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}
        @endcomponent
    @endslot
@endcomponent