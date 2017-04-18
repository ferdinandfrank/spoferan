<div class="card {{ $class ?? '' }}">
    <a @if(isset($onClick)) v-on:click.prevent="{{ $onClick }}"
       @else href="{{ $link ?? $participation->getPath() }}" @endif>
        <div class="card-header card-header-image">
            <div class="card-image"
                 style="background-image: url({{ $participation->participationClass->event->cover }})"></div>
            @include('rating.stars', ['rating' => $participation->participationClass->event->getRating()])

            <div class="card-header-info toggle">
                <h1 class="title">{{ $hoverText ?? trans('action.show_participation') }}</h1>
            </div>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-4"
                       title="{{ $participation->participationClass->event->getFullTitle() }}">{{ $participation->participationClass->event->getFullTitle() }}</p>
                    <p class="subtitle is-6">{{ trans('param_label.by_name', ['name' => $participation->participationClass->event->organizer->user->getDisplayName()]) }}</p>
                </div>
                <div class="media-right">
                    <figure class="image tooltip tooltip-left">
                        <img class="x-small" src="{{ $participation->participationClass->event->sportType->icon }}"
                             alt="{{ trans('sport_types.' . $participation->participationClass->event->sportType->label) }}">
                        <span class="tooltip-text">{{ trans('sport_types.' . $participation->participationClass->event->sportType->label)}}</span>
                    </figure>
                </div>
            </div>

            <div class="content height-auto">
                <div class="columns">
                    <div class="column is-6">
                        <h5>Teilnahmeinformationen</h5>
                        <ul class="info-list">
                            <li title="{{ trans('label.participation_class') }}">
                                <icon icon="{{ config('icons.participation_class') }}"></icon>
                                <span>{{ $participation->participationClass->title }}</span>
                            </li>
                            <li title="{{ trans('label.starter_number') }}">
                                <icon icon="{{ config('icons.starter_number') }}"></icon>
                                <span>{{ $participation->starter_number }}</span>
                            </li>
                            <li title="Anmeldedatum">
                                <icon icon="{{ config('icons.date') }}"></icon>
                                <span>{{ dateDiffForHumans($participation->created_at) }}</span>
                            </li>
                            <li>
                                <icon icon="{{ config('icons.state') }}"></icon>
                                <span class="{{ getParticipationStatusClass($participation) }}">{{ trans('participation_states.' . $participation->status->label) }}</span>
                            </li>
                            @if(!$participation->trashed())
                                <li title="{{ trans('label.payment_status') }}">
                                    <icon icon="{{ config('icons.payment') }}"></icon>
                                    @if($participation->payment)
                                        <span class="is-success">Bezahlt</span>
                                    @else
                                        <span class="is-warning">Noch nicht bezahlt</span>
                                    @endif
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="column is-6">
                        <h5>Eventinformationen</h5>
                        <ul class="info-list">
                            <li title="{{ trans('label.registration_start') }}">
                                <icon icon="{{ config('icons.info') }}"></icon>
                                <span>{!! $participation->participationClass->event->getStatusText() !!}</span>
                            </li>
                            <li title="{{ trans('label.event_start_date') }}">
                                <icon icon="{{ config('icons.date') }}"></icon>
                                <span>{{ dateDiffForHumans($participation->participationClass->event->start_date) }}</span>
                            </li>
                            <li title="{{ trans('label.event_location') }}">
                                <icon icon="{{ config('icons.location') }}"></icon>
                                <span>{{ $participation->participationClass->event->getFullAddress() }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-extra">
                <small class="flex">
                    <icon icon="{{ config('icons.participants') }}" class="m-r-5"></icon>
                    <span>{{ trans_choice('param_label.num_of_participants', $participation->participationClass->event->getTotalNumOfParticipants(), ['num' => $participation->participationClass->event->getTotalNumOfParticipants()]) }}</span>
                </small>
                <div>
                    @if($participation->participationClass->event->hasFinished())
                        <span>{{ trans('label.rank_abbr') }}</span>
                        <span class="price is-success">{{ $participation->rank }}</span>
                    @else
                        <span>noch</span>
                        <span class="price is-success">{{ $participation->participationClass->start_date->diffInDays($now) }}
                            Tage</span>
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>