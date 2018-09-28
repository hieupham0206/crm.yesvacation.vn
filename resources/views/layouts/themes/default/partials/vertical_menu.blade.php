<!--suppress HtmlUnknownAttribute -->
<button class="m-aside-left-close  m-aside-left-close--skin-light" id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light ">
    <div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-light m-aside-menu--submenu-skin-light " m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            @foreach ($menus as $menu)
                @if ($menu['menus'] && count($menu['menus']) > 1)
                    <li class="m-menu__item m-menu__item--submenu {{ $menu['activeClass'] }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="#" class="m-menu__link m-menu__toggle">
                            <i class="m-menu__link-icon {{ $menu['icon'] }}"></i>
                            <span class="m-menu__link-text">{{ $menu['name'] }}</span>
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                <li class="m-menu__item m-menu__item--parent {{ $menu['activeClass'] }}" aria-haspopup="true">
                                    <span class="m-menu__link">
                                        <span class="m-menu__link-text">{{ $menu['name'] }}</span>
                                    </span>
                                </li>
                                @foreach ($menu['menus'] as $key => $subMenus)
                                    @if (is_string($key))
                                        @if (! is_array($subMenus))
                                            @continue
                                        @endif
                                        <li class="m-menu__item m-menu__item--submenu {{ \App\Entities\Core\Menu::setActiveClass($subMenus) }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                                            <a href="javascript:void(0)" class="m-menu__link m-menu__link m-menu__toggle">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                                <span class="m-menu__link-text">{{ __(ucfirst($key)) }}</span>
                                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                                            </a>
                                            <div class="m-menu__submenu">
                                                <span class="m-menu__arrow"></span>
                                                <ul class="m-menu__subnav">
                                                    @foreach ($subMenus as $subKey => $subMenuItem)
                                                        @if (is_string($subKey))
                                                            @continue
                                                        @endif
                                                        <li class="m-menu__item {{ $subMenuItem['activeClass'] }}" aria-haspopup="true">
                                                            <a href="{{ $subMenuItem['route'] }}" class="m-menu__link ">
                                                                @if ($subMenuItem['icon'])
                                                                    <i class="m-menu__link-icon {{ $subMenuItem['icon'] }}"></i>
                                                                @else
                                                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                                                @endif
                                                                <span class="m-menu__link-text">{{ $subMenuItem['name'] }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                    @else
                                        <li class="m-menu__item {{ $subMenus['activeClass'] }}" aria-haspopup="true">
                                            <a href="{{ $subMenus['route'] }}" class="m-menu__link">
                                                @if ($subMenus['icon'])
                                                    <i class="m-menu__link-icon {{ $subMenus['icon'] }}"></i>
                                                @else
                                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                                @endif
                                                <span class="m-menu__link-text">{{ $subMenus['name'] }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>