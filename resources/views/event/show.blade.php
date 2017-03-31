@extends('layouts.main')

@section('content')
    <div class="container">
        @component('components.breadcrumb')
            <li><a href="{{ route('events.index') }}">{{ trans('label.events') }}</a></li>
            @if($event->isChild())
                <li><a href="{{ $event->parentEvent->getPath() }}">{{ $event->parentEvent->title }}</a></li>
            @endif
            <li><a href="#">{{ $event->title }}</a></li>
        @endcomponent
        <div class="card">
            @include('event.header')

            <div class="card-content">
                @include('event.info_level')
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
                                <p class="subtitle">{{ trans('descriptions.event.time_and_location') }}</p>
                            </div>
                            <div class="content">
                                <div id="map" style="height: 500px"></div>
                            </div>
                        </section>

                        @if(count($event->childEvents))
                            <section id="child_events" class="section">
                                <div class="heading">
                                    <h2 class="title">{{ trans('label.child_events') }}</h2>
                                    <p class="subtitle">{{ trans('descriptions.event.child_events') }}</p>
                                </div>
                                <div class="content">
                                    <div class="columns is-multiline">
                                        @foreach($event->childEvents as $childEvent)
                                            <div id="{{ $childEvent->getRouteKey() }}" class="column">
                                                @include('event.preview', ['event' => $childEvent, 'class' => $childEvent->canParticipate() ? 'suggestion' : ''])
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif

                        @if(count($goodParticipationClasses) || count($participationClasses))
                            <section id="participation_classes" class="section">
                                <div class="heading">
                                    <h2 class="title">{{ trans('label.participation_classes') }}</h2>
                                    <p class="subtitle">{{ trans('descriptions.event.participation_classes') }}</p>
                                </div>
                                <div class="content">
                                    <div class="columns is-multiline">
                                        @foreach($goodParticipationClasses as $participationClass)
                                            <div id="participation_class_{{ $participationClass->getRouteKey() }}"
                                                 class="column is-12">
                                                @include('participation_class.preview', ['class' => 'suggestion'])
                                            </div>
                                        @endforeach
                                        @foreach($participationClasses as $participationClass)
                                            <div id="participation_class_{{ $participationClass->getRouteKey() }}"
                                                 class="column is-12">
                                                @include('participation_class.preview')
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif

                        @if(count($goodVisitClasses) || count($visitClasses))
                            <section id="visit_classes" class="section">
                                <div class="heading">
                                    <h2 class="title">{{ trans('label.visit_classes') }}</h2>
                                    <p class="subtitle">{{ trans('descriptions.event.visit_classes') }}</p>
                                </div>
                                <div class="content">
                                    <div class="columns is-multiline">
                                        @foreach($goodVisitClasses as $visitClass)
                                            <div id="visit_class_{{ $visitClass->getRouteKey() }}" class="column is-12">
                                                @include('visit_class.preview', ['class' => 'suggestion'])
                                            </div>
                                        @endforeach
                                        @foreach($visitClasses as $visitClass)
                                            <div id="visit_class_{{ $visitClass->getRouteKey() }}" class="column is-12">
                                                @include('visit_class.preview')
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif

                        <section id="participants" class="section">
                            <div class="heading">
                                <h2 class="title">{{ trans('label.participants') }}</h2>
                                @if(count($event->childEvents))
                                    <p class="subtitle">{{ trans('descriptions.event.participants') }}</p>
                                @endif
                            </div>
                            <div class="content">
                                @if(count($event->participations))
                                    @include('participation.table', ['participations' => $event->participations, 'finished' => $participationRestriction == 'restr_finished'])
                                @elseif(!count($event->childEvents))
                                    <p class="muted">{{ trans('info.event.no_participants') }}</p>
                                @endif

                                @foreach($event->childEvents as $childEvent)
                                    <h4>{{ trans('label.child_event') }}: {{ $childEvent->title }}</h4>
                                    <div class="m-b-40">
                                        @include('participation.table', ['participations' => $childEvent->participations, 'finished' => $participationRestriction == 'restr_finished'])
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section id="about_the_organizer" class="section">
                            <div class="heading">
                                <h2 class="title">{{ trans('label.about_the_organizer') }}</h2>
                            </div>
                            <div class="content">
                                <div class="columns">
                                    <div class="column is-2">
                                        <img src="{{ $event->organizer->user->avatar }}" class="avatar">
                                    </div>
                                    <div class="column flex-column-center">
                                        <h4>{{ $event->organizer->getDisplayName() }}</h4>
                                        <p>{{ $event->organizer->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                    <div id="sidebar" class="column">
                        <div class="theiaStickySidebar">
                            <div class="columns is-multiline">
                                <div class="column is-12">
                                    @if(empty($participationRestriction))
                                        <a href="{{ $event->isChild() ? route('participation.create', ['event' => $event->parentEvent]) : route('participation.create', ['event' => $event]) }}"
                                           class="button is-large is-success responsive">
                                        <span class="icon is-small">
                                            <icon icon="{{ config('icons.buy') }}"></icon>
                                        </span>
                                            <span>{{ trans('action.participate') }}</span>
                                        </a>
                                    @elseif($participationRestriction == 'restr_registered')
                                        <a href="{{ route('login') }}" class="button is-large is-success responsive">
                                        <span class="icon is-small">
                                            <icon icon="{{ config('icons.user') }}"></icon>
                                        </span>
                                            <span>{{ trans('action.login') }}</span>
                                        </a>
                                    @else
                                        <p class="is-warning">{{ trans('label.hint') }}: {{ trans('validation.event.' . $participationRestriction) }}</p>
                                        @if($participationRestriction == 'restr_finished')
                                            <a href="#participants" data-scroll class="button is-large is-success responsive">
                                                <span class="icon is-small">
                                                    <icon icon="{{ config('icons.statistics') }}"></icon>
                                                </span>
                                                <span>{{ trans('action.show_results') }}</span>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                                @if(Auth::check())
                                    <div class="column is-6" title="{{ trans('info.not_available_yet') }}">
                                        <a class="button responsive" disabled >
                                <span class="icon is-small">
                                  <icon icon="{{ config('icons.watchlist') }}"></icon>
                                </span>
                                            <span>{{ trans('action.add_to_watchlist') }}</span>
                                        </a>
                                    </div>
                                @endif
                                <div class="column share-buttons" title="{{ trans('info.not_available_yet') }}">
                                    <a class="button responsive facebook" disabled>
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
                                <li class="menu-label"><a
                                            href="#time_and_location">{{ trans('label.time_and_location') }}</a></li>
                                @if(count($event->childEvents))
                                    <li class="menu-label"><a href="#child_events">{{ trans('label.child_events') }}</a>
                                    </li>
                                    <ul class="menu-list">
                                        @foreach($event->childEvents as $childEvent)
                                            <li><a href="#{{ $childEvent->getRouteKey() }}">{{ $childEvent->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if(count($goodParticipationClasses) || count($participationClasses))
                                    <li class="menu-label"><a
                                                href="#participation_classes">{{ trans('label.participation_classes') }}</a>
                                    </li>
                                    <ul class="menu-list">
                                        @foreach($goodParticipationClasses as $participationClass)
                                            <li>
                                                <a href="#participation_class_{{ $participationClass->getRouteKey() }}">{{ $participationClass->title }}</a>
                                            </li>
                                        @endforeach
                                        @foreach($participationClasses as $participationClass)
                                            <li>
                                                <a href="#participation_class_{{ $participationClass->getRouteKey() }}">{{ $participationClass->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if(count($goodVisitClasses) || count($visitClasses))
                                    <li class="menu-label"><a
                                                href="#visit_classes">{{ trans('label.visit_classes') }}</a></li>
                                    <ul class="menu-list">
                                        @foreach($goodVisitClasses as $visitClass)
                                            <li>
                                                <a href="#visit_class_{{ $visitClass->getRouteKey() }}">{{ $visitClass->title }}</a>
                                            </li>
                                        @endforeach
                                        @foreach($visitClasses as $visitClass)
                                            <li>
                                                <a href="#visit_class_{{ $visitClass->getRouteKey() }}">{{ $visitClass->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <li class="menu-label"><a href="#participants">{{ trans('label.participants') }}</a>
                                </li>
                                <li class="menu-label"><a
                                            href="#about_the_organizer">{{ trans('label.about_the_organizer') }}</a>
                                </li>
                                <li class="menu-label"><a href="#ratings">{{ trans('label.ratings') }}</a></li>
                            </scrollspy-list>
                            <hr>
                            <h4 class="title">{{ trans('label.contact') }}</h4>
                            <p class="subtitle">{{ trans('descriptions.event.contact') }}</p>
                            <ul class="info-list">
                                <li>
                                    <icon icon="{{ config('icons.email') }}"></icon>
                                    <span>{{ $event->email }}</span></li>
                                <li>
                                    <icon icon="{{ config('icons.phone') }}"></icon>
                                    <span>{{ $event->phone }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('google.api_key_browser') }}"></script>
<script src="{{ asset('js/geocode.js') }}"></script>
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app',
            mounted() {

                        @if(count($event->checkPoints))
                var start = {{ $event->startCheckPoint->getLatLng() }};
                var finish = {{ $event->finishCheckPoint->getLatLng() }};

                var map = initMap('map', start);

                calculateAndDisplayRoute(initMapDirectionsService(), initMapDirectionsRenderer(map), <?php echo $event->startCheckPoint ?>, <?php echo $event->finishCheckPoint ?>, <?php echo $event->middleCheckPoints ?>);

                if (start.lat == finish.lat && start.lng == finish.lng) {
                    var startfinishInfo = '<div id="content">' +
                        '<h2 class="title">{{ trans('label.start_point') }}/{{ trans('label.end_point') }}</h2>' +
                        '<p class="subtitle">{{ $event->startCheckPoint->getFullAddress() }}</p>' +
                        '<h4>{{ trans('label.start_info') }}</h4>' +
                        '<p>{{ $event->startCheckPoint->description }}</p>' +
                        '<h4>{{ trans('label.finish_info') }}</h4>' +
                        '<p>{{ $event->finishCheckPoint->description }}</p>' +
                        '</div>';

                    setMarker(map, start, "{{ trans('label.start_point') }}/{{ trans('label.end_point') }}", "{{ asset('images/icons/startfinish.png') }}", startfinishInfo);
                } else {
                    var startInfo = '<div id="content">' +
                        '<h2 class="title">{{ $event->startCheckPoint->title }}</h2>' +
                        '<p class="subtitle">{{ $event->startCheckPoint->getFullAddress() }}</p>' +
                        '<p>{{ $event->startCheckPoint->description }}</p>' +
                        '</div>';
                    setMarker(map, start, "{{ trans('label.start_point') }}", "{{ asset('images/icons/start.png') }}", startInfo);

                    var finishInfo = '<div id="content">' +
                        '<h2 class="title">{{ $event->finishCheckPoint->title }}</h2>' +
                        '<p class="subtitle">{{ $event->finishCheckPoint->getFullAddress() }}</p>' +
                        '<p>{{ $event->finishCheckPoint->description }}</p>' +
                        '</div>';
                    setMarker(map, finish, "{{ trans('label.end_point') }}", "{{ asset('images/icons/finish.png') }}", finishInfo);
                }

                        @foreach($event->middleCheckPoints as $checkPoint)
                var checkPointInfo = '<div id="content">' +
                        '<h2 class="title">{{ $checkPoint->title }}</h2>' +
                        '<p class="subtitle">{{ $checkPoint->getFullAddress() }}</p>' +
                        '<p>{{ $checkPoint->description }}</p>' +
                        '</div>';
                setMarker(map, {{ $checkPoint->getLatLng() }}, "{{ trans('label.check_point') }}", "{{ asset('images/icons/checkpoint.png') }}", checkPointInfo);
                @endforeach

                geocode({address: "{{ $event->getFullAddress() }}"}, function (result) {
                    var meeting = {lat: result.geometry.location.lat(), lng: result.geometry.location.lng()};
                    setMeetingPointMarker(map, meeting);
                });
                @else
                    geocode({address: "{{ $event->getFullAddress() }}"}, function (result) {
                    var start = {lat: result.geometry.location.lat(), lng: result.geometry.location.lng()};
                    var map = initMap('map', start);
                    setMeetingPointMarker(map, start);
                });
                @endif
            }
        });

        $('#sidebar').theiaStickySidebar({
            // Settings
            additionalMarginTop: 100
        });
    });

    function setMeetingPointMarker(map, latlng) {
        var meetingInfo = '<div id="content">' +
            '<h2 class="title">{{ trans('label.meeting_point') }}</h2>' +
            '<p class="subtitle">{{ $event->getFullAddress() }}</p>' +
            '<p>{{ trans('descriptions.event.map.meeting') }}</p>' +
            '<ul class="info-list">' +
            '<li><b>{{ trans('label.time') }}:</b>&nbsp;{{ dateDiffForHumans($event->start_date) }}</li>' +
            '</ul>' +
            '</div>';
        setMarker(map, latlng, "{{ trans('label.meeting_point') }}", "{{ asset('images/icons/meeting.png') }}", meetingInfo);
    }
</script>


@endpush