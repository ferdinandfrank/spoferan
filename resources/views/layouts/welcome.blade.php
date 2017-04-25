@extends('layouts.main')

@section('body')
    @include('layouts.navbar')

    <div class="content welcome" style="background: url({{ asset('images/bg3.jpg') }})">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <p>
                    &copy; {{ \Carbon\Carbon::now()->year }} <a href="http://spoferan.com">{{ Settings::title() }}</a>.
                </p>
                @if(Settings::facebook())
                    <p>
                        <a class="icon" href="{{ Settings::facebook() }}">
                            <icon icon="{{ config('icons.facebook') }}"></icon>
                        </a>
                    </p>
                @endif
            </div>
        </div>
    </footer>
@endsection
