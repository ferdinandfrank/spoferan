{{-------------------------------------------------------
    SEND RESET PASSWORD EMAIL PAGE
    _______________
    Shows the form to enter an users email address to receive a "forgot password" mail.
---------------------------------------------------------}}

@extends('layouts.welcome')

@section('title', trans('label.forgot_my_password'))

@section('content')
    <div class="login-form card transparent">
        <h1 class="center">{{ trans('label.forgot_my_password') }}</h1>
        <hr class="light">
        <ajax-form action="{{ route('password.email') }}" method="POST" alert-key="password_forgot" class="card-content"
                   redirect="{{ route('login') }}">

            <div class="columns is-multiline">
                <div class="column is-12">
                    <p>{{ trans('descriptions.forgot_password') }}</p>
                </div>
                <div class="column is-12">
                    <form-input icon-left="{{ config('icons.email') }}" type="email" name="email"
                                :required="true"></form-input>
                </div>
            </div>

            <div class="center">
                <button type="submit" class="button is-success">
                    <span>
                        <span class="icon is-small">
                            <icon icon="{{ config('icons.send') }}"></icon>
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
</script>@endpush