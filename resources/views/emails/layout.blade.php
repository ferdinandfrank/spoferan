<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #f2f2f2;
            font-family: 'Folks', Helvetica, sans-serif;
            color: #555;
        }

        h1 {
            font-size: 1.6rem !important;
        }

        h2 {
            font-size: 1.4rem !important;
        }

        h3 {
            font-size: 1.2rem !important;
        }

        h4 {
            font-size: 1.0rem !important;
        }

        p {
            color: #74787E !important;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid lightgray;
        }

        .logo {
            width: 150px;
        }

        .content {
            margin: 20px 0;
        }

        .extra {
            text-align: center;
            margin-top: 10px;
            border-top: 1px solid lightgray;
        }

        .extra p {
            font-size: 0.7rem;
        }

        .footer p {
            text-align: left !important;
            font-size: 1rem !important;
        }

        .left-align {
            text-align: left !important;
        }

        .right-align {
            text-align: right !important;
        }

        .justify {
            text-align: justify !important;
        }

        .center, .center-align, .text-center {
            text-align: center !important;
        }

        .left {
            float: left !important;
        }

        .right {
            float: right !important;
        }

        .btn-group {
            margin: 40px 0;
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            background-color: #f0820a;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
        }

        .x-large {
            font-size: 1.5rem !important;
        }

        .large {
            font-size: 1.2rem !important;
        }

        .normal {
            font-size: 1.0rem !important;
        }

        .small {
            font-size: 0.8rem !important;
        }

        .x-small {
            font-size: 0.6rem !important;
        }

        .btn-success {
            background-color: #47a447;
        }

        .btn-warning {
            background-color: #ed9c28;
        }

        .btn-error {
            background-color: #d2322d;
        }

        .primary {
            color: #008200 !important; }

        .secondary {
            color: #f0820a !important; }

        .success {
            color: #47a447 !important; }

        .warning {
            color: #ed9c28 !important; }

        .error {
            color: #d2322d !important; }

        .info {
            color: #f0820a !important; }

    </style>
</head>

<body>
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0">

                <!-- Email Body -->
                <tr>
                    <td width="100%">
                        <table align="center" width="570" cellpadding="0"
                               cellspacing="0">
                            <tr>
                                <td>
                                    <div class="header">
                                        <img class="logo" width="150" src="{{ url(Settings::logo()) }}"/>
                                    </div>
                                    <div class="content">
                                        @yield('content')
                                    </div>

                                    @section('footer')
                                    <div class="footer">
                                        <p>
                                            {{ trans('email.salutation') }}<br>{{ Settings::title() }}
                                        </p>
                                    </div>
                                    @show

                                    <div class="extra">
                                        @yield('extra')
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
