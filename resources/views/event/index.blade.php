@extends('layouts.main')

@section('content')
    <div class="container">
        @component('components.breadcrumb')
        <li><a href="{{ route('events.index') }}">{{ trans('label.events') }}</a></li>
        @endcomponent
        <div class="card">

            <div class="card-content m-b-40">
                <section>
                    <div class="heading">
                        <h2 class="title">{{ trans('action.search_event') }}</h2>
                        <p class="subtitle">{{ trans('descriptions.event.search') }}</p>
                    </div>
                    <div class="content m-t-40">
                        <ajax-form action="{{ route('events.index') }}" method="GET" :alert="false" replace-response="#event-preview-list">
                            <div class="columns is-multiline">
                                <div class="column is-6">
                                    <div class="columns is-multiline">
                                        <div class="column is-12">
                                            <form-input icon-left="{{ config('icons.search') }}" name="search" value="{{ request('search') }}"></form-input>
                                        </div>
                                        <div class="column is-12">
                                            <form-select icon-left="{{ config('icons.sport_type') }}" name="sport_type" value="{{ request('sport_type') }}">
                                                @foreach(\App\Models\SportType::all() as $sportType)
                                                    <option value="{{ $sportType->getRouteKey() }}">{{ trans('sport_types.' . $sportType->label) }}</option>
                                                @endforeach
                                            </form-select>
                                        </div>
                                        <div class="column is-6">
                                            <form-date-input icon-left="{{ config('icons.calendar') }}" name="date_interval_start"
                                                             value="{{ request('date_interval_start') }}"></form-date-input>
                                        </div>
                                        <div class="column is-6">
                                            <form-date-input icon-left="{{ config('icons.calendar') }}" name="date_interval_end"
                                                             value="{{ request('date_interval_end') }}"></form-date-input>
                                        </div>

                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="columns is-multiline">
                                        <div class="column is-12">
                                            <form-select icon-left="{{ config('icons.country') }}" name="country" value="{{ request('country') }}">
                                                @foreach(Country::all() as $countryCode)
                                                    <option value="{{ $countryCode }}">{{ trans('countries.' . $countryCode) }}</option>
                                                @endforeach
                                            </form-select>
                                        </div>
                                        <div class="column is-12">
                                            <form-select icon-left="{{ config('icons.state') }}" name="state" v-model="selectedState">
                                                <option v-for="state in states"
                                                        :value="state.code">@{{ state.name }}</option>
                                            </form-select>
                                        </div>
                                        <div class="column is-6">
                                            <form-input icon-left="{{ config('icons.city') }}" name="city" value="{{ request('city') }}"></form-input>
                                        </div>
                                        <div class="column is-6">
                                            <form-input icon-left="{{ config('icons.postcode') }}" name="postcode" value="{{ request('postcode') }}"></form-input>
                                        </div>

                                    </div>
                                </div>
                                <div class="column is-12 button-group">
                                    <button type="reset" class="button">{{ trans('action.reset') }}</button>
                                    <button type="submit" class="button is-success">
                                        <span>
                                            <span class="icon is-small">
                                            <icon icon="{{ config('icons.search') }}"></icon>
                                        </span>
                                        <span>{{ trans('action.search') }}</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </ajax-form>
                    </div>
                </section>
                <hr>

                @include('event.preview_list')

            </div>
        </div>


    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app',
            data() {
                return {
                    stateCodes: <?php echo json_encode(State::all()); ?>,
                    countryCode: '<?php echo request('country'); ?>',
                    states: [],
                    selectedState: ''
                }
            },

            mounted: function () {
                this.$nextTick(function () {
                    window.eventHub.$on('input-value-changed', (name, value) => {
                        if (name === 'country') {
                            this.countryCode = value;
                            this.updateStates();
                        }

                    });

                    this.updateStates();
                    this.selectedState = '<?php echo request('state'); ?>';
                })
            },

            methods: {
                updateStates: function () {
                    this.states = [];
                    for (let index in this.stateCodes[this.countryCode]) {
                        this.states.push({
                            code: this.stateCodes[this.countryCode][index],
                            name: this.$t('states.' + this.countryCode + '.' + this.stateCodes[this.countryCode][index])
                        });
                    }
                },
            }
        });
    });
</script>@endpush
