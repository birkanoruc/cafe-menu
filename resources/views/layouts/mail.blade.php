<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>İŞLETME MENÜLERİM</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            min-width: 100% !important;
        }

        img {
            height: auto;
        }

        .content {
            width: 100%;
            max-width: 600px;
        }

        .header {
            padding: 40px 30px 20px 30px;
        }

        .innerpadding {
            padding: 30px 30px 30px 30px;
        }

        .borderbottom {
            border-bottom: 1px solid #f2eeed;
        }

        .subhead {
            font-size: 15px;
            color: #ffffff;
            font-family: sans-serif;
            letter-spacing: 10px;
        }

        .h1 {
            color: white;
            font-family: sans-serif;
        }

        .h2,
        .bodycopy {
            color: #153643;
            font-family: sans-serif;
        }

        .h1 {
            font-size: 33px;
            line-height: 38px;
            font-weight: bold;
        }

        .h2 {
            padding: 0 0 15px 0;
            font-size: 24px;
            line-height: 28px;
            font-weight: bold;
        }

        .bodycopy {
            font-size: 16px;
            line-height: 22px;
        }

        .button {
            text-align: center;
            font-size: 18px;
            font-family: sans-serif;
            font-weight: bold;
            padding: 0 30px 0 30px;
        }

        .button a {
            color: #ffffff;
            text-decoration: none;
        }

        .footer {
            padding: 20px 30px 15px 30px;
            background-color: black;
        }

        .footercopy {
            font-family: sans-serif;
            font-size: 14px;
            color: #ffffff;
        }

        .footercopy a {
            color: #ffffff;
            text-decoration: underline;
        }

        @media only screen and (max-width: 550px),
        screen and (max-device-width: 550px) {
            body[yahoo] .hide {
                display: none !important;
            }

            body[yahoo] .buttonwrapper {
                background-color: transparent !important;
            }

            body[yahoo] .button {
                padding: 0px !important;
            }

            body[yahoo] .button a {
                background-color: #e05443;
                padding: 15px 15px 13px !important;
            }

            body[yahoo] .unsubscribe {
                display: block;
                margin-top: 20px;
                padding: 10px 50px;
                background: #2f3942;
                border-radius: 5px;
                text-decoration: none !important;
                font-weight: bold;
            }
        }
    </style>
</head>

<body yahoo bgcolor="#f6f8f1">
    <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td bgcolor="black" class="header">
                            <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td height="70" style="padding: 0 20px 20px 0;">
                                        <img class="fix"
                                            src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                                            width="70" height="70" border="0" alt="" />
                                    </td>
                                </tr>
                            </table>
                            <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0"
                                style="width: 100%; max-width: 425px;">
                                <tr>
                                    <td height="70">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="subhead" style="padding: 0 0 0 3px;">
                                                    İŞLETME
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="h1" style="padding: 5px 0 0 0;">
                                                    MENÜLERİM
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    {{ $slot }}
                    <tr>
                        <td class="footer" bgcolor="black">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" class="footercopy">
                                        &reg; Tüm hakları gizlidir.<br />
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
