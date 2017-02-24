@extends('layouts.main')

@section('content')
    <div class="full-height">
        <div class="central-form card">
            <h1 class="center">{{ trans('action.login') }}</h1>
            <ajax-form stop-loading="false" action="{{ route('login.post') }}" method="POST" :alert="false" class="card-content" redirect="{{ route('index') }}">
                <form-input size="large" type="email" name="email" :required="true"></form-input>
                <form-input size="large" type="password" name="password" :required="true"></form-input>

                <form-checkbox name="remember" :value="true"></form-checkbox>

                <div class="center">
                    <button type="submit" class="button is-success">{{ trans('action.login') }}</button>
                </div>

                <hr class="light">

                <div class="center flex-column">
                    <a href="{{ route('register') }}" class="link">{{ trans('label.not_registered') }}</a>
                    <a href="{{ route('password.request') }}" class="link">{{ trans('label.forgot_my_password') }}</a>
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
</script>
@endpush
