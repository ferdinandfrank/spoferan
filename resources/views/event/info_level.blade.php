<nav class="level">
    <div class="level-item has-text-centered">
        <div>
            <img class="avatar auto" src="{{ $event->organizer->user->avatar }}" alt="{{ $event->organizer->getDisplayName() }}" >
            <p class="heading">{{ trans('label.user_type.organizer') }}</p>
            <p class="title">{{ $event->organizer->getDisplayName() }}</p>
        </div>
    </div>
    <div class="level-item has-text-centered">
        <div>
            <img src="{{ $event->sportType->icon }}" alt="{{ trans('sport_types.' . $event->sportType->label) }}" >
            <p class="heading">{{ trans('label.sport_type') }}</p>
            <p class="title">{{ trans('sport_types.' . $event->sportType->label) }}</p>
        </div>
    </div>
    <div class="level-item has-text-centered">
        <div>
            <time datetime="{{ $event->start_date->toDateTimeString() }}" class="calendar margin-auto">
                <span class="year">{{ $event->start_date->year }}</span>
                <span class="day">{{ $event->start_date->day }}</span>
                <span class="month">{{ $event->start_date->formatLocalized('%b') }}</span>
            </time>
            <p class="heading">{{ trans('label.event_start_date') }}</p>
            <p class="title">{{ dateDiffForHumans($event->start_date) }}</p>
        </div>
    </div>
    <div class="level-item has-text-centered">
        <div>
            <img src="{{ getCountryFlag($event->country) }}" alt="{{ trans('countries.' . $event->country) }}" >
            <p class="heading">{{ trans('label.event_location') }}</p>
            <p class="title">{{ $event->getFullAddress() }}</p>
        </div>
    </div>
</nav>