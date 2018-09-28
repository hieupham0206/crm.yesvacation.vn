<!--suppress ALL -->
<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
    @foreach ($menus as $menu)
        @if ($menu['menus'] && count($menu['menus']) > 1)
            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel {{ $menu['activeClass'] }}" aria-haspopup="true" m-menu-submenu-toggle="click">
                <a href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon {{ $menu['icon'] }}"></i>
                    <span class="m-menu__link-text">
                        {{ $menu['name'] }}
                    </span>
                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                    <ul class="m-menu__subnav">
                        @foreach ($menu['menus'] as $key => $subMenus)
                            @if (is_string($key))
                                @if (! is_array($subMenus))
                                    @continue
                                @endif
                                <li class="m-menu__item m-menu__item--submenu {{ \App\Entities\Core\Menu::setActiveClass($subMenus) }}" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                                    <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">{{ __(ucfirst($key)) }}</span>
                                        <i class="m-menu__hor-arrow la la-angle-right"></i>
                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                    </a>
                                    <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right"><span class="m-menu__arrow "></span>
                                        <ul class="m-menu__subnav">
                                            @foreach ($subMenus as $subKey => $subMenu)
                                                @if (is_string($subKey))
                                                    @continue
                                                @endif
                                                <li class="m-menu__item {{ $subMenu['activeClass'] }}" aria-haspopup="true">
                                                    <a href="{{ $subMenu['route'] }}" class="m-menu__link">
                                                        @if ($subMenu['icon'])
                                                            <i class="m-menu__link-icon {{ $subMenu['icon'] }}"></i>
                                                        @else
                                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                                <span></span>
                                                            </i>
                                                        @endif
                                                        <span class="m-menu__link-text">
                                                            {{ $subMenu['name'] }}
                                                        </span>
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
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                        @endif
                                        <span class="m-menu__link-text">
                                            {{ $subMenus['name'] }}
                                        </span>
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