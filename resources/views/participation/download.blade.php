{{-- CSS --}}
<style>
    body {
        font-family: 'Folks', 'Montserrat', sans-serif;;
    }
</style>
<body>
<div class="nav-center">
    <a href="{{ route('index') }}" class="nav-item">
        <img class="logo" src="{{ Settings::logo() }}" alt="{{ Settings::title() }}">
    </a>
</div>
<h2 class="title">{{ trans('label.participation_confirmation') }}</h2>

@if($participation->rank)
    <h4>Ergebnis</h4>
    <div class="columns">
        <div class="column is-12">

            <ul class="info-list">
                <li><b>{{ trans('label.rank') }}:</b>&nbsp;<p>{{ $participation->rank }}</p></li>
                @if($participation->metadata)
                    @foreach($participation->metadata as $metadata)
                        <li><b>{{ $metadata['key'] }}:</b>&nbsp;<p>{{ $metadata['value'] }}</p></li>
                    @endforeach
                @endif
            </ul>

        </div>
    </div>
@endif

<h4>Teilnahmedaten</h4>
<div class="columns">
    <div class="column is-6">
        <ul class="info-list">
            <li><b>Event:</b>&nbsp;<p>{{ $event->title }}</p></li>
            @if($childEvent)
                <li><b>Eventteil:</b>&nbsp;<p>{{ $childEvent->title }}</p></li>
                <li><b>Eventstatus:</b>&nbsp;<p>{!! $childEvent->getStatusText() !!}</p></li>
            @else
                <li><b>Eventstatus:</b>&nbsp;<p>{!! $event->getStatusText() !!}</p></li>
            @endif
            <li><b>Teilnahmeklasse:</b>&nbsp;<a
                        href="{{ $participation->participationClass->getPath() }}">{{ $participation->participationClass->title }}</a>
            </li>
        </ul>
    </div>
    <div class="column is-6">
        <ul class="info-list">
            <li><b>Eingetragener
                    Teilnehmername:</b>&nbsp;<p>{{ $participation->athlete->getDisplayName() }}</p>
            </li>
            <li><b>{{ trans('label.starter_number') }}
                    :</b>&nbsp;<p>{{ $participation->starter_number }}</p></li>
            <li><b>Anmeldedatum:</b>&nbsp;<p>{{ dateDiffForHumans($participation->created_at) }}</p>
            </li>
        </ul>
    </div>
</div>
<h4>Wo und wann?</h4>
<div class="columns">
    <div class="column is-12">
        <p>Bitte befinde dich am
            <b>{{ $participation->participationClass->start_date->formatLocalized('%d %B %Y') }} </b>
            spätestens um
            <b>{{ $participation->participationClass->start_date->formatLocalized('%H:%M') }}
                Uhr</b>
            am Ort <b>{{ $event->getFullAddress() }}</b>.</p>
    </div>
</div>
<h4>Informationen des Veranstalters für deine Teilnahme</h4>
<div class="columns">
    <div class="column is-12">
        @if($participation->info)
            <p>{{ $participation->info }}</p>
        @else
            <p class="no-data">{{ trans('info.participation.no_info') }}</p>
        @endif
    </div>
</div>
<h4>Anonymität</h4>
<div class="columns">
    <div class="column is-12">
        @if($participation->privacy)
            <p class="is-warning">Deine Teilnahme ist anonym. Nur der Veranstalter kann deinen
                Namen, sowie alle weiteren notwendigen Daten für deine Teilnahme sehen.</p>
        @else
            <p class="is-success">Deine Teilnahme ist öffentlich. Jeder kann deinen Namen in der
                Teilnehmerliste sehen.</p>
        @endif
    </div>
</div>
<h4>Aktionen</h4>
<div class="columns">
    <div class="column is-12">
        <form-button class="button" method="GET"
                     action="{{ route('participations.download', [$event, $participation]) }}">
                                <span class="icon is-small">
                                            <icon icon="{{ config('icons.print') }}"></icon>
                                        </span>
            <span>Teilnahmebestätigung drucken</span>
        </form-button>
        <button class="button" disabled>
                                <span class="icon is-small">
                                            <icon icon="{{ config('icons.message') }}"></icon>
                                        </span>
            <span>Veranstalter kontaktieren</span>
        </button>
        <button class="button is-danger" disabled>
                                <span class="icon is-small">
                                            <icon icon="{{ config('icons.cancel') }}"></icon>
                                        </span>
            <span>Teilnahme stornieren</span>
        </button>
    </div>
</div>
</body>