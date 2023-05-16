<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>{{config('app.name')}}</title>
    <style type="text/css">
        html {
            width: 100%;
        }

        ::-moz-selection {
            background: #7f6f9b;
            color: #ffffff;
        }

        ::selection {
            background: #7f6f9b;
            color: #ffffff;
        }

        body {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        a {
            /*color: #80cbd3;
            text-decoration:none;*/
            font-weight: normal;
            font-style: normal;
        }

        a:hover {
            color: #1b330c;
            /*text-decoration:underline;*/
            font-weight: normal;
            font-style: normal;
        }

        p, div {
            line-height: 20px;
            margin: 0 !important;
        }

        table {
            border-collapse: collapse;
        }

        td {
            padding-left: 5px;
        }

        .t-900 {
            font-weight: 900;
        }

        .padding-10 {
            padding: 10px;
        }

        .padding-right-5 {
            padding-right: 5px;
        }

        .no-margin-padding {
            margin: 0;
            padding: 0;
        }

        @media only screen and (max-width: 640px) {
            table table {
                width: 100% !important;
            }

            td[class="full_width"] {
                width: 100% !important;
            }

            div[class="div_scale"] {
                width: 440px !important;
                margin: 0 auto !important;
            }

            table[class="table_scale"] {
                width: 440px !important;
                margin: 0 auto !important;
            }

            td[class="td_scale"] {
                width: 440px !important;
                margin: 0 auto !important;
            }

            img[class="img_scale"] {
                width: 100% !important;
                height: auto !important;
            }

            img[class="divider"] {
                width: 440px !important;
                height: 2px !important;
            }

        }

        @media only screen and (max-width: 479px) {
            table table {
                width: 100% !important;
            }

            td[class="full_width"] {
                width: 100% !important;
            }

            div[class="div_scale"] {
                width: 280px !important;
                margin: 0 auto !important;
            }

            table[class="table_scale"] {
                width: 280px !important;
                margin: 0 auto !important;
            }

            td[class="td_scale"] {
                width: 280px !important;
                margin: 0 auto !important;
            }

            img[class="img_scale"] {
                width: 100% !important;
                height: auto !important;
            }

            img[class="divider"] {
                width: 280px !important;
                height: 2px !important;
            }
        }
    </style>


</head>
<body style="background-color: #1b330c;margin: 0;padding: 0;font-family: Arial, sans-serif;">
    <div style="padding: 20px 0px 0px 20px;">
        <img width="220" src="{{$message->embed(asset('img/logoLogin.png'))}}" />
    </div>
    @yield('content')
</body>
</html>


