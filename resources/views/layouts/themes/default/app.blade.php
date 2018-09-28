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
<body class="m-page--fluid m--skin m-content--skin-light2 m-header--fixed m-aside-left--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<div class="m-grid m-grid--hor m-grid--root m-page">
    {{--BEGIN: Header--}}
    <header id="m_header" class="m-grid__item m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">
                {{--BEGIN: Brand--}}
                <div class="m-stack__item m-brand  m-brand--skin-light">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="{{ route('home') }}" class="m-brand__logo-wrapper">
                                <img alt="" src="{{ asset('images/logo.png') }}" style="max-width: 140px; height: auto"/>
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
                    <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light
                    m-aside-header-menu-mobile--submenu-skin-light">
                        {{--todo: thêm menu ngang--}}
                    </div>
                    {{--END: Horizontal Menu--}}

                    {{--BEGIN: Topbar--}}
                    @include('layouts.partials.topbar')
                    {{--END: Topbar--}}
                </div>
            </div>
        </div>
    </header>
    {{--END: Header--}}
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        {{--BEGIN: Left Aside--}}
        @include($layout . '.partials.vertical_menu')
        {{--END: Left Aside--}}
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-container--full-height">
            <div class="m-grid__item m-grid__item--fluid m-wrapper" id="app">
                @includeWhen($breadcrumbs, 'layouts.partials.breadcrumb', $breadcrumbs)
                <flash message="{{ session('message') }}"></flash>
                @yield('content')
            </div>
        </div>
    </div>
    <footer class="m-grid__item	m-footer ">
        <div class="m-container m-container--fluid m-container--full-height m-page__container mt-0">
            <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-stack__item--center m-stack__item--middle m-stack__item--last">
                    <span class="m-footer__copyright">© @php echo date('Y') @endphp <a href="http://www.cloudteam.vn/">Cloudteam Co., LTD</a>. All Rights Reserved.</span>
                </div>
            </div>
        </div>
    </footer>
    <div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light" style="">
        <div class="m-quick-sidebar__content">
            <span id="m_quick_sidebar_close" class="m-quick-sidebar__close"><i class="la la-close"></i></span>
            <ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_quick_sidebar_tabs_settings" role="tab" aria-selected="true">Settings</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="m_quick_sidebar_tabs_settings" role="tabpanel">
                    <div class="tab-pane" id="m_quick_sidebar_tabs_settings" role="tabpanel">
                        <div class="m-list-settings m-scrollable">
                            <div class="m-list-settings__group">
                                <div class="m-list-settings__heading">General Settings</div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">Email Notifications</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" checked="checked" name="">
                                                <span></span>
                                            </label>
                                        </span>
                                    </span>
                                </div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">Site Tracking</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" name="">
                                                <span></span>
                                            </label>
                                        </span>
                                    </span>
                                </div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">SMS Alerts</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" name="">
                                                <span></span>
                                            </label>
                                        </span>
                                    </span>
                                </div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">Backup Storage</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" name="">
                                                <span></span>
                                            </label>
                                        </span>
                                    </span>
                                </div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">Audit Logs</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" checked="checked" name="">
                                                <span></span>
                                            </label>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="m-list-settings__group">
                                <div class="m-list-settings__heading">System Settings</div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">System Logs</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" name="">
                                                <span></span>
                                            </label>
                                        </span>
                                    </span>
                                </div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">Error Reporting</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" name="">
                                                <span></span>
                                            </label>
                                        </span>
                                    </span>
                                </div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">Applications Logs</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" name="">
                                                <span></span>
                                            </label>
                                        </span>
                                    </span>
                                </div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">Backup Servers</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" checked="checked" name="">
                                                <span></span>
                                            </label>
                                        </span>
                                    </span>
                                </div>
                                <div class="m-list-settings__item">
                                    <span class="m-list-settings__item-label">Audit Logs</span>
                                    <span class="m-list-settings__item-control">
                                        <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                            <label>
                                                <input type="checkbox" name="">
                                                <span></span>
                                            </label>
                                        </span>
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal modal-wide fade modal-scroll" id="modal_md" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal modal-wide fade" id="modal_sm" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content"></div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ route('lang') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset("$theme/js/merged.js") }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
