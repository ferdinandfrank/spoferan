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
                    <wizard ref="wizard"
                            :step-props="[@if(isset($selectedEventPart)){selectedTitle: '{{ $selectedEventPart->title}}'}@if(isset($selectedParticipationClass)),{selectedTitle: '{{ $selectedParticipationClass->title}}'}@endif @endif]">
                        <section id="{{ config('query.child_event') }}" class="section wizard-section">
                            <div class="heading">
                                <h2 class="title wizard-title">{{ trans('action.select_event_part') }}</h2>
                                <p class="subtitle">Wähle den Eventteil aus, für den du dich anmelden möchtest.</p>
                            </div>
                            <div class="content">
                                <div class="columns is-multiline">
                                    @if(count($event->participationClasses))
                                        <div id="{{ $event->getRouteKey() }}" class="column">
                                            @include('event.preview', ['event' => $event, 'hoverText' => trans('action.select_event_part'), 'onClick' => "select('". $event->getRouteKey(). "', '".$event->title."')"])
                                        </div>
                                    @endif
                                    @foreach($event->childEvents as $childEvent)
                                        <div id="{{ $childEvent->getRouteKey() }}" class="column">
                                            @include('event.preview', [
                                            'event' => $childEvent,
                                            'hoverText' => trans('action.select_event_part'),
                                            'onClick' => "select('". $childEvent->getRouteKey(). "', '".$childEvent->title."')",
                                            'class' => isset($selectedEventPart) && $selectedEventPart->getKey() == $childEvent->getKey() ? 'selected' : ''])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        <section id="{{ config('query.participation_class') }}" class="section wizard-section">
                            <div class="heading">
                                <h2 class="title wizard-title">{{ trans('action.select_participation_class') }}</h2>
                                <p class="subtitle">Wähle die Teilnahmeklasse aus, für die du dich anmelden
                                    möchtest.</p>
                            </div>
                            <div class="content">
                                <div id="participation_classes_list" class="columns is-multiline">
                                    @include('participation_class.index', [
                                    'size' => 'is-12',
                                    'event' => isset($selectedEventPart) ? $selectedEventPart : $event
                                    ])
                                </div>
                            </div>
                        </section>
                        <section id="payment_overview" class="section wizard-section">
                            <div class="heading">
                                <h2 class="title wizard-title">{{ trans('label.participation_overview') }}</h2>
                                <p class="subtitle">Hier findest du eine Übersicht über deine Teilnahme. Bitte
                                    kontrolliere die Daten und klicke dann auf "Teilnahme jetzt bestätigen &
                                    bezahlen".</p>
                            </div>
                            <div class="content">
                                <ul class="info-list">
                                    <li><b>Ausgewähltes Event:</b>&nbsp;<span
                                                id="selected-event-title">@{{ selectedEvent.title }}</span></li>
                                    @if(count($event->childEvents))
                                        <li><b>Ausgewählter Eventteil:</b>&nbsp;<span
                                                    id="selected-event_part-title">@{{ selectedEventPart.title }}</span>
                                        </li>
                                    @endif
                                    <li><b>Ausgewählte Teilnahmeklasse:</b>&nbsp;<span
                                                id="selected-participation_class-title">@{{ selectedParticipationClass.title }}</span>
                                    </li>
                                </ul>
                                <hr>
                                <div class="flex-end">
                                    <p>Gesamtpreis inkl. Mwst.</p>
                                    <h2>€ @{{ selectedParticipationClass.entry_fee }}</h2>
                                </div>
                                <div class="center m-t-50">
                                    <stripe-form ref="stripe"
                                                 action="/participations"
                                                 method="POST"
                                                 :direct-submit="{{ empty(Auth::user()->paymentDetails) ? 'false' : 'true' }}"
                                                 alert-key="participation_payed"
                                                 redirect="{{ $event->getPath() }}"
                                    >
                                        <hidden-input name="participation_class_id"
                                                      v-model="selectedParticipationClass.id"></hidden-input>
                                        <button type="submit" class="button is-success is-medium">
                                                <span class="icon is-small">
                                                    <icon icon="{{ config('icons.buy') }}"></icon>
                                                </span>
                                            <span>Teilnahme jetzt bestätigen & bezahlen</span>
                                        </button>
                                    </stripe-form>

                                </div>

                            </div>
                        </section>
                    </wizard>
                </section>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app',

            data() {
                return {
                    wizard: null,
                    stripe: null,
                    selectedEvent: <?php echo $event; ?>,
                    selectedEventPart: <?php echo $selectedEventPart ?? '{}'; ?>,
                    selectedParticipationClass: <?php echo $selectedParticipationClass ?? '{}'; ?>,
                }
            },

            mounted: function () {
                this.$nextTick(function () {
                    this.wizard = this.$refs.wizard;

                    this.$refs.stripe.stripeData = {
                        image: this.selectedEvent.sport_type.icon,
                        name: this.selectedEvent.title,
                        description: this.selectedEventPart.title ? this.selectedEventPart.title + ": " + this.selectedParticipationClass.title : this.selectedParticipationClass.title,
                        amount: this.selectedParticipationClass.price
                    };

                    window.eventHub.$on('wizard_step_changed', (step, lastStep) => {

                        // Event Part selected
                        if (lastStep.index == 0 && lastStep.selectedKey != this.selectedEventPart.slug) {
                            sendRequest('/events/' + lastStep.selectedKey + '/participation-classes', 'get', null, function (response) {
                                replaceContent('#participation_classes_list', response);
                            });

                            sendRequest('/api/events/' + lastStep.selectedKey, 'get', null, (response) => {
                                this.selectedEventPart = response;
                                this.$refs.stripe.stripeData = {
                                    image: this.selectedEvent.sport_type.icon,
                                    name: this.selectedEvent.title,
                                    description: '',
                                    amount: 0
                                };
                            });
                        } else if (lastStep.index == 1 && lastStep.selectedKey != this.selectedParticipationClass.id) {
                            sendRequest('/api/participation-classes/' + lastStep.selectedKey, 'get', null, (response) => {
                                this.selectedParticipationClass = response;
                                this.$refs.stripe.stripeData.amount = this.selectedParticipationClass.price;
                                this.$refs.stripe.stripeData.description = this.selectedEventPart.title ? this.selectedEventPart.title + ": " + this.selectedParticipationClass.title : this.selectedParticipationClass.title;
                            });
                        }

                    });

                    window.eventHub.$on('element_selected', (selectedKey, selectedTitle) => {
                        this.select(selectedKey, selectedTitle);
                    });

                })
            },

            methods: {
                select: function (selectedKey, selectedTitle) {
                    this.wizard.select(selectedKey, selectedTitle);
                },
            }
        });
    });
</script>@endpush