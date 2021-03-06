<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} @if(View::hasSection('title')) | @yield('title') @endif</title>

    {{-- CSS --}}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
@stack('css')

<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'stripeKey' => config('services.stripe.key'),
            'user' => auth()->user()
            ]); ?>;
    </script>
</head>
<body>
<div id="app" class="body">
    @yield('body')
</div>

<!-- Scripts -->
<script
        src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script src="{{ mix('/js/app.js') }}"></script>
@if(session('success'))
    <script>
        $(document).ready(function () {
            showAlert('success', '{{ session('success')['title'] }}', '{{ session('success')['content'] }}', 5000);
        });
    </script>
@endif
@stack('js')
</body>
</html>
