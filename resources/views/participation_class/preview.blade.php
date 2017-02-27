<collapsible-card class="price-card">

        <div slot="header" class="price">
            <small>€</small>
            <span>{{ $participationClass->entry_fee }}</span>
        </div>
        <div slot="header" class="content">
            <h3 class="title">{{ $participationClass->title }}</h3>
            <p>{{ $participationClass->description }}</p>
        </div>
        <div slot="header" class="action">
            <a class="button is-success">
                <span class="icon is-small">
                    <icon icon="{{ config('icons.participate') }}"></icon>
                </span>
                <span>{{ trans('action.participate') }}</span></a>
        </div>

    <div class="columns">
        <div class="column is-7">
            <h5>{{ trans('label.info') }}</h5>
            <ul class="info-list">
                <li><b>{{ trans('label.start_time') }}:</b>&nbsp; {{ dateDiffForHumans($participationClass->start_date) }}</li>
                <li><b>{{ trans('label.end_time') }}:</b>&nbsp; {{ dateDiffForHumans($participationClass->start_date) }}</li>
                <li><b>{{ trans('label.registration_start') }}:</b>&nbsp; {{ dateDiffForHumans($participationClass->register_date) }}</li>
                <li><b>{{ trans('label.registration_end') }}:</b>&nbsp; {{ dateDiffForHumans($participationClass->unregister_date) }}</li>
            </ul>
        </div>
        <div class="column">
            <h5>{{ trans('label.participation_restrictions') }}</h5>
            <ul class="info-list">
                @if(!empty($participationClass->restr_limit))
                    <li><b>{{ trans('label.participants_limit') }}:</b>&nbsp; {{ count($participationClass->participations) }} / {{ $participationClass->restr_limit }}</li>
                @endif
                @if(!empty($participationClass->restr_birth_date_min))
                        <li><b>{{ trans('label.min_age') }}:</b>&nbsp; {{ dateDiffForHumans($participationClass->restr_birth_date_min, false) }} ({{ $participationClass->restr_birth_date_min->age }})</li>
                @endif
                @if(!empty($participationClass->restr_birth_date_max))
                        <li><b>{{ trans('label.max_age') }}:</b>&nbsp; {{ dateDiffForHumans($participationClass->restr_birth_date_max, false) }} ({{ $participationClass->restr_birth_date_max->age }})</li>
                @endif
                @if(!empty($participationClass->restr_gender))
                        <li><b>{{ trans('label.gender_restr') }}:</b>&nbsp; {{ $participationClass->restr_gender == 'm' ? trans('label.male') : trans('label.female') }}</li>
                @endif
                @if(!empty($participationClass->restr_country))
                        <li><b>{{ trans('label.country_restr') }}:</b>&nbsp; {{ trans('countries.') . $participationClass->restr_country }}</li>
                @endif
                @if(!empty($participationClass->restr_city))
                        <li><b>{{ trans('label.city_restr') }}:</b>&nbsp; {{ $participationClass->restr_city }}</li>
                @endif
                @if(!empty($participationClass->restr_postcode))
                        <li><b>{{ trans('label.postcode_restr') }}:</b>&nbsp; {{ $participationClass->restr_postcode }}</li>
                @endif
            </ul>
        </div>
    </div>
</collapsible-card>