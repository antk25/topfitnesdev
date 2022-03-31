<header class="header-v2 js-header-v2" data-animation="on" data-animation-offset="600">
    <div class="header-v2__wrapper">
        <div class="header-v2__container container max-width-lg">
            <div class="header-v2__logo flex flex-center">
                <a href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 371.6 371.6" style="enable-background:new 0 0 371.597 371.597" xml:space="preserve"><path style="fill:#5c6670" d="M249.17 65.9V14.4c0-7.92-6.48-14.4-14.4-14.4h-112.6c-7.93 0-14.4 6.48-14.4 14.4v51.5h141.4zM249.17 305.7v51.5c0 7.92-6.48 14.4-14.4 14.4h-112.6c-7.93 0-14.4-6.48-14.4-14.4v-51.5h141.4z"/><path style="fill:#333e48" d="M102.26 305.7a35.56 35.56 0 0 1-35.52-35.53V101.43a35.56 35.56 0 0 1 35.52-35.53h152.4a35.57 35.57 0 0 1 35.54 35.53v168.74a35.56 35.56 0 0 1-35.53 35.52h-152.4z"/><path style="fill:#1e252b" d="M102.26 289.17c-10.48 0-19-8.52-19-19V101.43c0-10.48 8.52-19 19-19h152.4c10.49 0 19.01 8.52 19.01 19v168.74c0 10.48-8.52 19-19 19h-152.4z"/><path style="fill:#a4a9ad" d="M290.19 127.47h14.66v46.37h-14.66z"/><circle style="fill:#fff" cx="178.47" cy="185.8" r="30.16"/><circle style="fill:#ff6d68" cx="178.47" cy="131.87" r="14.2"/><circle style="fill:#5e96dc" cx="140.33" cy="147.66" r="14.2"/><circle style="fill:#ffc843" cx="124.53" cy="185.8" r="14.2"/><circle style="fill:#0071ce" cx="140.33" cy="223.93" r="14.2"/><circle style="fill:#bf534f" cx="178.47" cy="239.73" r="14.2"/><circle style="fill:#ff6d68" cx="216.6" cy="223.93" r="14.2"/><circle style="fill:#0071ce" cx="232.4" cy="185.8" r="14.2"/><path style="fill:#e0b03b" d="M226.64 157.7a14.2 14.2 0 1 0-20.08-20.07 14.2 14.2 0 0 0 20.08 20.07z"/></svg>
                </a>
                <div>
                    <span class="color-accent font-bold">Top</span><span class="color-primary font-bold">Fitnes</span><span class="color-accent font-bold">Braslet</span>
                </div>
            </div>

            <button class="header-v2__nav-control reset anim-menu-btn js-anim-menu-btn js-tab-focus"
                aria-label="Toggle menu">
                <i class="anim-menu-btn__icon anim-menu-btn__icon--close" aria-hidden="true"></i>
            </button>

            <nav class="header-v2__nav" role="navigation">
                <ul class="header-v2__nav-list header-v2__nav-list--main">
                    <li class="header-v2__nav-item header-v2__nav-item--main header-v2__nav-item--search">
                        <form>
                            <label class="sr-only" for="searchInputX">Search</label>
                            <input class="form-control width-100%" type="search" name="searchInputX" id="searchInputX"
                                placeholder="Search...">
                        </form>
                    </li>

                    <li class="header-v2__nav-item header-v2__nav-item--main header-v2__nav-item--has-children">
                        <a href="#0" class="header-v2__nav-link">
                            <span>Новинки</span>
                            <svg class="header-v2__nav-dropdown-icon icon margin-left-xxxs" aria-hidden="true"
                                viewBox="0 0 16 16">
                                <polyline fill="none" stroke-width="1" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10" points="3.5,6.5 8,11 12.5,6.5 ">
                                </polyline>
                            </svg>
                        </a>

                        <div class="header-v2__nav-dropdown header-v2__nav-dropdown--md">
                            <ul class="header-v2__nav-list header-v2__nav-list--title-desc">
                                @foreach ($items as $item)
                                    @if ($item->name == 'top_brasletov')
                                        @foreach ($item->menuitems as $menu)
                                            <li class="header-v2__nav-item">
                                                <a href="{{ $menu->link }}" class="header-v2__nav-link">
                                                    <figure
                                                        class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                                                        <img class="header-v2__nav-icon"
                                                            src="{{ $menu->getFirstMediaUrl('menu', 'thumb') }}"
                                                            alt="">
                                                    </figure>
                                                    <div>
                                                        <strong>{{ $menu->name }}</strong>
                                                        <small>{{ $menu->about }}</small>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>

                    <li class="header-v2__nav-item header-v2__nav-item--main header-v2__nav-item--has-children">
                        <a href="#0" class="header-v2__nav-link" aria-current="page">
                            <span>Категории</span>
                            <svg class="header-v2__nav-dropdown-icon icon margin-left-xxxs" aria-hidden="true"
                                viewBox="0 0 16 16">
                                <polyline fill="none" stroke-width="1" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10" points="3.5,6.5 8,11 12.5,6.5 ">
                                </polyline>
                            </svg>
                        </a>

                        <div class="header-v2__nav-dropdown header-v2__nav-dropdown--md">
                            <ul class="header-v2__nav-list">
                                <li class="header-v2__nav-item header-v2__nav-col-2">

                                    @foreach ($items as $item)
                                        @if ($item->id == 4)
                                            <ul class="header-v2__nav-list">
                                                <li class="header-v2__nav-item header-v2__nav-item--label">
                                                    {{ $item->name }}</li>
                                                @foreach ($item->menuitems as $menu)
                                                    <li class="header-v2__nav-item"><a href="{{ $menu->link }}"
                                                            class="header-v2__nav-link">{{ $menu->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @elseif ($item->id == 6)
                                            <ul class="header-v2__nav-list">
                                                <li class="header-v2__nav-item header-v2__nav-item--label">
                                                    {{ $item->name }}</li>
                                                @foreach ($item->menuitems as $menu)
                                                    <li class="header-v2__nav-item"><a href="{{ $menu->link }}"
                                                            class="header-v2__nav-link">{{ $menu->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach

                                </li>

                                @foreach ($items as $item)
                                    @if ($item->id == 7)
                                        <li class="header-v2__nav-item header-v2__nav-item--divider" role="separator">
                                        </li>

                                        @foreach ($item->menuitems as $menu)
                                            <li class="header-v2__nav-item">
                                                <ul class="header-v2__nav-list header-v2__nav-list--title-desc">
                                                    <li class="header-v2__nav-item">
                                                        <a href="{{ $menu->link }}" class="header-v2__nav-link">
                                                            <figure
                                                                class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                                                                <img class="header-v2__nav-icon"
                                                                    src="{{ $menu->getFirstMediaUrl('menu', 'thumb') }}"
                                                                    alt="">
                                                            </figure>

                                                            <div>
                                                                <strong>{{ $menu->name }}</strong>
                                                                <small>{{ $menu->about }}</small>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>

                    <li class="header-v2__nav-item header-v2__nav-item--main header-v2__nav-item--has-children">
                        <a href="#0" class="header-v2__nav-link">
                            <span>Блог</span>
                            <svg class="header-v2__nav-dropdown-icon icon margin-left-xxxs" aria-hidden="true"
                                viewBox="0 0 16 16">
                                <polyline fill="none" stroke-width="1" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10" points="3.5,6.5 8,11 12.5,6.5 ">
                                </polyline>
                            </svg>
                        </a>

                        <div class="header-v2__nav-dropdown header-v2__nav-dropdown--md">
                            <ul class="header-v2__nav-list header-v2__nav-list--title-desc">
                                @foreach ($items as $item)
                                    @if ($item->id == 9)
                                        @foreach ($item->menuitems as $menu)
                                            <li class="header-v2__nav-item">
                                                <a href="{{ $menu->link }}" class="header-v2__nav-link">
                                                    <figure
                                                        class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                                                        <img class="header-v2__nav-icon"
                                                            src="{{ $menu->getFirstMediaUrl('menu', 'thumb') }}"
                                                            alt="">
                                                    </figure>
                                                    <div>
                                                        <strong>{{ $menu->name }}</strong>
                                                        <small>{{ $menu->about }}</small>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>

                    <li class="header-v2__nav-item header-v2__nav-item--main"><a href="/katalog"
                            class="header-v2__nav-link">Каталог</a></li>
                    <li class="header-v2__nav-item header-v2__nav-item--main"><a href="/sale"
                            class="header-v2__nav-link">Скидки</a></li>
                </ul>

                <ul class="header-v2__nav-list header-v2__nav-list--main">
                    <li class="header-v2__nav-item header-v2__nav-item--main header-v2__nav-item--has-children">
                        <a href="#0" class="header-v2__nav-link">
                            <span>Help</span>
                            <svg class="header-v2__nav-dropdown-icon icon margin-left-xxxs" aria-hidden="true"
                                viewBox="0 0 16 16">
                                <polyline fill="none" stroke-width="1" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10" points="3.5,6.5 8,11 12.5,6.5 ">
                                </polyline>
                            </svg>
                        </a>

                        <div class="header-v2__nav-dropdown">
                            <ul class="header-v2__nav-list">
                                <li class="header-v2__nav-item"><a href="#0" class="header-v2__nav-link">Sub Item
                                        One</a></li>
                                <li class="header-v2__nav-item">
                                    <a href="#0" class="header-v2__nav-link justify-between">
                                        <span>Sub Item Two <i class="sr-only">(opens in new window)</i></span>
                                        <svg class="icon icon--xxs" aria-hidden="true" viewBox="0 0 12 12">
                                            <g stroke-width="1" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" fill="none">
                                                <path d="M11.5,8.5v2a1,1,0,0,1-1,1h-9a1,1,0,0,1-1-1v-9a1,1,0,0,1,1-1h2">
                                                </path>
                                                <polyline points="6.5 0.5 11.5 0.5 11.5 5.5"></polyline>
                                                <line x1="11.5" y1="0.5" x2="5.5" y2="6.5"></line>
                                            </g>
                                        </svg>
                                    </a>
                                </li>

                                <li class="header-v2__nav-item header-v2__nav-item--has-children">
                                    <a href="#0" class="header-v2__nav-link justify-between">
                                        <span>Sub Item Three</span>
                                        <svg class="icon header-v2__nav-dropdown-icon" aria-hidden="true"
                                            viewBox="0 0 16 16">
                                            <g stroke-width="1" stroke="currentColor">
                                                <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    points="6.5,3.5 11,8 6.5,12.5 "></polyline>
                                            </g>
                                        </svg>
                                    </a>

                                    <div class="header-v2__nav-dropdown header-v2__nav-dropdown--nested">
                                        <ul class="header-v2__nav-list">
                                            <li class="header-v2__nav-item"><a href="#0" class="header-v2__nav-link">Sub
                                                    Item One</a></li>
                                            <li class="header-v2__nav-item"><a href="#0" class="header-v2__nav-link">Sub
                                                    Item Two</a></li>
                                            <li class="header-v2__nav-item"><a href="#0" class="header-v2__nav-link">Sub
                                                    Item Three</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="header-v2__nav-item header-v2__nav-item--divider" role="separator"></li>
                                <li class="header-v2__nav-item header-v2__nav-item--label">Label</li>
                                <li class="header-v2__nav-item"><a href="#0" class="header-v2__nav-link">Sub Item
                                        Four</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="header-v2__nav-item header-v2__nav-item--main header-v2__nav-item--divider"
                        role="separator"></li>

                    @if (auth()->check())
                        <li class="header-v2__nav-item header-v2__nav-item--main"><a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="header-v2__nav-link">Выйти</a></li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @can('view-admin-panel')
                            <li class="header-v2__nav-item header-v2__nav-item--main"><a href="/admin/dashboard"
                                    class="btn btn--primary">Админка</a></li>
                        @endcan
                    @else
                        <li class="header-v2__nav-item header-v2__nav-item--main"><a href="{{ route('login') }}"
                                class="header-v2__nav-link">Войти</a></li>
                    @endif

                    <li class="header-v2__nav-item header-v2__nav-item--main header-v2__nav-item--search-btn">
                        <button class="reset js-tab-focus" aria-label="Toggle search" aria-controls="modal-search">
                            <svg class="icon" aria-hidden="true" viewBox="0 0 16 16">
                                <g stroke-width="1" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10">
                                    <circle cx="7.5" cy="7.5" r="6"></circle>
                                    <line x1="15.5" y1="15.5" x2="11.742" y2="11.742"></line>
                                </g>
                            </svg>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<div class="modal modal--search modal--animate-fade bg bg-opacity-90% flex flex-center padding-md backdrop-blur-10 js-modal"
    id="modal-search">
    <div class="modal__content width-100% max-width-sm max-height-100% overflow-auto" role="alertdialog"
        aria-labelledby="modal-search-title" aria-describedby="">
        <form class="full-screen-search">
            <label for="search-input-x" id="modal-search-title" class="sr-only">Search</label>
            <input class="reset full-screen-search__input" type="search" name="search-input-x" id="search-input-x"
                placeholder="Search...">
            <button class="reset full-screen-search__btn">
                <svg class="icon" viewBox="0 0 24 24">
                    <title>Search</title>
                    <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-miterlimit="10">
                        <line x1="22" y1="22" x2="15.656" y2="15.656"></line>
                        <circle cx="10" cy="10" r="8"></circle>
                    </g>
                </svg>
            </button>
        </form>
    </div>

    <button class="reset modal__close-btn modal__close-btn--outer  js-modal__close js-tab-focus">
        <svg class="icon icon--sm" viewBox="0 0 24 24">
            <title>Close modal window</title>
            <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <line x1="3" y1="3" x2="21" y2="21" />
                <line x1="21" y1="3" x2="3" y2="21" />
            </g>
        </svg>
    </button>
</div>
