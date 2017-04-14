@extends('layouts.main')

@section('content')
    <div class="container">
        @component('components.breadcrumb')
            <li><a href="#">{{ trans('label.events') }}</a></li>
            @if($event->isChild())
                <li><a href="{{ $event->parentEvent->getPath() }}">{{ $event->parentEvent->title }}</a></li>
            @endif
            <li><a href="{{ $event->getPath() }}">{{ $event->title }}</a></li>
            <li>{{ trans('label.participation_confirmation') }}</li>
        @endcomponent
        <div class="card">
            @include('event.header')

            <div class="card-content">
                @include('event.info_level')
                <section class="section">
                    @if ($participation->created_at->diffInHours($now) < 2)
                    <message-box type="success"
                                 title="Vielen Dank für deine Anmeldung bei dem Event {{ $event->title }}!">
                        <p>Du solltest innerhalb der nächsten Minuten eine Bestätigung dieser Anmeldung an deine
                            E-Mail-Adresse <strong>{{ $participation->athlete->user->email }}</strong> erhalten. <span class="is-warning">(Nicht im Prototypen)</span> </p>
                        <p>Zum Event solltest du einen Ausdruck dieser Bestätigung mitnehmen, um den Check-In-Prozess
                            möglichst effizient zu gestalten. Du kannst diese jedoch auch später unter dem Menüpunkt
                            <strong>Meine Veranstaltungen</strong> ausdrucken.</p>
                        <button class="button m-b-10" disabled>
                            <span class="icon is-small">
                                        <icon icon="{{ config('icons.print') }}"></icon>
                                    </span>
                            <span>Teilnahmebestätigung drucken</span>
                        </button>
                        @if($participation->privacy)
                            <p class="is-warning">Bitte beachte, dass deine Teilnahme an diesem Event anonym ist. Nur
                                der Veranstalter kann deinen Namen sowie alle weiteren notwendigen Daten für deine
                                Teilnahme sehen.</p>
                        @endif
                    </message-box>
                    @endif
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
                                <li><b>Teilnehmernummer für Rückfragen:</b>&nbsp;<p>{{ $participation->getKey() }}</p>
                                </li>
                                <li><b>{{ trans('label.starter_number') }}
                                        :</b>&nbsp;<p>{{ $participation->starter_number }}</p></li>
                                <li><b>Anmeldedatum:</b>&nbsp;<p>{{ dateDiffForHumans($participation->created_at) }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h4>Zahlungsdaten</h4>
                    <div class="columns">
                        <div class="column is-12">
                            @if($participation->payment)
                                <p class="is-success">Die Teilnahmegebühr von {{ formatMoney($participation->payment->amount) }} (+ {{ formatMoney($participation->payment->fee) }} Teilnahmegebühr) wurde bereits
                                per Kreditkarte gezahlt.</p>
                            @else
                                <p class="is-warning">Die Zahlung für diese Anmeldung ist bisher noch nicht eingegangen. Bitte beachte, dass dieser Vorgang einige Minuten in Anspruch nehmen kann.
                                Schaue einfach in ein paar Minuten noch einmal vorbei.</p>
                            @endif
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
                            <button class="button" disabled>
                                <span class="icon is-small">
                                            <icon icon="{{ config('icons.print') }}"></icon>
                                        </span>
                                <span>Teilnahmebestätigung drucken</span>
                            </button>
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
</script>@endpush