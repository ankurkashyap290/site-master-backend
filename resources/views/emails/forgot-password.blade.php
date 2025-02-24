@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.frontend_url')])
            Forgot your password?
        @endcomponent
    @endslot
{{-- Body --}}
    <div>
        <p>
            Hello {{$user->first_name}},
        </p>
        <p>
            You've recently asked to reset the password for this Journey account: {{$user->email}}
        </p>
            To update your password, click the button below:
        </p>
        @component(
            'mail::button',
            [
                'url' => config('app.frontend_url') . "/reset-password/{$token}"
            ]
        )
            Reset my password
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