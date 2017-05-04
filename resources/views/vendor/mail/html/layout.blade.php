<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <style type="text/css">
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
<p style="display:none !important; visibility:hidden; opacity:0; color:transparent; height:0; width:0; mso-hide:all; line-height:0; font-size:0">{{ $title or '' }}</p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td>

            {{ $header or '' }}

            <table class="content" border="0" cellpadding="0" cellspacing="0"
                   width="100%">
                <tbody>
                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0"
                               cellspacing="0">
                            <!-- Body content -->
                            <tr>
                                <td class="padding" height="20">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="padding" width="20">&nbsp;</td>
                                <td>
                                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                                </td>
                                <td class="padding" width="20">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="padding" height="20">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

        {{ $help or '' }}

        {{ $footer or '' }}

        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
