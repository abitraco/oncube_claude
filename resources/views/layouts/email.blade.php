<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>@yield('title', 'ONCUBE GLOBAL')</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        table, td, div, h1, p {font-family: Arial, sans-serif;}
        @media screen and (max-width: 530px) {
            .unsub {
                display: block;
                padding: 8px;
                margin-top: 14px;
                border-radius: 6px;
                background-color: #555555;
                text-decoration: none !important;
                font-weight: bold;
            }
            .col-lge {
                max-width: 100% !important;
            }
        }
        @media screen and (min-width: 531px) {
            .col-sml {
                max-width: 27% !important;
            }
            .col-lge {
                max-width: 73% !important;
            }
        }
    </style>
</head>
<body style="margin:0;padding:0;word-spacing:normal;background-color:#f4f6f9;">
    <div role="article" aria-roledescription="email" lang="en" style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#f4f6f9;">
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td align="center" style="padding:20px 0;">
                    <!--[if mso]>
                    <table role="presentation" align="center" style="width:600px;">
                    <tr>
                    <td>
                    <![endif]-->
                    <table role="presentation" style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
                        <!-- Header -->
                        <tr>
                            <td style="padding:30px;text-align:center;font-size:24px;font-weight:bold;background-color:#002748;color:#ffffff;border-radius:8px 8px 0 0;">
                                <img src="https://via.placeholder.com/150x50/002748/ffffff?text=ONCUBE+GLOBAL" alt="ONCUBE GLOBAL" width="150" style="width:150px;max-width:80%;height:auto;border:none;text-decoration:none;color:#ffffff;">
                                <div style="margin-top:10px;font-size:14px;font-weight:normal;opacity:0.9;">Industrial & Semiconductor Equipment</div>
                            </td>
                        </tr>
                        
                        <!-- Content -->
                        <tr>
                            <td style="padding:30px;background-color:#ffffff;border-bottom:1px solid #e0e0e0;">
                                @yield('content')
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td style="padding:30px;text-align:center;font-size:12px;background-color:#ffffff;color:#666666;border-radius:0 0 8px 8px;">
                                <p style="margin:0 0 10px 0;">
                                    <strong>ONCUBE GLOBAL</strong><br>
                                    Industrial & Semiconductor Equipment Distribution<br>
                                    License: 416-19-94501 | Tel: +82-10-4846-0846
                                </p>
                                <p style="margin:0;font-size:11px;color:#999999;">
                                    &copy; {{ date('Y') }} ONCUBE GLOBAL. All rights reserved.<br>
                                    This is an automated message, please do not reply directly.
                                </p>
                            </td>
                        </tr>
                    </table>
                    <!--[if mso]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
