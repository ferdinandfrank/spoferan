@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="tile is-ancestor">
            <div class="tile is-parent is-6">
                <div class="card tile is-child">
                    <a href="#">
                        <div class="card-header">
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
                        <div class="card tile is-child">
                            <a href="{{ route('login') }}">
                                <div class="card-header">
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
                            <div class="card tile is-child">
                                <a href="#">
                                    <div class="card-header">
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
                                    <div class="card-header">
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
                <div class="tile is-parent">
                    <div class="card tile is-child">
                        <a href="#">
                            <div class="card-header">
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

        <hr>

        <div class="columns is-multiline">
            @foreach($events as $event)
                <div class="column is-4">
                    @include('event.preview')
                </div>
            @endforeach
        </div>

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
