@include('base-header')
<div style="background:#ffffff;Margin:0 auto;max-width:600px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
           style="background:#ffffff;width:100%;">
        <tbody>
        <tr>
            <td style="direction:ltr;font-size:0px;padding:20px;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="vertical-align:top;width:560px;">
                <![endif]-->
                <div class="mj-column-per-100 outlook-group-fix"
                     style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                           style="vertical-align:top;" width="100%">
                        <tr>
                            <td align="left" style="font-size:0;padding:10px 25px;word-break:break-word;">
                                <div
                                    style="font-family:Helvetica,serif;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                    <h1>
                                        {{ __('email.magic-link.body_title') }}
                                    </h1>
                                    {{ __('email.magic-link.body_text') }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="word-wrap:break-word;font-size:0;padding:10px 25px;" align="left">
                                <div>
                                    <!--[if mso]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $url }}" style="height:55px;v-text-anchor:middle;width:226px;" stroke="f" fillcolor="#90bf48"><w:anchorlock/><center>
                                    <![endif]-->
                                    <a href="{{ $url }}"
                                       style="background-color:#a9a9a9;color:#ffffff;display:inline-block;font-family:'Helvetica',serif;font-size:13px;font-weight:bold;line-height:55px;text-align:center;text-decoration:none;width:226px;-webkit-text-size-adjust:none;text-transform:uppercase;">
                                        {{ __('email.magic-link.button_text') }}
                                    </a>
                                    <!--[if mso]>
                                    </center>
                                    </v:rect>
                                    <![endif]-->
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" style="font-size:0;padding:0 25px 10px;word-break:break-word;">
                                <div
                                    style="font-family:Helvetica,serif;font-size:13px;line-height:1;text-align:left;color:#000000;"> {{ __('email.magic-link.body_bottom_text') }} </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!--[if mso | IE]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
</div>
@include('base-footer')

