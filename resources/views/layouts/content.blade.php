@extends('layouts.main')

@section('body')
    @include('layouts.navbar')

    <div class="content">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <p>
                    &copy; {{ \Carbon\Carbon::now()->year }} <a href="http://spoferan.com">Spoferan</a>.
                </p>
                <p>
                    <a class="icon" href="https://www.facebook.com/spoferan">
                        <icon icon="{{ config('icons.facebook') }}"></icon>
                    </a>
                </p>
            </div>
        </div>
    </footer>
@endsection
