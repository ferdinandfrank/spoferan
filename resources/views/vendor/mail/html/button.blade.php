<table align="center" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td class="padding" height="30">&nbsp;</td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <div class="button button-{{ $color or 'success' }}">
                                        <!--[if mso]>
                                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"
                                                     style="height:40px;v-text-anchor:middle;width:200px;"
                                                     arcsize="10 %"
                                                     fillcolor="#47a447"
                                                     stroke="f" class="mso-button" href="{{ $url }}">
                                            <w:anchorlock/>
                                            <center>
                                        <![endif]-->
                                        <a href="{{ $url }}" target="_blank">
{{ $slot }}
                                        </a>
                                        <!--[if mso]>
                                        </center>
                                        </v:roundrect>
                                        <![endif]--></div>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="padding" height="30">&nbsp;</td>
    </tr>
</table>
