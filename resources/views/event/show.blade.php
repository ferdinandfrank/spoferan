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
            <div id="overview" class="card-header">
                <div class="card-image" style="background-image: url({{ $event->cover }})"></div>
                <div class="card-header-info">
                    <icon icon="{{ config('icons.event') }}"></icon>
                    <h1 class="title">{{ $event->title }}</h1>
                    @if($event->isChild())
                        <a class="subtitle link" href="{{ $event->parentEvent->getPath() }}">{{ trans('param_label.child_event_of_event', ['event' => $event->parentEvent->title]) }}</a>
                    @endif
                </div>
            </div>

            <div class="card-content">
                <nav class="level">
                    <div class="level-item has-text-centered">
                        <div>
                            <img class="avatar auto" src="{{ $event->organizer->user->avatar }}" alt="{{ $event->organizer->getDisplayName() }}" >
                            <p class="heading">{{ trans('label.user_type.organizer') }}</p>
                            <p class="title">{{ $event->organizer->getDisplayName() }}</p>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <img src="{{ $event->sportType->icon }}" alt="{{ trans('sport_types.' . $event->sportType->label) }}" >
                            <p class="heading">{{ trans('label.sport_type') }}</p>
                            <p class="title">{{ trans('sport_types.' . $event->sportType->label) }}</p>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <time datetime="{{ $event->start_date->toDateTimeString() }}" class="calendar margin-auto">
                                <span class="year">{{ $event->start_date->year }}</span>
                                <span class="day">{{ $event->start_date->day }}</span>
                                <span class="month">{{ $event->start_date->formatLocalized('%b') }}</span>
                            </time>
                            <p class="heading">{{ trans('label.event_start_date') }}</p>
                            <p class="title">{{ dateDiffForHumans($event->start_date) }}</p>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <img src="{{ getCountryFlag($event->country) }}" alt="{{ trans('countries.' . $event->country) }}" >
                            <p class="heading">{{ trans('label.event_location') }}</p>
                            <p class="title">{{ $event->getFullAddress() }}</p>
                        </div>
                    </div>
                </nav>
                <div class="columns">
                    <div class="column is-9">
                        <section id="description" class="section">
                            <div class="heading">
                                <h2 class="title">{{ trans('label.description') }}</h2>
                            </div>
                            <div class="content">
                                <div class="columns">
                                    <div class="column">
                                        <p>{{ $event->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section id="time_and_location" class="section">
                            <div class="heading">
                                <h2 class="title">{{ trans('label.time_and_location') }}</h2>
                            </div>
                            <div class="content">
                                <div id="map" style="height: 500px"></div>
                            </div>
                        </section>

                        @if(count($event->childEvents))
                        <section id="child_events" class="section">
                            <div class="heading">
                                <h2 class="title">{{ trans('label.child_events') }}</h2>
                                <p class="subtitle">Dieses Event besteht aus mehreren Teilevents. Klicke auf eine der folgenden Karten, um mehr über dieses Teilevent zu erfahren.</p>
                            </div>
                            <div class="content">
                                <div class="columns is-multiline">
                                    @foreach($event->childEvents as $childEvent)
                                        <div class="column">
                                            @include('event.preview', ['event' => $childEvent])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        @endif

                        @if(count($event->participationClasses))
                            <section id="participation_classes" class="section">
                                <div class="heading">
                                    <h2 class="title">{{ trans('label.participation_classes') }}</h2>
                                    <p class="subtitle">Dieses Event besteht aus mehreren Teilnahmeklassen. Klicke auf eine der folgenden Karten, um mehr über diese Teilnahmeklasse zu erfahren.</p>
                                </div>
                                <div class="content">
                                    <div class="columns is-multiline">
                                        @foreach($event->participationClasses as $participationClass)
                                            <div class="column is-12">
                                                @include('participation_class.preview')
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </section>
                        @endif

                        <section class="section">
                            <div class="heading">
                                <h2 class="title">{{ trans('label.participants') }}</h2>
                                @if(count($event->childEvents))
                                <p class="subtitle">Dieses Event besteht aus mehreren Teilevents. Die Teilnehmer sind demnach nach den Teilevents aufgeteilt, für die sie sich registriert haben.</p>
                                @endif
                            </div>
                            <div class="content">
                                @if(count($event->participations))
                                    @include('participation.table', ['participations' => $event->participations])
                                @endif

                                @foreach($event->childEvents as $childEvent)
                                    <h4>{{ trans('label.child_event') }}: {{ $childEvent->title }}</h4>
                                    <div class="m-b-40">
                                        @include('participation.table', ['participations' => $childEvent->participations])
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="section">
                            <div class="heading">
                                <h2 class="title">{{ trans('label.about_the_organizer') }}</h2>
                            </div>
                            <div class="content">
                                <div class="columns">
                                    <div class="column is-2">
                                        <img src="{{ $event->organizer->user->avatar }}" class="avatar" >
                                    </div>
                                    <div class="column">
                                        <h4>{{ $event->organizer->getDisplayName() }}</h4>
                                        <p>{{ $event->organizer->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                    <div class="column">
                        <div id="sidebar">
                        <div class="columns is-multiline">
                            <div class="column is-12">
                                <a class="button is-large is-success responsive">
                                <span class="icon is-small">
                                  <icon icon="{{ config('icons.participate') }}"></icon>
                                </span>
                                    <span>{{ trans('action.participate') }}</span>
                                </a>
                            </div>
                            <div class="column is-6">
                                <a class="button responsive">
                                <span class="icon is-small">
                                  <icon icon="{{ config('icons.watchlist') }}"></icon>
                                </span>
                                    <span>{{ trans('action.add_to_watchlist') }}</span>
                                </a>
                            </div>
                            <div class="column is-6 share-buttons">
                                <a class="button responsive facebook">
                                    <span class="icon is-small">
                                      <icon icon="{{ config('icons.facebook') }}"></icon>
                                    </span>
                                    <span>{{ trans('action.share') }}</span>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <scrollspy-list class="menu">
                            <li class="menu-label"><a href="#overview">{{ trans('label.overview') }}</a></li>
                            <li class="menu-label"><a href="#description">{{ trans('label.description') }}</a></li>
                            <li class="menu-label"><a href="#time_and_location">{{ trans('label.time_and_location') }}</a></li>
                            @if(count($event->childEvents))
                            <li class="menu-label"><a href="#child_events">{{ trans('label.child_events') }}</a></li>
                            <ul class="menu-list">
                                @foreach($event->childEvents as $childEvent)
                                <li><a>{{ $childEvent->title }}</a></li>
                                @endforeach
                            </ul>
                            @endif
                            @if(count($event->participationClasses))
                                <li class="menu-label"><a href="#">{{ trans('label.participation_classes') }}</a></li>
                                <ul class="menu-list">
                                    @foreach($event->participationClasses as $participationClass)
                                        <li><a>{{ $participationClass->title }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                            @if(count($event->visitClasses))
                                <li class="menu-label"><a href="#">{{ trans('label.visit_classes') }}</a></li>
                                <ul class="menu-list">
                                    @foreach($event->visitClasses as $visitClass)
                                        <li><a>{{ $visitClass->title }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                            <li class="menu-label"><a href="#">{{ trans('label.about_the_organizer') }}</a></li>
                            <li class="menu-label"><a href="#">{{ trans('label.participants') }}</a></li>
                            <li class="menu-label"><a href="#">{{ trans('label.ratings') }}</a></li>
                            <li class="menu-label">
                                Administration </li>
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
                            <li class="menu-label">
                                Transactions </li>
                            <ul class="menu-list">
                                <li><a>Payments</a></li>
                                <li><a>Transfers</a></li>
                                <li><a>Balance</a></li>
                            </ul>
                        </scrollspy-list>
                        <hr>
                        <h4 class="title">{{ trans('label.contact') }}</h4>
                        <p class="subtitle">Du hast Fragen zu dem Event? Du kannst den Veranstalter gerne jederzeit kontaktieren.</p>
                        <ul class="info-list">
                            <li><icon icon="{{ config('icons.email') }}"></icon><span>{{ $event->email }}</span></li>
                            <li><icon icon="{{ config('icons.phone') }}"></icon><span>{{ $event->phone }}</span></li>
                        </ul>
                        </div>
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
</script>
<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 8
        });
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDm4OjsZfncEnSFopTI5-DoPlk5uvPh3F4&callback=initMap"
        async defer></script>
@endpush