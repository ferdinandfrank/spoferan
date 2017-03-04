<collapsible-card class="price-card">

        <div slot="header" class="price">
            <small>€</small>
            <span>{{ $visitClass->entry_fee }}</span>
        </div>
        <div slot="header" class="content">
            <h3 class="title">{{ $visitClass->title }}</h3>
            <p class="subtitle">{{ trans_choice('param_label.already_num_of_visitors', count($visitClass->visits), ['num' => count($visitClass->visits)]) }}</p>
            <p>{{ $visitClass->description }}</p>
        </div>
        <div slot="header" class="action">
            @if($visitClass->canVisit())
                <a href="#" class="button is-success">
                <span class="icon is-small">
                    <icon icon="{{ config('icons.buy') }}"></icon>
                </span>
                    <span>{{ trans('action.buy_tickets') }}</span>
                </a>
            @else
                <a href="#" class="button is-success message-button" disabled>
                <span class="icon is-small">
                    <icon icon="{{ config('icons.buy') }}"></icon>
                </span>
                    <span>{{ $visitClass->getVisitRestriction()['msg'] }}</span>
                </a>
            @endif
        </div>

    <div class="columns">
        <div class="column">
            <h5>{{ trans('label.info') }}</h5>
            <ul class="info-list">
                <li><b>{{ trans('label.registration_start') }}:</b>&nbsp; {{ dateDiffForHumans($visitClass->register_date) }}</li>
                <li><b>{{ trans('label.registration_end') }}:</b>&nbsp; {{ dateDiffForHumans($visitClass->unregister_date) }}</li>
                <li><b>{{ trans('label.participants_limit') }}:</b>&nbsp; {{ count($visitClass->visits) }} / {{ $visitClass->restr_limit }}</li>
            </ul>
        </div>
    </div>
</collapsible-card>