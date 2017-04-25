{{-------------------------------------------------------
    RESET PASSWORD PAGE
    _______________
    Shows the form to reset a password. Users will be redirected to this page after they requested a
    "forgot password" mail and clicked on the reset link in the email.
---------------------------------------------------------}}

@extends('layouts.welcome')

@section('title', trans('action.reset_password'))

@section('content')
    <div class="login-form card transparent">
        <h1 class="center">{{ trans('action.reset_password') }}</h1>
        <hr class="light">
        <ajax-form action="{{ route('password.reset.post') }}" method="POST" alert-key="password_reset" class="card-content"
                   redirect="{{ route('login') }}">

            <hidden-input name="token" value="{{ $token }}"></hidden-input>

            <div class="columns is-multiline">
                <div class="column is-12">
                    <form-input icon-left="{{ config('icons.email') }}" type="email" name="email" :required="true"
                                :max-length="{{ config('validation.email.max') }}"></form-input>
                </div>
                <div class="column is-6">
                    <form-input icon-left="{{ config('icons.password') }}" type="password" name="password"
                                :required="true" :max-length="{{ config('validation.password.max') }}"
                                :min-length="{{ config('validation.password.min') }}"></form-input>
                </div>
                <div class="column is-6">
                    <form-input icon-left="{{ config('icons.password') }}" type="password" name="password_confirmation"
                                :confirmed="true" :required="true"></form-input>
                </div>
            </div>

            <div class="center">
                <button type="submit" class="button is-success">
                    <span>
                        <span class="icon is-small">
                            <icon icon="{{ config('icons.check') }}"></icon>
                        </span>
                        <span>{{ trans('action.reset_password') }}</span>
                    </span>
                </button>
            </div>
            <hr class="light">

            <div class="center flex-column">
                <a href="{{ route('login') }}" class="link">{{ trans('label.know_my_password') }}</a>
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
