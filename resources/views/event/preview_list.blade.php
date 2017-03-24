<div id="event-preview-list" class="columns is-multiline">
    @if(count($events))
        @foreach($events as $event)
            <div class="column is-4">
                @include('event.preview')
            </div>
        @endforeach
    @else
        <p class="no-data">{{ trans('info.event.no_results') }}</p>
    @endif
</div>