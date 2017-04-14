<div class="card {{ $class ?? '' }}">
    <a @if(isset($onClick)) v-on:click.prevent="{{ $onClick }}" @else href="{{ $link ?? $event->getPath() }}" @endif>
        <div class="card-header card-header-image">
            <div class="card-image" style="background-image: url({{ $event->cover }})"></div>
            @if($event->isMain())
                @include('rating.stars', ['rating' => $event->getRating()])
            @endif
            <div class="card-header-info toggle">
                <h1 class="title">{{ $hoverText ?? trans('action.show_event') }}</h1>
            </div>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-4" title="{{ $event->title }}">{{ $event->title }}</p>
                    <p class="subtitle is-6">{{ trans('param_label.by_name', ['name' => $event->organizer->user->getDisplayName()]) }}</p>
                </div>
                <div class="media-right">
                    <figure class="image tooltip tooltip-left">
                        <img class="x-small" src="{{ $event->sportType->icon }}"
                             alt="{{ trans('sport_types.' . $event->sportType->label) }}">
                        <span class="tooltip-text">{{ trans('sport_types.' . $event->sportType->label)}}</span>
                    </figure>
                </div>
            </div>

            <div class="content">
                <p class="description scroll">
                    {{ $event->description_short }}
                </p>
                <ul class="info-list">
                    <li title="{{ trans('label.registration_start') }}">
                        <icon icon="{{ config('icons.info') }}"></icon>
                        {!! $event->getStatusText() !!}
                    </li>
                    <li title="{{ trans('label.event_start_date') }}">
                        <icon icon="{{ config('icons.date') }}"></icon>
                        <span>{{ dateDiffForHumans($event->start_date) }}</span>
                    </li>
                    <li title="{{ trans('label.event_location') }}">
                        <icon icon="{{ config('icons.location') }}"></icon>
                        <span>{{ $event->getFullAddress() }}</span>
                    </li>
                </ul>
            </div>

            <div class="card-extra">
                <small class="flex">
                    <icon icon="{{ config('icons.participants') }}" class="m-r-5"></icon>
                    <span>{{ trans_choice('param_label.num_of_participants', $event->getTotalNumOfParticipants(), ['num' => $event->getTotalNumOfParticipants()]) }}</span>
                </small>
                <div>
                    <span>{{ trans('label.starting_at') }}</span>
                    <span class="price">{{ formatMoney($event->getLowestPrice()) }}</span>
                </div>
            </div>
        </div>
    </a>
</div>