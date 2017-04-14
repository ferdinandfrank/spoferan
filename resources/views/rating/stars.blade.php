@if($rating)
    <div class="rating-stars {{ $class ?? '' }}">
        @for($i=1; $i <= 5; $i++)
            @if($i <= $rating)
                <icon icon="{{ config('icons.rating_star') }}"></icon>
            @elseif($i == round($rating))
                <icon icon="{{ config('icons.rating_star_half') }}"></icon>
            @else
                <icon icon="{{ config('icons.rating_star_empty') }}"></icon>
            @endif
        @endfor
    </div>
@endif