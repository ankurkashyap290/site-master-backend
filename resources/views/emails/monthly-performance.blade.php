@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.frontend_url')])
            Journey Monthly Results
        @endcomponent
    @endslot
{{-- Body --}}
    <div>
        <p>
            You won {{ $data['num_of_accepted_bids'] }} out of {{ $data['num_of_received_bids'] }} using Journey!
        </p>
        <p>
            Total Earned Last Month: ${{ $data['total_earned_last_month'] }}
        </p>
        <p>
            Total Earned Year-to-Date ${{ $data['total_earned_ytd'] }}
        </p>
    </div>
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}
        @endcomponent
    @endslot
@endcomponent