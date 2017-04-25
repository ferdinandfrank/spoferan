<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css">
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
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

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td style="border: 0; margin: 0; padding: 0;">

                <!-- header -->
                {{ $header or '' }}
                <!-- /header -->

                <table bgcolor="ffffff" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #e4e6e8;"
                       width="100%">
                    <tbody>
                    <tr>
                        <td align="center" style="border: 0; margin: 0; padding: 0;">
                            <table border="0" cellpadding="0" cellspacing="0" class="width" width="500">
                                <tbody>
                                <tr>
                                    <td class="temp-padding"
                                        style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; font-size: 1px; line-height: 1px;">
                                        <div class="clear" style="height: 1px; width: 20px;"></div>
                                    </td>
                                    <td style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; font-size: 1px; line-height: 1px;"
                                        width="460">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>

                                            <!-- Email Body -->
                                            <tr>
                                                <td class="body" width="100%" cellpadding="0" cellspacing="0">
                                                    <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                                                        <!-- Body content -->
                                                        <tr>
                                                            <td class="content-cell">
                                                                {{ Illuminate\Mail\Markdown::parse($slot) }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="5" height="20"
                                                    style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                                                    <div class="clear" style="height: 12px; width: 1px;">&nbsp;</div>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="temp-padding"
                                        style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; font-size: 1px; line-height: 1px;">
                                        <div class="clear" style="height: 1px; width: 20px;"></div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- help -->
                {{ $help or '' }}
                <!-- /help -->

                <!-- footer -->
                {{ $footer or '' }}
                <!-- /footer -->

            </td>
        </tr>
        </tbody>
    </table>
</body>
</html>
