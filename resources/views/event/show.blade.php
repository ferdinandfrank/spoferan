@extends('layouts.main')

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <icon icon="{{ config('icons.dashboard') }}"></icon>
            </li>
            <li>Events</li>
        </ul>
        <div class="card">
            <div class="card-header">
                <div class="card-image" style="background-image: url({{ $event->cover }})"></div>
                <div class="card-header-info">
                    <icon icon="{{ config('icons.event') }}"></icon>
                    <h1 class="title">{{ $event->title }}</h1>
                </div>
            </div>

            <div class="card-content">
                <nav class="level">
                    {{--<div class="level-item has-text-centered">--}}
                        {{--<div>--}}
                            {{--<p class="heading">{{ trans('label.participants') }}</p>--}}
                            {{--<p class="title">{{ $event->getTotalNumOfParticipants() }}</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="level-item has-text-centered">--}}
                        {{--<div>--}}
                            {{--<p class="heading">{{ trans('label.visitors') }}</p>--}}
                            {{--<p class="title">{{ $event->getTotalNumOfVisitors() }}</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">{{ trans('label.user_type.organizer') }}</p>
                            <div class="tooltip tooltip-left">
                                <img class="avatar auto" src="{{ $event->organizer->user->avatar }}" alt="{{ $event->organizer->getDisplayName() }}" >
                                <span class="tooltip-text">{{ $event->organizer->getDisplayName() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">{{ trans('label.sport_type') }}</p>
                            <div class="tooltip tooltip-left">
                                <img src="{{ $event->sportType->icon }}" alt="{{ trans('sport_types.' . $event->sportType->label) }}" >
                                <span class="tooltip-text">{{ trans('sport_types.' . $event->sportType->label) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">{{ trans('label.event_start_date') }}</p>
                            <div class="tooltip tooltip-left">
                                <time datetime="{{ $event->start_date->toDateTimeString() }}" class="calendar margin-auto">
                                    <span class="year">{{ $event->start_date->year }}</span>
                                    <span class="day">{{ $event->start_date->day }}</span>
                                    <span class="month">{{ $event->start_date->formatLocalized('%b') }}</span>
                                </time>
                                <span class="tooltip-text">{{ dateDiffForHumans($event->start_date) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">{{ trans('label.event_location') }}</p>
                            <div class="tooltip tooltip-left">
                                <img src="{{ getCountryFlag($event->country) }}" alt="{{ trans('countries.' . $event->country) }}" >
                                <span class="tooltip-text">{{ trans('countries.' . $event->country) }}</span>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="columns">
                    <div class="column is-9">
                        <p>{{ $event->description }}</p>
                    </div>
                    <div class="column">
                        <div class="columns is-multiline">
                            <div class="column is-12">
                                <a class="button is-large is-primary responsive">
                                <span class="icon is-small">
                                  <icon icon="{{ config('icons.participants') }}"></icon>
                                </span>
                                    <span>{{ trans('action.participate') }}</span>
                                </a>
                            </div>
                            <div class="column is-half">
                                <a class="button responsive">
                                <span class="icon is-small">
                                  <icon icon="{{ config('icons.share') }}"></icon>
                                </span>
                                    <span>{{ trans('action.share') }}</span>
                                </a>
                            </div>
                            <div class="column is-half">
                                <a class="button responsive">
                                <span class="icon is-small">
                                  <icon icon="{{ config('icons.watchlist') }}"></icon>
                                </span>
                                    <span>{{ trans('action.add_to_watchlist') }}</span>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <aside class="menu">
                            <p class="menu-label">
                                Übersicht </p>
                            <ul class="menu-list">
                                <li><a>Dashboard</a></li>
                                <li><a>Customers</a></li>
                            </ul>
                            <p class="menu-label">
                                Administration </p>
                            <ul class="menu-list">
                                <li><a>Team Settings</a></li>
                                <li>
                                    <a class="is-active">Manage Your Team</a>
                                    <ul>
                                        <li><a>Members</a></li>
                                        <li><a>Plugins</a></li>
                                        <li><a>Add a member</a></li>
                                    </ul>
                                </li>
                                <li><a>Invitations</a></li>
                                <li><a>Cloud Storage Environment Settings</a></li>
                                <li><a>Authentication</a></li>
                            </ul>
                            <p class="menu-label">
                                Transactions </p>
                            <ul class="menu-list">
                                <li><a>Payments</a></li>
                                <li><a>Transfers</a></li>
                                <li><a>Balance</a></li>
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
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