<div class="card">
    <a href="{{ $event->getPath() }}">
        <div class="card-header">
            <div class="card-image" style="background-image: url({{ $event->cover }})"></div>
            <div class="card-header-info toggle">
                <h1 class="title">{{ $hoverText ?? trans('action.show_event') }}</h1>
            </div>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-4">{{ $event->title }}</p>
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
                    <li>
                        <icon icon="{{ config('icons.date') }}"></icon>
                        <span>{{ dateDiffForHumans($event->start_date) }}</span>
                    </li>
                    <li>
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
                    <span class="price">{{ $event->getLowestPrice() }} €</span>
                </div>
            </div>
        </div>
    </a>
</div>