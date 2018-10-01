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
    <link rel="shortcut icon" href="{{{ asset('images/favicon.png') }}}">
    @stack('styles')
    @routes
</head>
<body class="m-page--fluid m--skin m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--offcanvas m-aside-left--minimize m-brand--minimize m-footer--push m-aside--offcanvas-default">
<div class="m-grid m-grid--hor m-grid--root m-page">
    <header id="m_header" class="m-grid__item m-header " m-minimize="minimize" m-minimize-mobile="minimize" m-minimize-offset="200" m-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop  m-header__wrapper">
                {{-- BEGIN: Brand--}}
                <div class="m-stack__item m-brand m-brand--mobile">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="{{ route('home') }}" class="m-brand__logo-wrapper">
                                <img alt="" src="{{ asset('images/logo.png') }}"/>
                            </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                            {{-- BEGIN: Responsive Header Menu Toggler--}}
                            <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler">
                                <span></span>
                            </a>
                            {{-- END--}}
                            {{-- BEGIN: Topbar Toggler--}}
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon">
                                <i class="flaticon-more"></i>
                            </a>
                            {{--BEGIN: Topbar Toggler--}}
                        </div>
                    </div>
                </div>
                {{--END: Brand--}}
                <div class="m-stack__item m-stack__item--middle m-stack__item--left m-header-head" id="m_header_nav">
                    <div class="m-stack m-stack--ver m-stack--desktop">
                        <div class="m-stack__item m-stack__item--middle m-stack__item--fit">
                            {{--BEGIN: Brand--}}
                            <a href="{{ route('home') }}" class="m-brand m-brand--desktop">
                                <img alt="" src="{{ asset('images/logo.png') }}"/>
                            </a>
                            {{--END: Brand--}}
                        </div>
                        <div class="m-stack__item m-stack__item--fluid">
                            {{--BEGIN: Horizontal Menu--}}
                            <button class="m-aside-header-menu-mobile-close m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
                                <i class="la la-close"></i>
                            </button>
                            <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas m-header-menu--skin-light m-header-menu--submenu-skin-light
                            m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light ">
                                @include($layout . '.partials.horizontal_menu')
                            </div>
                            {{--END: Horizontal Menu--}}
                        </div>
                    </div>
                </div>
                <div class="m-stack__item m-stack__item--right">
                    {{--BEGIN: Topbar--}}
                    @include('layouts.partials.topbar')
                    {{--@include($layout . '.partials.topbar')--}}
                    {{--END: Topbar--}}
                </div>
            </div>
        </div>
    </header>
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--full-height">
            <div class="m-grid__item m-grid__item--fluid m-wrapper" id="app">
                @includeWhen($breadcrumbs, 'layouts.partials.breadcrumb', $breadcrumbs)
                <flash message="{{ session('message') }}"></flash>
                @yield('content')
            </div>
        </div>
    </div>
    <footer class="m-grid__item	m-footer">
        <div class="m-container m-container--fluid m-container--full-height m-page__container mt-0">
            <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-stack__item--center m-stack__item--middle m-stack__item--last">
                    <span class="m-footer__copyright">© 2018 <a href="http://www.cloudteam.vn/">Cloudteam Co., LTD</a>. All Rights Reserved.</span>
                </div>
            </div>
        </div>
    </footer>
    <div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light" style="">
        <div class="m-quick-sidebar__content">
            <span id="m_quick_sidebar_close" class="m-quick-sidebar__close"><i class="la la-close"></i></span>
            <ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_quick_sidebar_tabs_settings" role="tab" aria-selected="true">@lang('Settings')</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="m_quick_sidebar_tabs_settings" role="tabpanel">
                    <div class="tab-pane" id="m_quick_sidebar_tabs_settings" role="tabpanel">
                        <div class="m-list-settings m-scrollable">
                            <div class="m-list-settings__group">
                                <div class="m-list-settings__heading">@lang('General Settings')</div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">@lang('Layout')</span>
                                    <span class="m-list-settings__item-control">
                                        <select class="form-control" name="layout" title="Layout">
                                            <option value="default" selected="">@lang('Default')</option>
                                            <option value="horizontal_menu">@lang('Horizontal menu')</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="m_scroll_top" class="m-scroll-top"><i class="fa fa-arrow-up"></i></div>
    <div class="modal modal-wide fade modal-scroll" id="modal_lg" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal modal-wide fade modal-scroll" id="modal_md" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal modal-wide fade" id="modal_sm" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
</div>
{{--Scripts--}}
<script src="{{ route('lang') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset("$theme/js/merged.js") }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
