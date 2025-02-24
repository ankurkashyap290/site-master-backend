@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.frontend_url')])
            Welcome to Journey, {{$user->first_name}}!
        @endcomponent
    @endslot
{{-- Body --}}
    <div>
        <p>
            Congratulations! We hope your experience with the software application and mobile app makes your
            work easier and exceeds your expectations when it comes to arranging transportation for your patients.
            You will be able to access this application on your own mobile device or desktop whichever you prefer.
            We don’t want you to just like Journey, we want you to love it! If you don't, just let us know how we can
            make it even better!
        </p>
        <p>
            If you have any concerns or questions, please email us at info@journeytransportation.com.
        </p>
        <p>
            <a href="https://itunes.apple.com/us/app/journey-transportation/id1403455715?ls=1&mt=8">
                <img alt='Download on the App Store' src='https://devimages-cdn.apple.com/app-store/marketing/guidelines/images/badge-example-preferred.png' style="height: 40px"/>
            </a>
            <a href="https://play.google.com/store/apps/details?id=com.journeytransportation">
                <img alt='Get it on Google Play' src='https://play.google.com/intl/en_gb/badges/images/badge_new.png' style="height: 41px;" />
            </a>
        </p>
    </div>
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}
        @endcomponent
    @endslot
@endcomponent