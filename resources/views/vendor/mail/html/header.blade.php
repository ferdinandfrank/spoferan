<table class="header" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td align="center">

            <!-- banner -->
            <table border="0" cellpadding="0" cellspacing="0" class="width" width="500">
                <tbody>
                <tr>
                    <td valign="middle">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                            <tbody>
                            <tr>
                                <td class="padding" width="20">&nbsp;</td>
                                <td class="padding" width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td align="center" class="logo">
                                                <a href="{{ route('index') }}" target="_blank" rel="noreferrer">
                                                    <img alt="" src="{{ url(Settings::favicon()) }}" width="72"
                                                         height="72">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="padding" height="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <a href="{{ route('index') }}" class="brand-name" target="_blank"
                                                   rel="noreferrer">{{ Settings::title() }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="padding" height="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="200">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" class="separator">&nbsp;</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="padding" height="10">&nbsp;</td>
                                        </tr>
                                        @if(isset($title))
                                            <tr>
                                                <td align="center">
                                                    <span class="title">{{ $title ?? '' }}</span>
                                                </td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </td>
                                <td class="padding" width="20">&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="padding" height="20">&nbsp;</td>
                </tr>
                </tbody>
            </table>

            @if($subtitle)
                <table class="sub-header" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td align="center">
                            <table border="0" cellpadding="0" cellspacing="0" width="500">
                                <tbody>
                                <tr>
                                    <td class="padding" height="10">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <span class="subtitle">{{ $subtitle }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="padding" height="10">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            @endif
        </td>
    </tr>
    </tbody>
</table>