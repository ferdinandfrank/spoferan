@extends('layouts.main')

@section('content')
    <div class="full-height">
        <div class="central-form card">
            <h1 class="center">@{{ actionText }}</h1>
            <ajax-form action="{{ route('users.store') }}" alert-key="registration" :alert-duration="6000" method="POST"
                       class="card-content"
                       redirect="{{ route('login') }}">
                <form-input v-if="userType == {{ config('starmee.user_type.athlete') }}" size="large"
                            name="first_name" :max-length="{{ config('validation.athlete.first_name.max') }}"
                            :required="true"></form-input>
                <form-input v-if="userType == {{ config('starmee.user_type.athlete') }}" size="large"
                            name="last_name" :max-length="{{ config('validation.athlete.last_name.max') }}"
                            :required="true"></form-input>
                <form-select v-if="userType == {{ config('starmee.user_type.athlete') }}" size="large" name="gender"
                             :required="true">
                    <option value="m">{{ trans('label.male') }}</option>
                    <option value="w">{{ trans('label.female') }}</option>
                </form-select>
                <form-input v-if="userType == {{ config('starmee.user_type.organizer') }}" size="large" name="name"
                            :max-length="{{ config('validation.organizer.name.max') }}"
                            :required="true"></form-input>
                <form-input size="large" type="email" name="email" :required="true"
                            :max-length="{{ config('validation.user.email.max') }}"></form-input>
                <form-input size="large" type="password" name="password" :required="true"
                            :max-length="{{ config('validation.user.password.max') }}"
                            :min-length="{{ config('validation.user.password.min') }}"></form-input>
                <form-input size="large" type="password" name="password_confirmation" :confirmed="true"
                            :required="true"></form-input>

                <form-switch class="center" name="user_type" :value="false"></form-switch>

                <div class="center">
                    <button type="submit" class="button is-success">{{ trans('action.register') }}</button>
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
            el: '#app',
            data: {
                userType: 0,
            },
            computed: {
                actionText: function () {
                    return this.userType == '{{ config('starmee.user_type.organizer') }}' ? '{{ trans('action.register_as_organizer') }}' : '{{ trans('action.register_as_athlete') }}';
                }
            },
            created: function () {
                window.eventHub.$on('user_type-input-changed', function (userType) {
                    this.userType = userType;
                }.bind(this));
            }
        });
    });
</script>
@endpush
