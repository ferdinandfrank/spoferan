@foreach($event->participationClasses as $participationClass)
    @if($participationClass->canParticipate())
        <div id="{{ $participationClass->getRouteKey() }}" class="column {{ $size ?? '' }}">
            @include('participation_class.preview', [
            'actionText' => trans('action.select_participation_class'),
            'onClick' => "emit('element_selected', '". $participationClass->getRouteKey(). "', '".$participationClass->title."')",
            'class' => isset($selectedParticipationClass) && $selectedParticipationClass->getKey() == $participationClass->getKey() ? 'selected' : ''
            ])
        </div>
    @endif
@endforeach