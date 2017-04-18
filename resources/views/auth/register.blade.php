@extends('layouts.main')

@section('content')
    <div class="full-height">
        <div class="central-form card">
            <h1 class="center">@{{ actionText }}</h1>
            <hr class="light">
            <ajax-form action="{{ route('users.store') }}" alert-key="registration" :alert-duration="6000" method="POST"
                       class="card-content"
                       redirect="{{ route('login') }}">
                <div class="columns is-multiline">
                    <div v-if="registerAsAthlete" class="column is-6">
                        <form-input icon-left="{{ config('icons.user') }}"
                                    name="first_name" :max-length="{{ config('validation.athlete.first_name.max') }}"
                                    :required="true"></form-input>
                    </div>
                    <div v-if="registerAsAthlete" class="column is-6">
                        <form-input icon-left="{{ config('icons.user') }}"
                                    name="last_name" :max-length="{{ config('validation.athlete.last_name.max') }}"
                                    :required="true"></form-input>
                    </div>
                    <div v-if="registerAsAthlete" class="column is-12">
                        <form-select icon-left="{{ config('icons.gender') }}" name="gender" :required="true">
                            <option value="m">{{ trans('label.male') }}</option>
                            <option value="w">{{ trans('label.female') }}</option>
                        </form-select>
                    </div>
                    <div v-if="registerAsAthlete" class="column is-12">
                        <form-date-input icon-left="{{ config('icons.birthday') }}" name="birth_date" :required="true"></form-date-input>
                    </div>
                    <div v-if="!registerAsAthlete" class="column is-12">
                        <form-input icon-left="{{ config('icons.organization') }}" name="name"
                                    :max-length="{{ config('validation.organizer.name.max') }}"
                                    :required="true"></form-input>
                    </div>
                    <div class="column is-12">
                        <form-input icon-left="{{ config('icons.email') }}" type="email" name="email" :required="true"
                                    :max-length="{{ config('validation.email.max') }}"></form-input>
                    </div>
                    <div class="column is-6">
                        <form-input icon-left="{{ config('icons.password') }}" type="password" name="password" :required="true"
                                    :max-length="{{ config('validation.password.max') }}"
                                    :min-length="{{ config('validation.password.min') }}"></form-input>
                    </div>
                    <div class="column is-6">
                        <form-input icon-left="{{ config('icons.password') }}" type="password" name="password_confirmation" :confirmed="true"
                                    :required="true"></form-input>
                    </div>
                    <div class="column is-12 center">
                        <form-switch class="center" lang-key="registration" name="user_type" :value="false"></form-switch>
                        <input type="hidden" name="current_user_type" v-model="userType" />
                    </div>

                </div>

                <div class="center">
                    <p class="is-warning">Die Registrierung ist zur Darstellung des Prototypen deaktiviert.
                        Um den Prototypen zu testen, navigiere bitte zum <a href="{{ route('login') }}" class="link">Login</a> und melde dich
                    mit dem verfügbaren Gast-Account durch das bereits ausgefüllte Formular ein.</p>
                    {{--<button type="submit" class="button is-success">Submit</button>--}}
                </div>

                <hr class="light">

                <div class="center flex-column">
                    <a href="{{ route('login') }}" class="link">{{ trans('label.already_registered') }}</a>
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
            el: '#app',
            data: {
                userType: '{{ config('spoferan.user_type.athlete') }}',
            },
            computed: {
                actionText: function () {
                    return this.registerAsAthlete ? '{{ trans('action.register_as_athlete') }}' : '{{ trans('action.register_as_organizer') }}';
                },
                registerAsAthlete: function () {
                    return this.userType === '{{ config('spoferan.user_type.athlete') }}';
                }
            },
            created: function () {
                window.eventHub.$on('user_type-input-changed', function (userType) {
                    if (userType) {
                        this.userType = '{{ config('spoferan.user_type.organizer') }}'
                    } else {
                        this.userType = '{{ config('spoferan.user_type.athlete') }}'
                    }
                }.bind(this));
            }
        });
    });
</script>
@endpush
