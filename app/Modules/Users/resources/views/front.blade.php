<!DOCTYPE html>
<!--[if IE 8]>
<html lang="bn" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="bn" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="bn" class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>One Stop Service platform for Ease of doing business in Bangladesh</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ config('app.project_name') }}" />
    <meta name="keywords" content="OSS framework">
    <meta name="description"
          content="One Stop Service is an online platform integrating relevant Government agencies for providing efficient and transparent
            services to domestic and foreign investors" />

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <!-- Fav icon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="stylesheet"  href="{{ mix('css/front.css') }}">
    <link rel="stylesheet"  href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />

    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

        * {
            font-size: 14px;
        }

        body {
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f5f8fa;
        }

        .navbar-laravel {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
        }

        .navbar-brand,
        .nav-link,
        .my-form,
        .login-form {
            font-family: Raleway, sans-serif;
        }

        .my-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .my-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .login-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .login-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .carousel-inner img {
            width: 100%;
            height: 100%;
        }
    </style>

    @yield('header-resources')
    <script   type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script   type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script defer type="text/javascript" src="{{ mix('plugins/home_page.min.js') }}"></script>
</head>

<body class="">
{{ csrf_field() }}
@include('frontend.partials.header')

@yield('body')

@include('frontend.partials.footer')


@yield('footer-script')

<script>
    function languageSwitch(status) {
        console.log(status);
        let lang = 'bn';
        if (status) {
            lang = 'bn'
        } else {
            lang = 'en';
        }
        const lang_url = '{{ url('lang') }}' + '/' + lang;
        $(location).attr('href', lang_url)
    }
</script>
</body>

</html>
