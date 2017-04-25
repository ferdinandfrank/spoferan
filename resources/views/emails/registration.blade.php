@component('mail::message')

@slot('title')
    {{ trans('email.registration.title') }}
@endslot

@slot('subtitle')
    {{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}
@endslot

{{-- Greeting --}}
# {{ trans('email.greeting', ['name' => $user->getDisplayName()]) }},

{{-- Content --}}
{{ trans('email.registration.content', ['title' => Settings::title(), 'user_type' => $user->getTypeAsString()]) }}

{{-- Action Button --}}
@component('mail::button', ['url' => $link, 'color' => 'success'])
{{ trans('action.confirm_account') }}
@endcomponent

<!-- Salutation -->
{{ trans('email.registration.salutation') }},<br>{{ config('app.name') }}

<!-- Subcopy -->
@slot('subcopy')
    @component('mail::subcopy')
        {{ trans('email.registration.receiving_info', ['title' => Settings::title()]) }}
    @endcomponent
    @component('mail::subcopy')
        {{ trans('email.button_help', ['button' => trans('action.confirm_account')]) }}: [{{ $link }}]({{ $link }})
    @endcomponent
@endslot

@endcomponent
