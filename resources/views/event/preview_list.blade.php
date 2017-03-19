<div id="event-preview-list" class="columns is-multiline">
    @foreach($events as $event)
        <div class="column is-4">
            @include('event.preview')
        </div>
    @endforeach
</div>