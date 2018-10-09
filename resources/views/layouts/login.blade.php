<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600" rel="stylesheet" type="text/css">
    <title>@yield('title', __('Sign in'))</title>
    <!-- Styles -->
    <link href="{{ asset("$theme/css/merged.css") }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login">
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class="m-portlet">
                <div class="m-portlet__body">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- begin::Footer -->
        {{--<footer class="m-grid__item	m-footer ml-0">--}}
            {{--<div class="m-container m-container--fluid m-container--full-height m-page__container mt-0">--}}
                {{--<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">--}}
                    {{--<div class="m-stack__item m-stack__item--center m-stack__item--middle m-stack__item--last">--}}
                        {{--<span class="m-footer__copyright">--}}
                            {{--© @php echo date('Y') @endphp <a class="m-font-accent" href="http://www.cloudteam.vn/">Cloudteam Co., LTD</a>. All Rights Reserved.--}}
                        {{--</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</footer>--}}
        <!-- end:: Footer -->
    </div>
</div>
<!-- end:: Page -->
<!-- Scripts -->
<script src="{{ asset('js/bootstrap.js') }}"></script>
@stack('scripts')
</body>
</html>
