@extends('layouts.main')

@section('content')
    <div class="container">
        @component('components.breadcrumb')
        <li><a href="{{ route('participations.index') }}">{{ trans('label.my_participations') }}</a></li>
        @endcomponent
        <div class="card">

            <div class="card-content m-b-40">
                <section>
                    <div class="heading">
                        <h2 class="title">{{ trans('label.my_participations') }}</h2>
                        <p class="subtitle">{{ trans('descriptions.my_participations') }}</p>
                    </div>
                    <div class="content m-t-40">
                        <h3>Deine geplanten Eventteilnahmen</h3>
                        <div class="columns is-multiline">
                            @if(count($futureParticipations))
                                @foreach($futureParticipations as $futureParticipation)
                                    <div class="column">
                                        @include('participation.preview', ['participation' => $futureParticipation])
                                    </div>
                                @endforeach
                            @else
                                <p class="no-data">{{ trans('info.participation.no_future') }}</p>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="content m-t-40">
                        <h3>Deine vergangenen Eventteilnahmen</h3>
                        <div class="columns is-multiline">
                            @if(count($pastParticipations))
                                @foreach($pastParticipations as $pastParticipation)
                                    <div class="column">
                                        @include('participation.preview', ['participation' => $pastParticipation])
                                    </div>
                                @endforeach
                            @else
                                <p class="no-data">{{ trans('info.participation.no_past') }}</p>
                            @endif
                        </div>
                    </div>
                    @if(count($canceledParticipations))
                    <hr>
                        <div class="content m-t-40">
                            <h3>Deine stornierten Eventteilnahmen</h3>
                            <div class="columns is-multiline">
                                @foreach($canceledParticipations as $canceledParticipation)
                                    <div class="column">
                                        @include('participation.preview', ['participation' => $canceledParticipation])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app',
        });
    });
</script>
@endpush
