@extends('layouts.main')

@section('content')
    <div class="full-height flex-center" @if(Settings::background())style="background-image: url({{ Settings::background() }})"@endif>
        <div class="central-form">
            <h1 class="center m-b-50">{{ trans('action.login') }}</h1>
            <ajax-form stop-loading="false" action="{{ route('login.post') }}" method="POST" :alert="false" redirect="{{ route('index') }}">
                <form-input class="large" type="email" name="email" :required="true"></form-input>
                <form-input class="large" type="password" name="password" :required="true"></form-input>

                <form-checkbox name="remember" :value="true"></form-checkbox>

                <div class="btn-group center">
                    <button type="submit" class="btn btn-large btn-primary">{{ trans('action.login') }}</button>
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
