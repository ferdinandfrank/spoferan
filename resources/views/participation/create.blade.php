@extends('layouts.main')

@section('content')
    <div class="container">
        @component('components.breadcrumb')
            <li><a href="#">{{ trans('label.events') }}</a></li>
            @if($event->isChild())
                <li><a href="{{ $event->parentEvent->getPath() }}">{{ $event->parentEvent->title }}</a></li>
            @endif
            <li><a href="{{ $event->getPath() }}">{{ $event->title }}</a></li>
            <li>{{ trans('action.participate') }}</li>
        @endcomponent
        <div class="card">
            @include('event.header')

            <div class="card-content">
                @include('event.info_level')
                <section class="section">
                    <h2 class="title">{{ trans('action.participate_as_athlete') }}</h2>
                    <wizard>
                        @if(count($event->childEvents))
                            <section id="child_events" class="section wizard-section">
                                <div class="heading">
                                    <h2 class="title wizard-title">{{ trans('action.select_event_part') }}</h2>
                                    <p class="subtitle">Wähle den Eventteil aus, für den du dich anmelden möchtest.</p>
                                </div>
                                <div class="content">
                                    <div class="columns is-multiline">
                                        @foreach($event->childEvents as $childEvent)
                                            <div id="{{ $childEvent->getRouteKey() }}" class="column">
                                                @include('event.preview', ['event' => $childEvent, 'hoverText' => trans('action.select_event_part')])
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                            <section id="participation_classes" class="section wizard-section">
                                <div class="heading">
                                    <h2 class="title wizard-title">{{ trans('action.select_participation_class') }}</h2>
                                    <p class="subtitle">Wähle die Teilnahmeklasse aus, für die du dich anmelden möchtest.</p>
                                </div>
                                <div class="content">
                                    <div class="columns is-multiline">
                                        @foreach($event->childEvents as $childEvent)
                                            <div id="{{ $childEvent->getRouteKey() }}" class="column">
                                                @include('event.preview', ['event' => $childEvent, 'hoverText' => trans('action.select_event_part')])
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif
                    </wizard>
                </section>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app',
        });
    });
</script>
@endpush