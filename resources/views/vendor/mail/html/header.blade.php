<table style="background-color: #008200;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td align="center" style="border: 0; margin: 0; padding: 0;">

            <!-- preheader -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td align="center" style="border: 0; margin: 0; padding: 0;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="width"
                               width="500">
                            <tbody>
                            <tr>
                                <td align="center" height="20"
                                    style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #008200; font-family: 'Folks', Helvetica, Arial, sans-serif;">
                                    {{ $title or '' }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- /preheader -->

            <!-- banner -->
            <table border="0" cellpadding="0" cellspacing="0" class="width" width="500">
                <tbody>
                <tr>
                    <td height="7"
                        style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                        width="100%">
                        <div class="clear" style="height: 7px; width: 1px;">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td class="banner"
                        style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                        valign="middle">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                            <tr>
                                <td class="perm-padding"
                                    style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                    width="20">
                                    <div class="clear" style="height: 1px; width: 20px;"></div>
                                </td>
                                <td style="border: 0; margin: 0; padding: 0;" width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td align="center" class="icon"
                                                style="border: 0; margin: 0; padding: 0;">
                                                <a href="{{ route('index') }}"
                                                   style="border: 0; margin: 0; padding: 0;" target="_blank"
                                                   rel="noreferrer">
                                                              <span class="retina">
                                                                <img alt=""
                                                                     src="{{ url(Settings::favicon()) }}"
                                                                     style="border: 3px solid #fff; border-radius: 50%; margin: 0; padding: 0;" width="72" height="72">
                                                              </span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="22"
                                                style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                                width="100%">
                                                <div class="clear" style="height: 22px; width: 1px;">
                                                    &nbsp;
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" class="title"
                                                style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #ffffff; text-shadow: 0 1px 1px #007500;">
                                                <a href=""
                                                   style="color: #ffffff; font-family: 'Folks', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 25px; text-decoration: none;"
                                                   target="_blank" rel="noreferrer"><span
                                                            class="apple-override-header"
                                                            style="color: #ffffff; font-family: 'Xirod', Helvetica, Arial, sans-serif; font-size: 24px; line-height: 25px; text-decoration: none;">{{ Settings::title() }}</span></a>
                                            </td>
                                        </tr>

                                        <!-- card -->
                                        <tr>
                                            <td height="13"
                                                style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                                width="100%">
                                                <div class="clear" style="height: 13px; width: 1px;">
                                                    &nbsp;
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" height="1"
                                                style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                                width="100%">
                                                <table align="center" border="0" cellpadding="0"
                                                       cellspacing="0" width="200">
                                                    <tbody>
                                                    <tr>
                                                        <td bgcolor="#007500"
                                                            style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                                                            <div class="clear"
                                                                 style="height: 1px; width: 200px;">&nbsp;
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="18"
                                                style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                                width="100%">
                                                <div class="clear" style="height: 18px; width: 1px;">
                                                    &nbsp;
                                                </div>
                                            </td>
                                        </tr>
                                        @if(isset($title))
                                        <tr>
                                            <td align="center"
                                                style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                                width="100%">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                       class="card card-visa">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" class="subtitle"
                                                            style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #ffffff; text-shadow: 0 1px 1px #007500;">
                                                                        <span class="apple-override-header"
                                                                              style="color: #ffffff; font-family: 'Folks', Helvetica, Arial, sans-serif; font-size: 20px; line-height: 22px;">{{ $title }}</span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </td>
                                        </tr>
                                        @endif
                                        <!-- /card -->

                                        </tbody>
                                    </table>
                                </td>
                                <td class="perm-padding"
                                    style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                    width="20">
                                    <div class="clear" style="height: 1px; width: 20px;"></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="27"
                        style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                        width="100%">
                        <div class="clear" style="height: 27px; width: 1px;">&nbsp;</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- /banner -->

            @if($subtitle)
            <!-- subbanner -->
            <table bgcolor="#007500" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td align="center"
                        style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                        <table class="width" border="0" cellpadding="0" cellspacing="0" width="500">
                            <tbody>
                            <tr>
                                <td colspan="4" height="8"
                                    style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                    width="100%">
                                    <div class="clear" style="height: 8px; width: 1px;">&nbsp;</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="perm-padding"
                                    style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                    width="20">
                                    <div class="clear" style="height: 1px 20px;"></div>
                                </td>
                                <td align="center" class="subbanner-item font-small"
                                    style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #ffffff; font-family: 'Folks', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 17px; text-shadow: 0 1px 1px #007500;"
                                    width="230">
                                    <span class="apple-override-header"
                                          style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #ffffff; font-family: 'Folks', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 17px; text-shadow: 0 1px 1px #007500;">
                                        {{ $subtitle }}
                                </td>
                                <td class="perm-padding"
                                    style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                    width="20">
                                    <div class="clear" style="height: 1px 20px;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" height="8"
                                    style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;"
                                    width="100%">
                                    <div class="clear" style="height: 8px; width: 1px;">&nbsp;</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- /subbanner -->
            @endif
        </td>
    </tr>
    </tbody>
</table>