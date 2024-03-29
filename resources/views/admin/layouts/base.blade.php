<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <livewire:styles />
    @stack('css')


    <title>Управление сайтом Topfitnesbraslet</title>
</head>
<body>
    <div class="app-ui js-app-ui" data-theme="">
    <!-- header -->
    <header class="app-ui__header shadow-xs padding-x-md padding-x-0@md">
      <div class="app-ui__logo-wrapper padding-x-sm@md">
        <a href="{{ route('dashboard') }}" class="app-ui__user-btn">
          <img src="/img/theme/fitness-tracker.png" alt="">
        </a>
        &nbsp; TopFitnesBraslet
      </div>

      <!-- (mobile-only) menu button -->
      <button class="reset app-ui__menu-btn hide@md js-app-ui__menu-btn js-tab-focus" aria-label="Toggle menu" aria-controls="app-ui-navigation">
        <svg class="icon" viewBox="0 0 24 24">
          <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
            <path d="M1 6h22" />
            <path d="M1 12h22" />
            <path d="M1 18h22" />
          </g>
        </svg>
      </button>

      <!-- (desktop-only) header menu -->
      <div class="display@md flex flex-grow height-100% items-center justify-between padding-x-sm">
        <form class="expandable-search text-sm@md js-expandable-search">
          <label class="sr-only" for="expandable-search">Search</label>
          <input class="reset expandable-search__input js-expandable-search__input" type="search" name="expandable-search" id="expandable-search" placeholder="Поиск пока не работает">
          <button class="reset expandable-search__btn">
            <svg class="icon" viewBox="0 0 20 20">
              <title>Search</title>
              <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2">
                <circle cx="8" cy="8" r="6" />
                <line x1="12.243" y1="12.243" x2="18" y2="18" />
              </g>
            </svg>
          </button>
        </form>

        <div class="flex gap-xxxxs">
          <button class="reset app-ui__header-btn js-tab-focus" aria-controls="notifications-popover">
            <svg class="icon" viewBox="0 0 20 20">
              <title>Notifications</title>
              <path d="M16,12V7a6,6,0,0,0-6-6h0A6,6,0,0,0,4,7v5L2,16H18Z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" />
              <path d="M7.184,18a2.982,2.982,0,0,0,5.632,0Z" />
            </svg>
            @if (count($notifications))
            <span class="app-ui__notification-indicator"><i class="sr-only">У вас {{ count($notifications) }} уведомлений</i></span>
            @endif
          </button>

          <a class="app-ui__header-btn js-tab-focus" href="{{ route('settings') }}">
            <svg class="icon" viewBox="0 0 20 20">
              <title>Settings</title>
              <g fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                <line x1="3" y1="10" x2="2" y2="10" />
                <line x1="18" y1="10" x2="7" y2="10" />
                <line x1="7" y1="12" x2="7" y2="8" />
                <line x1="17" y1="4" x2="18" y2="4" />
                <line x1="2" y1="4" x2="13" y2="4" />
                <line x1="13" y1="2" x2="13" y2="6" />
                <line x1="17" y1="16" x2="18" y2="16" />
                <line x1="2" y1="16" x2="13" y2="16" />
                <line x1="13" y1="14" x2="13" y2="18" />
              </g>
            </svg>
          </a>

          <div class="dropdown inline-block js-dropdown">
            <div class="dropdown__wrapper">
              <a class="app-ui__user-btn js-dropdown__trigger js-tab-focus" href="{{ route('profile.index') }}">
                @if (Auth::user()->getFirstMediaUrl('avatars', 'thumb'))
                  <img src="{{ Auth::user()->getFirstMediaUrl('avatars', 'thumb') }}">
                @else
                  <img src="/storage/theme/comments-placeholder.svg">
                @endif
              </a>

              <ul class="dropdown__menu js-dropdown__menu" aria-label="dropdown">
                <li>
                  <a class="dropdown__item" href="{{ route('profile.index') }}">Профиль</a>
                </li>

                {{-- <li>
                  <a class="dropdown__item" href="{{ route('admin.profile.password') }}">Смена пароля</a>
                </li> --}}

                <li>
                  <a class="dropdown__item" href="{{ route('notifications') }}">Уведомления</a>
                </li>

                <hr class="dropdown__separator" role="separator">

                <li>
                  <a class="dropdown__item" href="{{ route('logout') }}">Выйти</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- navigation -->
    <div class="app-ui__nav js-app-ui__nav" id="app-ui-navigation">
      <div class="flex flex-column height-100%">
        <div class="flex-grow overflow-auto momentum-scrolling">
          <!-- (mobile-only) search -->
          <div class="padding-x-md padding-top-md hide@md">
            <div class="search-input search-input--icon-right">
              <input class="form-control width-100% height-100%" type="search" name="searchInputX" id="searchInputX" placeholder="Search..." aria-label="Search">
              <button class="search-input__btn">
                <svg class="icon" viewBox="0 0 24 24">
                  <title>Submit</title>
                  <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor" fill="none" stroke-miterlimit="10">
                    <line x1="22" y1="22" x2="15.656" y2="15.656"></line>
                    <circle cx="10" cy="10" r="8"></circle>
                  </g>
                </svg>
              </button>
            </div>
          </div>

          <!-- side navigation -->
          <nav class="sidenav padding-y-sm js-sidenav">
            <div class="sidenav__label margin-bottom-xxxs">
              <span class="text-sm color-contrast-medium text-xs@md">Main</span>
            </div>

            <ul class="sidenav__list">
              <li class="sidenav__item">
                <a href="/admin/dashboard" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'dashboard') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M6,0H1C0.4,0,0,0.4,0,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1V1C7,0.4,6.6,0,6,0z M5,5H2V2h3V5z"></path>
                      <path d="M15,0h-5C9.4,0,9,0.4,9,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,5h-3V2h3V5z"></path>
                      <path d="M6,9H1c-0.6,0-1,0.4-1,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1v-5C7,9.4,6.6,9,6,9z M5,14H2v-3h3V14z"></path>
                      <path d="M15,9h-5c-0.6,0-1,0.4-1,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1v-5C16,9.4,15.6,9,15,9z M14,14h-3v-3h3V14z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Главная</span>

                </a>
              </li>

              <li class="
              @switch(request()->segment(2))
                @case('components')
                @case('grades')
                @case('sellers')
                @case('reviews')
                @case('comments')
                @case('brands')
                @case('specs')
                  sidenav__item sidenav__item--expanded
                  @break
                @default
              sidenav__item sidenav__item
              @endswitch
              ">
                <a href="{{ route('components') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'components') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16"><g><circle cx="13" cy="5" r="3"></circle><rect x="3" y="8" width="7" height="7" rx="1" ry="1"></rect><polygon points="4 0 0 6 8 6 4 0"></polygon></g></svg>
                  <span class="sidenav__text text-sm@md">Компоненты</span>
                </a>

                <button class="reset sidenav__sublist-control js-sidenav__sublist-control js-tab-focus" aria-label="Toggle sub navigation">
                  <svg class="icon" viewBox="0 0 12 12"><polygon points="4 3 8 6 4 9 4 3" /></svg>
                </button>

                <ul class="sidenav__list">
                  <li class="sidenav__item">
                    <a href="{{ route('grades.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'grades') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Оценки</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('sellers.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'sellers') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Продавцы</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('reviews.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'reviews') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Отзывы</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('comments.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'comments') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Комментарии</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('brands.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'brands') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Бренды</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('specs.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'specs') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Характеристики</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="
              @switch(request()->segment(2))
                @case('pages')
                @case('bracelets')
                @case('ratings')
                @case('posts')
                @case('overviews')
                @case('comparisons')
                @case('manuals')
                @case('static-pages')
                  sidenav__item sidenav__item--expanded
                  @break
                @default
              sidenav__item sidenav__item
              @endswitch
              ">
                <a href="{{ route('pages') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'pages') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16"><g><path d="M14,0H2C1.4,0,1,0.4,1,1v14c0,0.6,0.4,1,1,1h12c0.6,0,1-0.4,1-1V1C15,0.4,14.6,0,14,0z M13,14H3V2h10V14z"></path><rect x="4" y="3" width="4" height="4"></rect><rect x="9" y="4" width="3" height="1"></rect><rect x="9" y="6" width="3" height="1"></rect><rect x="4" y="8" width="8" height="1"></rect> <rect x="4" y="10" width="8" height="1"></rect><rect x="4" y="12" width="5" height="1"></rect></g></svg>

                  <span class="sidenav__text text-sm@md">Страницы</span>
                </a>

                <button class="reset sidenav__sublist-control js-sidenav__sublist-control js-tab-focus" aria-label="Toggle sub navigation">
                  <svg class="icon" viewBox="0 0 12 12"><polygon points="4 3 8 6 4 9 4 3" /></svg>
                </button>

                <ul class="sidenav__list">
                  <li class="sidenav__item">
                    <a href="{{ route('bracelets.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'bracelets') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Браслеты</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('ratings.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'ratings') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Рейтинги</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('posts.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'posts') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Статьи блога</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('overviews.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'overviews') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Обзоры</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('comparisons.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'comparisons') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Сравнения</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('manuals.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'manuals') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Мануалы</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('static-pages.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'static-pages') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Статич. страницы</span>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="
              @switch(request()->segment(2))
                @case('groupmenus')
                @case('menuitems')
                  sidenav__item sidenav__item--expanded
                  @break
                @default
              sidenav__item sidenav__item
              @endswitch
              ">
                <a href="#0" class="sidenav__link">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16"><g><path d="M14,0H2C1.4,0,1,0.4,1,1v14c0,0.6,0.4,1,1,1h12c0.6,0,1-0.4,1-1V1C15,0.4,14.6,0,14,0z M13,14H3V2h10V14z"></path><rect x="4" y="3" width="4" height="4"></rect><rect x="9" y="4" width="3" height="1"></rect><rect x="9" y="6" width="3" height="1"></rect><rect x="4" y="8" width="8" height="1"></rect> <rect x="4" y="10" width="8" height="1"></rect><rect x="4" y="12" width="5" height="1"></rect></g></svg>

                  <span class="sidenav__text text-sm@md">Меню</span>
                </a>

                <button class="reset sidenav__sublist-control js-sidenav__sublist-control js-tab-focus" aria-label="Toggle sub navigation">
                  <svg class="icon" viewBox="0 0 12 12"><polygon points="4 3 8 6 4 9 4 3" /></svg>
                </button>

                <ul class="sidenav__list">
                  <li class="sidenav__item">
                    <a href="{{ route('groupmenus.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'groupmenus') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Группировка</span>
                    </a>
                  </li>

                  <li class="sidenav__item">
                    <a href="{{ route('menuitems.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'menuitems') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">Пункты</span>
                    </a>
                  </li>


                </ul>
              </li>
            </ul>

            <div class="sidenav__divider margin-y-xs" role="presentation"></div>

            <div class="sidenav__label margin-bottom-xxxs">
              <span class="text-sm color-contrast-medium text-xs@md">Other</span>
            </div>

            <ul class="sidenav__list">

              <li class="
              @switch(request()->segment(2))
                @case('htmlcomponents')
                @case('settings')
                  sidenav__item sidenav__item--expanded
                  @break
                @default
              sidenav__item sidenav__item
              @endswitch
              ">
                <a href="{{ route('settings') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'settings') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M6,0H1C0.4,0,0,0.4,0,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1V1C7,0.4,6.6,0,6,0z M5,5H2V2h3V5z"></path>
                      <path d="M15,0h-5C9.4,0,9,0.4,9,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,5h-3V2h3V5z"></path>
                      <path d="M6,9H1c-0.6,0-1,0.4-1,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1v-5C7,9.4,6.6,9,6,9z M5,14H2v-3h3V14z"></path>
                      <path d="M15,9h-5c-0.6,0-1,0.4-1,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1v-5C16,9.4,15.6,9,15,9z M14,14h-3v-3h3V14z"></path>
                    </g>
                  </svg>

                  <span class="sidenav__text text-sm@md">Настройка админки</span>
                </a>

                <button class="reset sidenav__sublist-control js-sidenav__sublist-control js-tab-focus" aria-label="Toggle sub navigation">
                  <svg class="icon" viewBox="0 0 12 12"><polygon points="4 3 8 6 4 9 4 3" /></svg>
                </button>

                <ul class="sidenav__list">
                  <li class="sidenav__item">
                    <a href="{{ route('htmlcomponents.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'htmlcomponents') ? 'page' : '' }}">
                      <span class="sidenav__text text-sm@md">HTML компоненты</span>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="sidenav__item">
                <a href="{{ route('profile.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'profile') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Профиль</span>
                </a>
              </li>

              <li class="sidenav__item">
                <a href="{{ route('notifications') }}" class="sidenav__link">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16"><g><path d="M10,14H6c0,1.1,0.9,2,2,2S10,15.1,10,14z"></path> <path d="M15,11h-0.5C13.8,10.3,13,9.3,13,8V5c0-2.8-2.2-5-5-5S3,2.2,3,5v3c0,1.3-0.8,2.3-1.5,3H1c-0.6,0-1,0.4-1,1 s0.4,1,1,1h14c0.6,0,1-0.4,1-1S15.6,11,15,11z"></path></g></svg>

                  <span class="sidenav__text text-sm@md">Уведомления</span>
                  @if (count($notifications))
                  <span class="sidenav__counter">{{ count($notifications) }} <i class="sr-only">уведомлений</i></span>
                  @endif
                </a>
              </li>
            </ul>
          </nav>
        </div>

        <!-- light/dark mode toggle -->
        <div class="padding-md padding-sm@md margin-top-auto flex-shrink-0 border-top border-contrast-lower ie:hide">
          <div class="flex items-center justify-between@md">
            <p class="text-sm@md">Dark Mode</p>

            <div class="switch dark-mode-switch margin-left-xxs">
              <input class="switch__input" type="checkbox" id="switch-light-dark">
              <label aria-hidden="true" class="switch__label" for="switch-light-dark">On</label>
              <div aria-hidden="true" class="switch__marker"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

      <main class="app-ui__body padding-md js-app-ui__body">

        <!-- start main content -->
        @section('content')
        @show
        <!-- end main content -->
      </main>
    </div>
  </div>
</div>

<!-- notification popover -->
<div id="notifications-popover" class="popover notif-popover bg radius-md shadow-md js-popover" role="dialog">
  <header class="bg bg-opacity-90% backdrop-blur-10 text-sm padding-sm shadow-xs position-sticky top-0 z-index-2">
    <div class="flex justify-between items-baseline">
      <h4 class="text-md">Уведомления</h4>
      <a href="{{ route('notifications') }}" class="js-tab-focus">Смотреть все</a>
    </div>
  </header>

  <ul class="notif text-sm">
    @foreach ($notifications as $item)

    <li class="notif__item">
      <div class="padding-sm">
        <p><i class="font-semibold">{{ $item->data['type'] }}</i> на <a href="{{ $item->data['link'] }}c{{ $item->data['id'] }}">странице</a>.</p>
      </div>
    </li>
    @endforeach

  </ul>
</div>

<livewire:scripts />
<script src="{{ asset("js/admin/scripts.js") }}"></script>
@stack('js')

  </body>
</html>
