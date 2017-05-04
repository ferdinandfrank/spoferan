@component('mail::message')

@slot('title')
    {{ trans('email.test.title') }}
@endslot

@slot('subtitle')
    {{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}
@endslot

{{-- Greeting --}}
# {{ trans('email.greeting_plain') }},

{{-- Content --}}
{{ trans('email.test.content', ['title' => Settings::title()]) }}

{{-- Action Button --}}
@component('mail::button', ['url' => $link, 'color' => 'success'])
{{ trans('param_action.navigate_to_title', ['title' => Settings::title()]) }}
@endcomponent

<!-- Salutation -->
{{ trans('email.salutation') }}<br>{{ Settings::title() }}

<!-- Subcopy -->
@slot('subcopy')
    @component('mail::subcopy')
        {{ trans('email.test.receiving_info', ['title' => Settings::title()]) }}
    @endcomponent
    @component('mail::subcopy')
        {{ trans('email.button_help', ['button' => trans('param_action.navigate_to_title', ['title' => Settings::title()])]) }}: [{{ $link }}]({{ $link }})
    @endcomponent
@endslot

@endcomponent
