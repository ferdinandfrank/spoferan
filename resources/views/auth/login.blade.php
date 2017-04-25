{{-------------------------------------------------------
    LOGIN PAGE
    _______________
    Shows the main login form of the application.
---------------------------------------------------------}}

@extends('layouts.welcome')

@section('title', trans('action.login'))

@section('content')
    <div class="login-form card transparent">
        <h1 class="center">{{ trans('action.login') }}</h1>
        <hr class="light">
        <ajax-form :stop-loading="false" action="{{ route('login.post') }}" method="POST" :alert="false"
                   error-wrapper="#login-form-error" class="card-content" redirect="{{ route('index') }}">
            <div class="columns is-multiline">
                <div class="column is-12">
                    <form-input icon-left="{{ config('icons.email') }}" type="email"
                                name="email" :required="true"></form-input>
                </div>
                <div class="column is-12">
                    <form-input icon-left="{{ config('icons.password') }}" type="password"
                                name="password" :required="true"></form-input>
                </div>
                <div class="column is-12 p-t-none p-b-none">
                    <p id="login-form-error" class="error"></p>
                </div>
            </div>

            <form-checkbox name="remember" :value="true"></form-checkbox>

            <div class="center">
                <button type="submit" class="button is-success">{{ trans('action.login') }}</button>
            </div>
            {{--<p class="is-warning m-t-20">Info: Dieser Prototyp dient lediglich zur Darstellung einiger Kernfunktionen
                von
                Spoferan und ist nicht für die Öffentlichkeit bestimmt.
                Alle Daten der Veranstaltungen, Veranstaltern und Athleten sind frei erfunden bzw. teilweise automatisch
                generiert.</p>--}}
            <hr class="light">

            <div class="center flex-column">
                <a href="{{ route('register') }}" class="link">{{ trans('label.not_registered') }}</a>
                <a href="{{ route('password.request') }}" class="link">{{ trans('label.forgot_my_password') }}</a>
            </div>
        </ajax-form>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app'
        });
    });
</script>
@endpush
