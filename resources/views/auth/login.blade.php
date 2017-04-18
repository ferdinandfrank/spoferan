@extends('layouts.main')

@section('content')
    <div class="full-height">
        <div class="central-form card">
            <h1 class="center">{{ trans('action.login') }}</h1>
            <hr class="light">
            <ajax-form :stop-loading="false" action="{{ route('login.post') }}" method="POST" :alert="false"
                       error-wrapper="#login-form-error"
                       class="card-content" redirect="{{ route('index') }}">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <form-input icon-left="{{ config('icons.email') }}" value="gast@example.de" type="email" name="email"
                                    :required="true"></form-input>
                    </div>
                    <div class="column is-12">
                        <form-input icon-left="{{ config('icons.password') }}" value="password" type="password"
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
                <p class="is-warning m-t-20">Info: Dieser Prototyp dient lediglich zur Darstellung einiger Kernfunktionen von
                    Spoferan und ist nicht für die Öffentlichkeit bestimmt.
                    Alle Daten der Veranstaltungen, Veranstaltern und Athleten sind frei erfunden bzw. teilweise automatisch generiert.</p>
                <hr class="light">

                <div class="center flex-column">
                    <a href="{{ route('register') }}" class="link">{{ trans('label.not_registered') }}</a>
                    <a href="#" class="link">{{ trans('label.forgot_my_password') }}</a>
                </div>
            </ajax-form>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app'
        });
    });
</script>@endpush
