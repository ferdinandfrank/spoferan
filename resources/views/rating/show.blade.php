<div class="rating">
    <div class="rating-heading">
        @if(!($rater->pivot->privacy || $rater->privacy))
            <img src="{{ $rater->athlete->user->avatar }}" class="avatar small">
        @endif
        <div class="rating-info">
            @include('rating.stars', ['rating' => $rater->pivot->rating])
            <h6 class="title">{!! $rater->getAthletePresentationName($rater->pivot->privacy) !!}</h6>
            @if($rater->rank)
            <small class="is-success">Platz {{ $rater->rank }} der Teilnahmeklasse {{ $rater->participationClass->title }}</small>
                @else
            <small class="is-success">Teilnehmer der Teilnahmeklasse {{ $rater->participationClass->title }}</small>
            @endif
        </div>
    </div>
    @if($rater->pivot->description)
        <p>{{ $rater->pivot->description }}</p>
    @endif
</div>