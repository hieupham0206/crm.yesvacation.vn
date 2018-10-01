<!--suppress HtmlUnknownAttribute, JSUnresolvedLibraryURL --><!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <!-- Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <!--suppress JSUnresolvedVariable -->
    <script>
		WebFont.load({
			google: {'families': ['Montserrat:300,400,500,600,700']},
			active: function() {
				sessionStorage.fonts = true
			},
		})
    </script>
    <!-- Styles -->
    <link href="{{ asset("$theme/css/merged.css") }}" rel="stylesheet">
    <link href="{{ asset("$theme/css/app.css") }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="m-page--fluid m--skin m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-aside-left--minimize m-brand--minimize m-footer--push m-aside--offcanvas-default">
<div class="m-grid m-grid--hor m-grid--root m-page" id="app">
    {{--BEGIN: Header--}}
    <header id="m_header" class="m-grid__item m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">
                {{--BEGIN: Brand--}}
                <div class="m-stack__item m-brand  m-brand--skin-dark ">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="{{ route('home') }}" class="m-brand__logo-wrapper">
                                <img alt="" src="{{ asset('images/logo.png') }}"/>
                            </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                            {{--BEGIN: Left Aside Minimize Toggle--}}
                            <a href="javascript:void(0)" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                                <span></span>
                            </a>
                            {{--END--}}
                            {{--BEGIN: Responsive Aside Left Menu Toggler--}}
                            <a href="javascript:void(0)" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>
                            {{--END--}}
                            {{--BEGIN: Topbar Toggler--}}
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>
                            {{--BEGIN: Topbar Toggler--}}
                        </div>
                    </div>
                </div>
                {{--END: Brand--}}
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                    {{--BEGIN: Horizontal Menu--}}
                    <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark
                    m-aside-header-menu-mobile--submenu-skin-dark">
                        {{--todo: thêm menu ngang--}}
                    </div>
                    {{--END: Horizontal Menu--}}
                </div>
            </div>
        </div>
    </header>
    {{--END: Header--}}
    {{--begin::Body--}}
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        {{--BEGIN: Left Aside--}}
        @include($layout . '.partials.vertical_menu')
        {{--END: Left Aside--}}
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-container--full-height">
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
    {{--end:: Body--}}

    {{--begin::Scroll Top--}}
    <div id="m_scroll_top" class="m-scroll-top"><i class="la la-arrow-up"></i></div>
    {{--end::Scroll Top--}}

    {{--begin::Footer--}}
    <footer class="m-grid__item	m-footer ">
        <div class="m-container m-container--fluid m-container--full-height m-page__container mt-0">
            <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-stack__item--center m-stack__item--middle m-stack__item--last">
                    <span class="m-footer__copyright">© @php echo date('Y') @endphp <a href="http://www.cloudteam.vn/">Cloudteam Co., LTD</a>. All Rights Reserved.</span>
                </div>
            </div>
        </div>
    </footer>
    {{--end:: Footer--}}
</div>
<!-- Scripts -->
<script src="{{ route('lang') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset("$theme/js/merged.js") }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
