<!--suppress ALL -->
<div id="m_header_topbar" class="m-topbar m-stack m-stack--ver m-stack--general">
    <div class="m-stack__item m-topbar__nav-wrapper">
        <ul class="m-topbar__nav m-nav m-nav--inline">
            <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light m--hide" m-dropdown-toggle="click"
                id="txt_quicksearch"
                m-quicksearch-mode="dropdown" m-dropdown-persistent="1">
                <a href="#" class="m-nav__link m-dropdown__toggle">
                    <span class="m-nav__link-icon">
                        <i class="flaticon-search-1"></i>
                    </span>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right"></span>
                    <div class="m-dropdown__inner ">
                        <div class="m-dropdown__header">
                            <form class="m-list-search__form">
                                <div class="m-list-search__form-wrapper">
                                    <span class="m-list-search__form-input-wrapper">
                                        <input id="m_quicksearch_input" autocomplete="off" type="text" name="q" class="m-list-search__form-input" value="" placeholder="{{ __('Search') }}...">
                                    </span>
                                    <span class="m-list-search__form-icon-close" id="m_quicksearch_close">
                                        <i class="la la-remove"></i>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-max-height="300" data-mobile-max-height="200">
                                <div class="m-dropdown__content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width" m-dropdown-toggle="click"
                m-dropdown-persistent="1">
                <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                    {{--<span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>--}}
                    <span class="m-nav__link-icon">
                        <i class="flaticon-alert-2"></i>
                    </span>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                                <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_logs" role="tab">
                                            @lang('Activity log')
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="topbar_notifications_logs" role="tabpanel">
                                        <div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
                                            @include('layouts.partials.recent_activity_log')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="hover"
                m-dropdown-toggle="click">
                <a href="#" class="m-nav__link m-dropdown__toggle">
                    <span class="m-topbar__username font-weight-bold m--font-brand">{{ $currentUser->username }}</span>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust m--font-brand"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__header m--align-center m--bg-brand">
                            <div class="m-card-user m-card-user--skin-dark">
                                <div class="m-card-user__details">
                                    <span class="m-card-user__name font-weight-bold text-white">
                                        {{ $currentUser->username }}
                                    </span>
                                    <a href="" class="m-card-user__email m--font-weight-300 m-link text-white">
                                        {{ $currentUser->email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                                <ul class="m-nav m-nav--skin-light">
                                    <li class="m-nav__section m--hide">
                                        <span class="m-nav__section-text">
                                            Section
                                        </span>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="{{ route('users.edit', $currentUser) }}" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                            <span class="m-nav__link-title">
                                                <span class="m-nav__link-wrap">
                                                    <span class="m-nav__link-text">
                                                        @lang('My profile')
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="javascript:void(0)" data-url="{{ route('users.form_change_password') }}" class="m-nav__link" id="link_form_change_password">
                                            <i class="m-nav__link-icon flaticon-lock"></i>
                                            <span class="m-nav__link-title">
                                                <span class="m-nav__link-wrap">
                                                    <span class="m-nav__link-text">
                                                        @lang('Change password')
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                    <li class="dropdown m-nav__item">
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                           class="btn m-btn--pill btn-brand m-btn m-btn--custom m-btn--label-brand m-btn--bolder">@lang('Sign out')</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            {{--<li id="m_quick_sidebar_toggle" class="m-nav__item">--}}
                {{--<a href="#" class="m-nav__link m-dropdown__toggle">--}}
                    {{--<span class="m-nav__link-icon"><i class="flaticon-grid-menu"></i></span>--}}
                {{--</a>--}}
            {{--</li>--}}
        </ul>
    </div>
</div>