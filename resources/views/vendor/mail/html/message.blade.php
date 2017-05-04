@component('mail::layout')

    @slot('title')
        {{ $title }}
    @endslot

    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            @slot('title')
                {{ $title }}
            @endslot
            @slot('subtitle')
                {{ $subtitle }}
            @endslot
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Help --}}
    @slot('help')
        @component('mail::help')

        @endcomponent
    @endslot

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{-- Subcopy --}}

            @slot('subcopy')
                {{ $subcopy or '' }}
                @component('mail::subcopy')
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                @endcomponent
            @endslot

        @endcomponent
    @endslot
@endcomponent
