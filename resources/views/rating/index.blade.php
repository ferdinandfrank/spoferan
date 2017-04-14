@if(count($event->raters))
    @foreach($event->raters as $rater)
        @include('rating.show')
    @endforeach
@elseif(!$event->hasFinished() && $event->preEvent && count($event->preEvent->raters))
    @foreach($event->preEvent->raters as $rater)
        @include('rating.show')
    @endforeach
@else
    @if($event->hasFinished())
        <p class="muted">{{ trans('info.event.no_ratings') }}</p>
    @else
        <p class="muted">{{ trans('info.event.no_ratings_not_started') }}</p>
    @endif
@endif