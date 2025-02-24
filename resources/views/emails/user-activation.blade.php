@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.frontend_url')])
            You have been invited to Journey!
        @endcomponent
    @endslot
{{-- Body --}}
    <div>
        <p>
            Hello {{$invitee->first_name}},
        </p>
        <p>
            you have been invited to Journey by {{$invitor->getFullName()}}.
        </p>
        @component(
            'mail::button',
            [
                'url' => config('app.frontend_url') . "/activation/{$invitee->id}/{$token}"
            ]
        )
            Please click here to activate your account!
        @endcomponent
        <p>
            If you have any concerns or questions, please email us at info@journeytransportation.com.
        </p>
    </div>
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}
        @endcomponent
    @endslot
@endcomponent