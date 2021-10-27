<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <script>
      if ('CSS' in window && CSS.supports('color', 'var(--color-var)')) {
        document.write('<link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">');
      } else {
        document.write('<link rel="stylesheet" href="{{ asset('css/admin/style-fallback.css') }}">');
      }
    </script>
    <noscript>
      <link rel="stylesheet" href="{{ asset('css/admin/style-fallback.css') }}">
    </noscript>
    <link rel="stylesheet" href="{{ asset('css/admin/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
    <livewire:styles />

    <title>Управление сайтом Topfitnesbraslet</title>
</head>
<body>
    <div class="side-template-v3">
  <!-- mobile header -->
  <header class="side-template-v3__mobile-header">
    <div class="container height-100% flex items-center justify-between">
      <a class="side-template-v3__logo" href="#0">
        <svg width="104" height="30" viewBox="0 0 104 30">
          <title>Go to homepage</title>
          <path d="M37.54 24.08V3.72h4.92v16.37h8.47v4zM60.47 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8 8 0 015.64-2.18 8.07 8.07 0 015.68 2.2 8.49 8.49 0 012 5.69 8.63 8.63 0 01-1.78 5.38 7.6 7.6 0 01-5.89 2.49zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.79 3-2.79 4.26.32 4.23 2.82 4.23zM95.49 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8.4 8.4 0 0111.31 0 8.43 8.43 0 012 5.69 8.6 8.6 0 01-1.77 5.38 7.6 7.6 0 01-5.89 2.51zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.8 3-2.8 4.26.31 4.23 2.83 4.23zM77.66 30c-5.74 0-7-3.25-7.23-4.52l4.6-.26c.41.91 1.17 1.41 2.76 1.41a2.45 2.45 0 002.82-2.53v-2.68a7 7 0 01-1.7 1.75 6.12 6.12 0 01-5.85-.08c-2.41-1.37-3-4.25-3-6.66 0-.89.12-3.67 1.45-5.42a5.67 5.67 0 014.64-2.4c1.2 0 3 .25 4.46 2.82V8.81h4.85v15.33a5.2 5.2 0 01-2.12 4.32A9.92 9.92 0 0177.66 30zm.15-9.66c2.53 0 2.81-2.69 2.81-3.91s-.31-4-2.81-4-2.81 2.8-2.81 4 .27 3.91 2.81 3.91zM55.56 3.72h9.81v2.41h-9.81z" fill="var(--color-contrast-higher)" />
          <circle cx="15" cy="15" r="15" fill="var(--color-primary)" />
        </svg>
      </a>

      <button class="btn btn--subtle" aria-controls="sidenav-v3">Menu</button>
    </div>
  </header>
  <!-- end mobile header -->

  <div class="container max-width-lg">
    <div class="flex@md">
      <aside class="sidebar sidebar--static@md js-sidebar" data-static-class="position-relative z-index-1 flex-grow max-width-xxxxs" id="sidenav-v3">
        <div class="sidebar__panel">
          <header class="sidebar__header bg padding-sm border-bottom z-index-2">
            <h1 class="text-base font-medium text-truncate">Menu</h1>

            <button class="reset sidebar__close-btn js-sidebar__close-btn js-tab-focus">
              <svg class="icon icon--xs" viewBox="0 0 16 16">
                <title>Close panel</title>
                <g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10">
                  <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                  <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                </g>
              </svg>
            </button>
          </header>

          <div class="position-relative z-index-1 padding-sm padding-left-0@md">
            <a class="side-template-v3__logo margin-bottom-lg display@md" href="#0">
              <svg width="104" height="30" viewBox="0 0 104 30">
                <title>Go to homepage</title>
                <path d="M37.54 24.08V3.72h4.92v16.37h8.47v4zM60.47 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8 8 0 015.64-2.18 8.07 8.07 0 015.68 2.2 8.49 8.49 0 012 5.69 8.63 8.63 0 01-1.78 5.38 7.6 7.6 0 01-5.89 2.49zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.79 3-2.79 4.26.32 4.23 2.82 4.23zM95.49 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8.4 8.4 0 0111.31 0 8.43 8.43 0 012 5.69 8.6 8.6 0 01-1.77 5.38 7.6 7.6 0 01-5.89 2.51zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.8 3-2.8 4.26.31 4.23 2.83 4.23zM77.66 30c-5.74 0-7-3.25-7.23-4.52l4.6-.26c.41.91 1.17 1.41 2.76 1.41a2.45 2.45 0 002.82-2.53v-2.68a7 7 0 01-1.7 1.75 6.12 6.12 0 01-5.85-.08c-2.41-1.37-3-4.25-3-6.66 0-.89.12-3.67 1.45-5.42a5.67 5.67 0 014.64-2.4c1.2 0 3 .25 4.46 2.82V8.81h4.85v15.33a5.2 5.2 0 01-2.12 4.32A9.92 9.92 0 0177.66 30zm.15-9.66c2.53 0 2.81-2.69 2.81-3.91s-.31-4-2.81-4-2.81 2.8-2.81 4 .27 3.91 2.81 3.91zM55.56 3.72h9.81v2.41h-9.81z" fill="var(--color-contrast-higher)" />
                <circle cx="15" cy="15" r="15" fill="var(--color-primary)" />
              </svg>
            </a>

            <div class="exsidenav  js-exsidenav">
              <nav class="exsidenav__pop-nav" aria-label="Popular links">
                <ul>
                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('brands.index') }}" aria-current="{{ (request()->segment(2) == 'brands') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M14,14H11V12h2V4H11V2h3a1,1,0,0,1,1,1V13A1,1,0,0,1,14,14Z"></path>
                          <path d="M8.584.188a.994.994,0,0,0-.9-.136l-6,2A1,1,0,0,0,1,3V13a1,1,0,0,0,.684.948l6,2A.983.983,0,0,0,8,16a1,1,0,0,0,1-1V1A1,1,0,0,0,8.584.188ZM6,9A1,1,0,1,1,7,8,1,1,0,0,1,6,9Z"></path>
                        </g>
                      </svg>
                      <span>Бренды</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('bracelets.index') }}" aria-current="{{ (request()->segment(2) == 'bracelets') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M2,8h12c0.6,0,1-0.4,1-1V1c0-0.6-0.4-1-1-1H2C1.4,0,1,0.4,1,1v6C1,7.6,1.4,8,2,8z"></path>
                          <path d="M16,10H0v2h4l-1.8,2.4c-0.3,0.4-0.2,1.1,0.2,1.4C2.6,15.9,2.8,16,3,16c0.3,0,0.6-0.1,0.8-0.4 L6.5,12H7v2h2v-2h0.5l2.7,3.6c0.2,0.3,0.5,0.4,0.8,0.4c0.2,0,0.4-0.1,0.6-0.2c0.4-0.3,0.5-1,0.2-1.4L12,12h4V10z"></path>
                        </g>
                      </svg>
                      <span>Браслеты</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('ratings.index') }}" aria-current="{{ (request()->segment(2) == 'ratings') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Рейтинги</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('grades.index') }}" aria-current="{{ (request()->segment(2) == 'grades') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Оценки</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('sellers.index') }}" aria-current="{{ (request()->segment(2) == 'sellers') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Продавцы</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('reviews.index') }}" aria-current="{{ (request()->segment(2) == 'reviews') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Отзывы</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('posts.index') }}" aria-current="{{ (request()->segment(2) == 'posts') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Статьи блога</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('overviews.index') }}" aria-current="{{ (request()->segment(2) == 'overviews') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Обзоры</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('menuitems.index') }}" aria-current="{{ (request()->segment(2) == 'menuitems') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Настройка меню</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('groupmenus.index') }}" aria-current="{{ (request()->segment(2) == 'groupmenus') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Группировка меню</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('comments.index') }}" aria-current="{{ (request()->segment(2) == 'comments') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Комментарии</span>
                    </a>
                  </li>


                  <li>
                    <a class="exsidenav__pop-link" href="{{ route('profile.index') }}" aria-current="{{ (request()->segment(2) == 'profile') ? 'page' : '' }}">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>Профиль</span>
                    </a>
                  </li>
                </ul>
              </nav>

              {{-- <nav aria-label="Main">
                <ul class="exsidenav__list">
                  <li class="exsidenav__label-wrapper">
                    <span class="exsidenav__label">API</span>
                  </li>

                  <li>
                    <button class="reset exsidenav__control js-exsidenav__control">
                      <span>Syntax</span>

                      <svg class="icon no-js:is-hidden" viewBox="0 0 16 16" aria-hidden="true">
                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                          <path d="M3 3l10 10"></path>
                          <path d="M13 3L3 13"></path>
                        </g>
                      </svg>
                    </button>

                    <ul class="exsidenav__list">
                      <li>
                        <a class="exsidenav__link" href="#0">Overview</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Structure</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Comments</a>
                      </li>

                      <li>
                        <button class="reset exsidenav__control js-exsidenav__control">
                          <span>Functions</span>

                          <svg class="icon no-js:is-hidden" viewBox="0 0 16 16" aria-hidden="true">
                            <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                              <path d="M3 3l10 10"></path>
                              <path d="M13 3L3 13"></path>
                            </g>
                          </svg>
                        </button>

                        <ul class="exsidenav__list">
                          <li>
                            <a class="exsidenav__link" href="#0">expression()</a>
                          </li>

                          <li>
                            <a class="exsidenav__link" href="#0">url()</a>
                          </li>
                        </ul>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Older APIs</a>
                      </li>
                    </ul>
                  </li>

                  <li>
                    <button class="reset exsidenav__control js-exsidenav__control">
                      <span>Interface</span>

                      <svg class="icon no-js:is-hidden" viewBox="0 0 16 16" aria-hidden="true">
                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                          <path d="M3 3l10 10"></path>
                          <path d="M13 3L3 13"></path>
                        </g>
                      </svg>
                    </button>

                    <ul class="exsidenav__list">
                      <li>
                        <a class="exsidenav__link" href="#0">Overview</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Inspector</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Timeline</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Toolbar</a>
                      </li>
                    </ul>
                  </li>

                  <li>
                    <button class="reset exsidenav__control js-exsidenav__control">
                      <span>Examples</span>

                      <svg class="icon no-js:is-hidden" viewBox="0 0 16 16" aria-hidden="true">
                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                          <path d="M3 3l10 10"></path>
                          <path d="M13 3L3 13"></path>
                        </g>
                      </svg>
                    </button>

                    <ul class="exsidenav__list">
                      <li>
                        <a class="exsidenav__link" href="#0">Overview</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Customers</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Discounts</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Orders</a>
                      </li>
                    </ul>
                  </li>

                  <li class="exsidenav__label-wrapper">
                    <span class="exsidenav__label">Testing</span>
                  </li>

                  <li>
                    <button class="reset exsidenav__control js-exsidenav__control">
                      <span>Invoicing</span>

                      <svg class="icon no-js:is-hidden" viewBox="0 0 16 16" aria-hidden="true">
                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                          <path d="M3 3l10 10"></path>
                          <path d="M13 3L3 13"></path>
                        </g>
                      </svg>
                    </button>

                    <ul class="exsidenav__list">
                      <li>
                        <a class="exsidenav__link" href="#0">Overview</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">How invoicing works</a>
                      </li>

                      <li class="exsidenav__label-wrapper">
                        <span class="exsidenav__label">Customers</span>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Managing customers</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="#0">Taxes</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </nav> --}}
            </div>
          </div>
        </div>
      </aside>

      <main class="side-template-v3__main position-relative z-index-1 flex-grow padding-y-sm padding-left-sm@md">
        <!-- start main content -->
        @section('content')
        @show
        <!-- end main content -->
      </main>
    </div>
  </div>
</div>
@section('scripts')

<livewire:scripts />

<script src="{{ asset("js/admin/scripts.js") }}"></script>

@show
  </body>
</html>