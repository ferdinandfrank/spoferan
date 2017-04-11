<collapsible-card class="price-card {{ $class ?? '' }}">

    <div slot="header" class="content">
        <div class="header">
            <div>
                <h3 class="title">{{ $participationClass->title }}</h3>
                <p class="subtitle">{{ trans_choice('param_label.already_num_of_participants', count($participationClass->participations), ['num' => count($participationClass->participations)]) }}</p>
            </div>
            <p class="price">{{ formatMoney($participationClass->price) }}</p>
        </div>
        <p>{{ $participationClass->description }}</p>
        <div class="action">
            @if($participationClass->canParticipate())
                <a class="button is-success" @if(isset($onClick)) v-on:click.prevent="{{ $onClick }}" @else href="{{
                    $event->isChild() ?
                        queryRoute(route('participation.create', ['event' => $event->parentEvent]), [config('query.child_event') => $event->getRouteKey(), config('query.participation_class') => $participationClass->getRouteKey()])
                        : queryRoute(route('participation.create', ['event' => $event]), [config('query.child_event') => $event->getRouteKey(), config('query.participation_class') => $participationClass->getRouteKey()]) }}" @endif>

                    <span class="icon is-small">
                    <icon icon="{{ config('icons.buy') }}"></icon>
                </span>
                    <span>{{ $actionText ?? trans('action.participate') }}</span>
                </a>
            @else
                <p class="is-warning">{{ $participationClass->getParticipationRestriction()['msg'] }}</p>
            @endif
        </div>
    </div>

    <div class="columns">
        <div class="column is-7">
            <h5>{{ trans('label.info') }}</h5>
            <ul class="info-list">
                <li><b>{{ trans('label.start_time') }}
                        :</b>&nbsp;{{ dateDiffForHumans($participationClass->start_date) }}</li>
                <li><b>{{ trans('label.end_time') }}:</b>&nbsp;{{ dateDiffForHumans($participationClass->start_date) }}
                </li>
                <li><b>{{ trans('label.registration_start') }}
                        :</b>&nbsp;{{ dateDiffForHumans($participationClass->register_date) }}</li>
                <li><b>{{ trans('label.registration_end') }}
                        :</b>&nbsp;{{ dateDiffForHumans($participationClass->unregister_date) }}</li>
            </ul>
        </div>
        <div class="column">
            <h5>{{ trans('label.participation_restrictions') }}</h5>
            <ul class="info-list">
                @if(!empty($participationClass->restr_limit))
                    <li><b>{{ trans('label.participants_limit') }}
                            :</b>&nbsp;{{ count($participationClass->participations) }}
                        / {{ $participationClass->restr_limit }}</li>
                @endif
                @if(!empty($participationClass->restr_birth_date_min))
                    <li><b>{{ trans('label.min_age') }}:</b>&nbsp;{{ $participationClass->restr_birth_date_min->age }}
                        ({{ dateDiffForHumans($participationClass->restr_birth_date_min, false) }})
                    </li>
                @endif
                @if(!empty($participationClass->restr_birth_date_max))
                    <li><b>{{ trans('label.max_age') }}:</b>&nbsp;{{ $participationClass->restr_birth_date_max->age }}
                        ({{ dateDiffForHumans($participationClass->restr_birth_date_max, false) }})
                    </li>
                @endif
                @if(!empty($participationClass->restr_gender))
                    <li><b>{{ trans('label.gender_restr') }}
                            :</b>&nbsp;{{ $participationClass->restr_gender == 'm' ? trans('label.male') : trans('label.female') }}
                    </li>
                @endif
                @if(!empty($participationClass->restr_country))
                    <li><b>{{ trans('label.country_restr') }}
                            :</b>&nbsp;{{ trans('countries.') . $participationClass->restr_country }}</li>
                @endif
                @if(!empty($participationClass->restr_city))
                    <li><b>{{ trans('label.city_restr') }}:</b>&nbsp;{{ $participationClass->restr_city }}</li>
                @endif
                @if(!empty($participationClass->restr_postcode))
                    <li><b>{{ trans('label.postcode_restr') }}:</b>&nbsp;{{ $participationClass->restr_postcode }}</li>
                @endif
            </ul>
        </div>
    </div>
</collapsible-card>