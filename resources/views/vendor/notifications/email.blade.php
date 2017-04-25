@component('mail::message')

@slot('title')
    {{ $subject }}
@endslot

@slot('subtitle')
    {{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}
@endslot

{{-- Greeting --}}
@if (!empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# {{ trans('email.greeting_plain') }}!
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@if (isset($actionText))
    <?php
        switch ($level) {
            case 'success':
                $color = 'success';
                break;
            case 'error':
                $color = 'danger';
                break;
            default:
                $color = 'primary';
        }
    ?>

@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endif

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

<!-- Salutation -->
@if (!empty($salutation))
    {{ $salutation }}
@else
    {{ trans('email.salutation') }},<br>{{ config('app.name') }}
@endif

<!-- Subcopy -->
@if (isset($actionText))
    @slot('subcopy')
        @component('mail::subcopy')
            {{ trans('email.button_help', ['button' => $actionText]) }}: [{{ $actionUrl }}]({{ $actionUrl }})
        @endcomponent
    @endslot
@endif

@endcomponent
