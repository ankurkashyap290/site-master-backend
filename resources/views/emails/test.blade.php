@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            Welcome to Journey!
        @endcomponent
    @endslot
{{-- Body --}}
    This is our main message
    @component('mail::button', ['url' => config('app.url')])
        Visit the Journey website!
    @endcomponent
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}
        @endcomponent
    @endslot
@endcomponent