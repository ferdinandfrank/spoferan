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
                            :step-props="[@if($selectedEventPart){selectedTitle: '{{ $selectedEventPart->title}}'}@if($selectedParticipationClass),{selectedTitle: '{{ $selectedParticipationClass->title}}'}@endif @endif]">
                        @if(count($event->childEvents))
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
                        @endif
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
                                <h2 class="title wizard-title">{{ trans('action.confirm_and_pay_participation') }}</h2>
                                <p class="subtitle">Hier findest du eine Übersicht über deine Teilnahme. Bitte
                                    kontrolliere deine Teilnahmedaten, wähle eine Zahlungsmethode aus und klicke auf
                                    "{{ trans('action.confirm_and_pay_participation') }}".</p>
                            </div>
                            <div class="content">
                                <ajax-form ref="form" action="{{ route('participations.store') }}" method="POST"
                                           alert-key="participation_payed" redirect="{{ $event->getPath() }}">
                                    <h4>1. {{ trans('label.participation_overview') }}</h4>
                                    <div class="columns">
                                        <div class="column is-6">
                                            <ul class="info-list">
                                                <li><b>Ausgewähltes Event:</b>&nbsp;<span
                                                            id="selected-event-title">@{{ selectedEvent.title }}</span>
                                                </li>
                                                @if(count($event->childEvents))
                                                    <li><b>Ausgewählter Eventteil:</b>&nbsp;<span
                                                                id="selected-event_part-title">@{{ selectedEventPart.title }}</span>
                                                        &nbsp;<small v-on:click.prevent="setStep(0)"
                                                                     class="is-secondary link">{{ trans('action.change') }}</small>
                                                    </li>
                                                @endif
                                                <li><b>Ausgewählte Teilnahmeklasse:</b>&nbsp;<span
                                                            id="selected-participation_class-title">@{{ selectedParticipationClass.title }}</span>
                                                    &nbsp;<small v-on:click.prevent="@if(count($event->childEvents))setStep(1)@else setStep(0) @endif"
                                                                 class="is-secondary link">{{ trans('action.change') }}</small>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="column is-6">
                                            <ul class="info-list">
                                                <li>
                                                    <b>Teilnehmer:</b>&nbsp;<span>{{ $loggedUser->getDisplayName() }}</span>
                                                </li>
                                                <li><b>{{ trans('label.starter_number') }}
                                                        :</b>&nbsp;<span>{{ $loggedUser->athlete->starter_number }}</span>
                                                </li>
                                                <form-checkbox class="m-t-10" lang-key="participation"
                                                               name="privacy"></form-checkbox>
                                            </ul>
                                        </div>
                                    </div>

                                    <hr>
                                    @if(count($loggedUser->paymentDetails))
                                        <h4>2. Zahlungsmethode auswählen</h4>
                                        <p class="is-warning">Info: Zur Darstellung des Bezahlprozesses für eine Eventanmeldung dient die Bezahlung mit Kreditkarte.
                                            Weitere Zahlungsmethoden können im Prototypen aus Sicherheits- und Testgründen nicht vorgeführt werden.</p>
                                        <div class="columns">
                                            <div class="column is-12">
                                                <h5>Kreditkarten</h5>
                                                <p class="no-data"
                                                   v-if="!cards || !cards.length">{{ trans('info.payment.no_credit_cards') }}</p>
                                                <form-radio v-for="(card, index) in cards" name="source"
                                                            :value="card.id" :checked="index == 0">
                                                    <div>
                                                        <img :src="'/images/icons/credit_cards/' + toSnakeCase(card.brand) + '.png'"
                                                             width="25"/>
                                                        <b>@{{ card.brand }}</b>
                                                        <small>endet auf @{{ card.last4 }}</small>
                                                    </div>
                                                    <small class="m-t-2 m-b-2">@{{ card.name }}</small>
                                                    <small class="muted">gültig bis @{{ card.exp_month }}
                                                        /@{{ card.exp_year }}</small>
                                                </form-radio>

                                                <a class="button is-small" v-on:click="showAddCCForm()">
                                            <span class="icon is-small">
                                                <icon icon="{{ config('icons.add') }}"></icon>
                                            </span>
                                                    <span>{{ trans('action.add_credit_card') }}</span>
                                                </a>
                                            </div>
                                            {{--<div class="column is-6">--}}
                                                {{--<h5>Bankeinzugskonten</h5>--}}
                                                {{--<p class="no-data"--}}
                                                   {{--v-if="!bankAccounts || !bankAccounts.length">{{ trans('info.payment.no_bank_accounts') }}</p>--}}
                                                {{--<form-radio v-for="(bankAccount, index) in bankAccounts" name="source"--}}
                                                            {{--:value="bankAccount.id" :checked="index == 0">--}}
                                                    {{--<div>--}}
                                                        {{--<b>Bankeinzugskonto</b>--}}
                                                        {{--<small>endet auf @{{ bankAccount.last4 }}</small>--}}
                                                    {{--</div>--}}
                                                    {{--<small class="m-t-2 m-b-2">@{{ bankAccount.account_holder_name }}</small>--}}
                                                {{--</form-radio>--}}

                                                {{--<a class="button is-small" disabled>--}}
                                            {{--<span class="icon is-small">--}}
                                                {{--<icon icon="{{ config('icons.add') }}"></icon>--}}
                                            {{--</span>--}}
                                                    {{--<span>{{ trans('action.add_bank_account') }}</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                        </div>

                                        <hr>
                                    @endif
                                    <h4>3. Gutschein einlösen</h4>
                                    <p class="is-warning">Info: Es kann der Gutschein-Code "TEST-COUPON" verwendet werden.</p>
                                    <div class="columns">
                                        <div class="column is-4">
                                            <form-input name="coupon" :ignore-errors="true" :check="validateCoupon" icon-left="{{ config('icons.coupon') }}" validate-on="change"></form-input>
                                        </div>
                                    </div>
                                        <hr>
                                    <div class="flex-end">
                                        <div class="flex-column">
                                            <p class="m-b-2">Gesamtpreis inkl. Mwst.</p>
                                            <h2 class="m-none" v-if="!coupon">€ @{{ price }}</h2>
                                            <h4 class="line-through m-none" v-if="coupon">€ @{{ price }}</h4>
                                            <p v-if="coupon">@{{ couponInfo }}</p>
                                            <h2 class="m-none" v-if="coupon">€ @{{ couponPrice }}</h2>
                                        </div>
                                    </div>
                                    <div class="center m-t-50">
                                        <hidden-input name="participation_class_id"
                                                      v-model="selectedParticipationClass.id"></hidden-input>
                                        <button type="submit" class="button is-success is-medium" :disabled="!valid">
                                                <span>
                                                <span class="icon is-small">
                                                    <icon icon="{{ config('icons.check') }}"></icon>
                                                </span>
                                                <span>{{ trans('action.confirm_and_pay_participation') }}</span>
                                                </span>
                                        </button>
                                        <p class="no-data is-warning"
                                           v-if="!valid">{{ trans('info.payment.no_payment_method') }}</p>
                                    </div>
                                </ajax-form>
                            </div>
                        </section>
                    </wizard>
                </section>
            </div>
        </div>
    </div>

    <modal-form ref="addCCForm" action="{{ route('payment_details.store', $loggedUser->activePaymentDetails->getKey()) }}"
                id="addCCForm"
                :labels="{save: '{{ trans('action.add_credit_card') }}'}" title="{{ trans('action.add_credit_card') }}"
                alert-key="credit_card" callback-name="addCreditCardResponse" :reset="true" method="POST">
        <div class="columns">
            <div class="column">
                <p>Spoferan akzeptiert die folgenden Kreditkarten:</p>
                <span class="tooltip tooltip-bottom">
                <img src="{{ asset('images/icons/credit_cards/visa.png') }}" width="40"/>
                <span class="tooltip-text">Visa</span>
            </span>
                <span class="tooltip tooltip-bottom">
                <img src="{{ asset('images/icons/credit_cards/mastercard.png') }}" width="40"/>
                <span class="tooltip-text">MasterCard</span>
            </span>
                <span class="tooltip tooltip-bottom">
                <img src="{{ asset('images/icons/credit_cards/jcb.png') }}" width="40"/>
                <span class="tooltip-text">JCB</span>
            </span>
                <span class="tooltip tooltip-bottom">
                <img src="{{ asset('images/icons/credit_cards/discover.png') }}" width="40"/>
                <span class="tooltip-text">Discover</span>
            </span>
                <span class="tooltip tooltip-bottom">
                <img src="{{ asset('images/icons/credit_cards/diners.png') }}" width="40"/>
                <span class="tooltip-text">Diners</span>
            </span>
                <span class="tooltip tooltip-bottom">
                <img src="{{ asset('images/icons/credit_cards/american_express.png') }}" width="40"/>
                <span class="tooltip-text">AmericanExpress</span>
            </span>
            </div>
            <div class="column">
                <p>Deine ausgewählte Karte:</p>
                <div id="cc-wrapper"></div>
            </div>
        </div>

        <hr/>
        <div class="columns is-multiline">
            <hidden-input name="type" value="card"></hidden-input>
            <div class="column is-6">
                <form-input icon="{{ config('icons.credit_card') }}" lang-key="credit_card" name="number" :required="true"></form-input>
            </div>
            <div class="column is-6">
                <form-input icon="{{ config('icons.user') }}" lang-key="credit_card" name="name" :required="true"></form-input>
            </div>
            <div class="column is-6">
                <form-input icon="{{ config('icons.calendar') }}" lang-key="credit_card" name="expiry" :required="true"></form-input>
            </div>
            <div class="column is-6">
                <form-input icon="{{ config('icons.password') }}" lang-key="credit_card" type="number" name="cvc" :required="true"></form-input>
            </div>
            <p class="is-warning">Info: Zum Testen des Prototypen kann eine Kreditkarte mit den folgenden Test-Kartennummern und beliebigen weiteren Daten erstellt werden:</p>
            <ul class="info-list">
                <li><b>Visa:</b>&nbsp;4242 4242 4242 4242</li>
                <li><b>Mastercard:</b>&nbsp;5555 5555 5555 4444</li>
                <li><b>American Express:</b>&nbsp;3782 822463 10005</li>
            </ul>
        </div>
    </modal-form>

    <modal-form ref="addBAForm" action="{{ route('payment_details.store', $loggedUser->getKey()) }}"
                :labels="{save: '{{ trans('action.add_bank_account') }}'}"
                title="{{ trans('action.add_bank_account') }}" alert-key="bank_account"
                callback-name="addBankAccountResponse" :reset="true" method="POST">
        <div class="columns is-multiline">
            <hidden-input name="type" value="sepa_debit"></hidden-input>
            <div class="column is-6">
                <form-input lang-key="bank_account" name="iban" :required="true"></form-input>
            </div>
            <div class="column is-6">
                <form-input lang-key="bank_account" name="name" :required="true"></form-input>
            </div>
        </div>
    </modal-form>

@endsection

@push('js')
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app',

            data() {
                return {
                    form: null,
                    valid: false,
                    wizard: null,
                    coupons: <?php echo $coupons; ?>,
                    selectedEvent: <?php echo $event; ?>,
                    selectedEventPart: <?php echo $selectedEventPart ?? '{}'; ?>,
                    selectedParticipationClass: <?php echo $selectedParticipationClass ?? '{}'; ?>,
                    cards: <?php echo json_encode($loggedUser->activePaymentDetails->getCards()['data']); ?>,
                    bankAccounts: <?php echo json_encode($loggedUser->activePaymentDetails->getBankAccounts()['data']); ?>,
                    coupon: null,
                    couponInfo: null,
                    couponPrice: null,
                    price: null
                }
            },

            mounted: function () {
                this.$nextTick(function () {
                    this.wizard = this.$refs.wizard;
                    this.form = this.$refs.form;
                    this.valid = !!this.form.form.data.source;
                    this.price = formatMoney(this.selectedParticipationClass.price);

                    window.eventHub.$on('response_addCreditCard', (success, response) => {
                        if (success) {
                            this.$refs.addCCForm.hide();
                            this.cards.push(response);
                        }
                    });

                    window.eventHub.$on('response_addBankAccount', (success, response) => {
                        if (success) {
                            this.$refs.addBAForm.hide();
                            this.bankAccounts.push(response);
                        }
                    });

                    window.eventHub.$on('input-value-changed', (name, value) => {
                        if (name === 'source') {
                            this.valid = !!value;
                        }
                    });


                    window.eventHub.$on('wizard_step_changed', (step, lastStep) => {

                        // Event Part selected
                        @if(count($event->childEvents))
                        if (lastStep.index === 0 && lastStep.selectedKey !== this.selectedEventPart.slug) {
                            sendRequest('/events/' + lastStep.selectedKey + '/participation-classes', 'get', null, function (response) {
                                replaceContent('#participation_classes_list', response);
                            });

                            sendRequest('/api/events/' + lastStep.selectedKey, 'get', null, (response) => {

                                // Remove old selected class from event preview card
                                $('#' + this.selectedEventPart.slug).children().removeClass('selected');

                                // Add selected class to new selected event preview card
                                $('#' + response.slug).children().addClass('selected');

                                this.selectedEventPart = response;
                            });
                        } else if (lastStep.index === 1 && lastStep.index < step.index && lastStep.selectedKey !== this.selectedParticipationClass.id) {
                            sendRequest('/api/participation-classes/' + lastStep.selectedKey, 'get', null, (response) => {

                                // Remove old selected class from participation class preview card
                                $('#' + this.selectedParticipationClass.id).children().removeClass('selected');

                                // Add selected class to new selected participation class preview card
                                $('#' + response.id).children().addClass('selected');

                                this.selectedParticipationClass = response;
                                this.price = formatMoney(this.selectedParticipationClass.price);
                            });
                        }
                        @else
                        if (lastStep.index === 0 && lastStep.selectedKey !== this.selectedParticipationClass.id) {
                            sendRequest('/api/participation-classes/' + lastStep.selectedKey, 'get', null, (response) => {

                                // Remove old selected class from participation class preview card
                                $('#' + this.selectedParticipationClass.id).children().removeClass('selected');

                                // Add selected class to new selected participation class preview card
                                $('#' + response.id).children().addClass('selected');

                                this.selectedParticipationClass = response;
                                this.price = formatMoney(this.selectedParticipationClass.price);
                            });
                        }
                        @endif


                    });

                    window.eventHub.$on('element_selected', (selectedKey, selectedTitle) => {
                        this.select(selectedKey, selectedTitle);
                    });

                    var card = new Card({
                        form: '#addCCForm',
                        // a selector or DOM element for the container
                        // where you want the card to appear
                        container: '#cc-wrapper', // *required*

                        formatting: true, // optional - default true

                        // Strings for translation - optional
                        messages: {
                            validDate: 'valid\ndate', // optional - default 'valid\nthru'
                            monthYear: 'mm/yyyy', // optional - default 'month/year'
                        },

                        // Default placeholders for rendered fields - optional
                        placeholders: {
                            number: '•••• •••• •••• ••••',
                            name: 'XXX XXX',
                            expiry: '••/••',
                            cvc: '•••'
                        },

                        masks: {
                            cardNumber: '•' // optional - mask card number
                        },

                        // if true, will log helpful messages for setting up Card
                        debug: false // optional - default false
                    });

                })
            },

            methods: {
                select: function (selectedKey, selectedTitle) {
                    this.wizard.select(selectedKey, selectedTitle);
                },
                setStep: function (stepIndex) {
                    this.wizard.setStep(stepIndex);
                },
                showAddCCForm: function () {
                    this.$refs.addCCForm.show();
                },
                showAddBAForm: function () {
                    this.$refs.addBAForm.show();
                },
                toSnakeCase: function (string) {
                    return toSnakeCase(string);
                },

                validateCoupon: function(value, callback) {
                    let coupon = getObjectByValue(this.coupons, 'code', value);

                    this.coupon = coupon;
                    if (coupon) {
                        let off = coupon.amount_off ? formatMoney(coupon.amount_off) + ' €' : coupon.percent_off + ' %';
                        this.couponInfo = '- ' + off  + ' (' + coupon.code + ')';
                        this.couponPrice = coupon.amount_off ? this.selectedParticipationClass.price - coupon.amount_off : this.selectedParticipationClass.price * (coupon.percent_off / 100);
                        this.couponPrice = formatMoney(this.couponPrice);
                        callback(true);
                    } else {
                        this.couponInfo = null;
                        this.couponPrice = null;
                        callback(false, this.$t('validation.coupon'));
                    }
                }
            }
        });
    });
</script>@endpush