@extends('emails.layout')

@section('content')
    <h3>{{ trans('email.greeting', ['name' => $user->getDisplayName()]) }},</h3>

    <p>{{ trans('email.registration.content', ['title' => Settings::title(), 'user_type' => $user->getTypeAsString()]) }}</p>

    <div class="btn-group">
        <a href="{{ $link }}" class="btn" target="_blank">{{ trans('action.confirm_account') }}</a>
    </div>
@stop