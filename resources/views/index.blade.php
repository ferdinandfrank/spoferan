@extends('layouts.content')

@section('content')
    <div class="container">
        <div class="tile is-ancestor">
            <div class="tile is-parent is-6">
                <div class="card tile is-child">
                    <a href="{{ route('events.index') }}">
                        <div class="card-header card-header-image">
                            <div class="card-image" style="background-image: url({{ asset('images/events.jpg') }})"></div>
                            <div class="card-header-info">
                                <icon icon="{{ config('icons.event') }}"></icon>
                                <h1 class="title">{{ trans('action.find_event') }}</h1>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="tile is-vertical">
                <div class="tile">
                    <div class="tile is-parent">
                        <div class="card tile is-child disabled" title="{{ trans('info.not_available_yet') }}">
                            <a>
                                <div class="card-header card-header-image">
                                    <div class="card-image"
                                         style="background-image: url({{ asset('images/statistics.jpg') }})"></div>
                                    <div class="card-header-info">
                                        <icon icon="{{ config('icons.statistics') }}"></icon>
                                        <h1 class="title">{{ trans('label.statistics') }}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="tile is-parent is-vertical">
                        @if($loggedUser)
                            <div class="card tile is-child disabled" title="{{ trans('info.not_available_yet') }}">
                                <a href="#">
                                    <div class="card-header card-header-image">
                                        <div class="card-image"
                                             style="background-image: url({{ $loggedUser->avatar }})"></div>
                                        <div class="card-header-info">
                                            <icon icon="{{ config('icons.user') }}"></icon>
                                            <h1 class="title">{{ $loggedUser->getDisplayName() }}</h1>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @else
                            <div class="card tile is-child">
                                <a href="{{ route('login') }}">
                                    <div class="card-header card-header-image">
                                        <div class="card-image"
                                             style="background-image: url({{ asset('images/login.jpg') }})"></div>
                                        <div class="card-header-info">
                                            <icon icon="{{ config('icons.user') }}"></icon>
                                            <h1 class="title">{{ trans('action.login') }}</h1>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="tile">
                    @if($loggedUser)
                    <div class="tile is-parent">
                        <div class="card tile is-child">
                            <a href="{{ route('participations.index') }}">
                                <div class="card-header card-header-image">
                                    <div class="card-image" style="background-image: url({{ asset('images/participation.jpg') }})"></div>
                                    <div class="card-header-info">
                                        <icon icon="{{ config('icons.participate') }}"></icon>
                                        <h1  class="title">{{ trans('label.my_participations') }}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    <div class="tile is-parent">
                        <div class="card tile is-child disabled" title="{{ trans('info.not_available_yet') }}">
                            <a >
                                <div class="card-header card-header-image">
                                    <div class="card-image" style="background-image: url({{ asset('images/club.jpg') }})"></div>
                                    <div class="card-header-info">
                                        <icon icon="{{ config('icons.club') }}"></icon>
                                        <h1  class="title">{{ trans('label.clubs') }}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <section class="section">
            <div class="heading">
                <h2 class="title">{{ trans('label.event_recommendations') }}</h2>
                <p class="subtitle">{{ trans('descriptions.event.recommendations') }}</p>
            </div>
            <div class="content">
                @if(count($events))
                <slider>
                    @foreach($events as $event)
                        @include('event.preview')
                    @endforeach
                </slider>
                    @else
                    <p class="no-data">Bisher gibt es keine Events, die auf dein Profil passen würden.</p>
                @endif
            </div>
        </section>

    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app'
        });
    });
</script>
@endpush
