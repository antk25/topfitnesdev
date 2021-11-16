<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <livewire:styles />
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />

</head>
<body>
    <div class="side-template-v3">
        {{-- mobile header --}}
    <header class="side-template-v3__mobile-header">
        <div class="container height-100% flex items-center justify-between">
          <a class="side-template-v3__logo" href="index.html">
            <svg width="104" height="30" viewBox="0 0 104 30">
              <title>Go to homepage</title>
              <path d="M37.54 24.08V3.72h4.92v16.37h8.47v4zM60.47 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8 8 0 015.64-2.18 8.07 8.07 0 015.68 2.2 8.49 8.49 0 012 5.69 8.63 8.63 0 01-1.78 5.38 7.6 7.6 0 01-5.89 2.49zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.79 3-2.79 4.26.32 4.23 2.82 4.23zM95.49 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8.4 8.4 0 0111.31 0 8.43 8.43 0 012 5.69 8.6 8.6 0 01-1.77 5.38 7.6 7.6 0 01-5.89 2.51zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.8 3-2.8 4.26.31 4.23 2.83 4.23zM77.66 30c-5.74 0-7-3.25-7.23-4.52l4.6-.26c.41.91 1.17 1.41 2.76 1.41a2.45 2.45 0 002.82-2.53v-2.68a7 7 0 01-1.7 1.75 6.12 6.12 0 01-5.85-.08c-2.41-1.37-3-4.25-3-6.66 0-.89.12-3.67 1.45-5.42a5.67 5.67 0 014.64-2.4c1.2 0 3 .25 4.46 2.82V8.81h4.85v15.33a5.2 5.2 0 01-2.12 4.32A9.92 9.92 0 0177.66 30zm.15-9.66c2.53 0 2.81-2.69 2.81-3.91s-.31-4-2.81-4-2.81 2.8-2.81 4 .27 3.91 2.81 3.91zM55.56 3.72h9.81v2.41h-9.81z" fill="var(--color-contrast-higher)" />
              <circle cx="15" cy="15" r="15" fill="var(--color-primary)" />
            </svg>
          </a>

          <button class="btn btn--subtle" aria-controls="sidenav-v3">Menu</button>
        </div>
      </header>
      {{-- end mobile header --}}

      {{-- Общие теги для всего контента --}}
      <div class="container max-width-lg">
        <div class="flex@md items-start@md">
    @section('header')
    <aside id="sidenav-v3" class="sidebar sidebar--static@md js-sidebar">
        <div class="sidebar__panel flex flex-column">
          <!-- sidebar header - mobile only -->
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

          <!-- sidebar main content -->
          <div class="position-relative z-index-1 padding-sm padding-left-0@md padding-top-0@md flex-grow@md">
            <!-- desktop logo  -->
            <div class="side-template-v3__logo-wrapper padding-top-sm padding-bottom-xxxs padding-left-xxxs margin-bottom-lg bg-dark display@md">
              <a class="side-template-v3__logo" href="index.html">
                <svg width="104" height="30" viewBox="0 0 104 30">
                  <title>Go to homepage</title>
                  <path d="M37.54 24.08V3.72h4.92v16.37h8.47v4zM60.47 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8 8 0 015.64-2.18 8.07 8.07 0 015.68 2.2 8.49 8.49 0 012 5.69 8.63 8.63 0 01-1.78 5.38 7.6 7.6 0 01-5.89 2.49zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.79 3-2.79 4.26.32 4.23 2.82 4.23zM95.49 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8.4 8.4 0 0111.31 0 8.43 8.43 0 012 5.69 8.6 8.6 0 01-1.77 5.38 7.6 7.6 0 01-5.89 2.51zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.8 3-2.8 4.26.31 4.23 2.83 4.23zM77.66 30c-5.74 0-7-3.25-7.23-4.52l4.6-.26c.41.91 1.17 1.41 2.76 1.41a2.45 2.45 0 002.82-2.53v-2.68a7 7 0 01-1.7 1.75 6.12 6.12 0 01-5.85-.08c-2.41-1.37-3-4.25-3-6.66 0-.89.12-3.67 1.45-5.42a5.67 5.67 0 014.64-2.4c1.2 0 3 .25 4.46 2.82V8.81h4.85v15.33a5.2 5.2 0 01-2.12 4.32A9.92 9.92 0 0177.66 30zm.15-9.66c2.53 0 2.81-2.69 2.81-3.91s-.31-4-2.81-4-2.81 2.8-2.81 4 .27 3.91 2.81 3.91zM55.56 3.72h9.81v2.41h-9.81z" fill="var(--color-contrast-higher)" />
                  <circle cx="15" cy="15" r="15" fill="var(--color-primary)" />
                </svg>
              </a>
            </div>
            <!-- end desktop logo  -->

            <!-- mobile only search -->
            <div class="search-input search-input--icon-left margin-bottom-sm hide@md">
              <form action="search-results.html">
                <input class="search-input__input form-control" type="search" name="search-input" id="search-input" placeholder="Search..." aria-label="Search">

                <button class="search-input__btn">
                  <svg class="icon" viewBox="0 0 20 20"><title>Submit</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="8" cy="8" r="6"/><line x1="12.242" y1="12.242" x2="18" y2="18"/></g></svg>
                </button>
              </form>
            </div>
            <!-- end mobile only search -->

            <div class="exsidenav js-exsidenav">
              <nav class="exsidenav__pop-nav" aria-label="Popular links">
                <ul>
                  <li>
                    <a class="exsidenav__pop-link" href="index.html">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M14,14H11V12h2V4H11V2h3a1,1,0,0,1,1,1V13A1,1,0,0,1,14,14Z" opacity="0.5"></path>
                          <path d="M8.584.188a.994.994,0,0,0-.9-.136l-6,2A1,1,0,0,0,1,3V13a1,1,0,0,0,.684.948l6,2A.983.983,0,0,0,8,16a1,1,0,0,0,1-1V1A1,1,0,0,0,8.584.188ZM6,9A1,1,0,1,1,7,8,1,1,0,0,1,6,9Z"></path>
                        </g>
                      </svg>
                      <span>Getting started</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="tutorials.html">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M2,8h12c0.6,0,1-0.4,1-1V1c0-0.6-0.4-1-1-1H2C1.4,0,1,0.4,1,1v6C1,7.6,1.4,8,2,8z" opacity="0.5"></path>
                          <path d="M16,10H0v2h4l-1.8,2.4c-0.3,0.4-0.2,1.1,0.2,1.4C2.6,15.9,2.8,16,3,16c0.3,0,0.6-0.1,0.8-0.4 L6.5,12H7v2h2v-2h0.5l2.7,3.6c0.2,0.3,0.5,0.4,0.8,0.4c0.2,0,0.4-0.1,0.6-0.2c0.4-0.3,0.5-1,0.2-1.4L12,12h4V10z"></path>
                        </g>
                      </svg>
                      <span>Tutorials</span>
                    </a>
                  </li>

                  <li>
                    <a class="exsidenav__pop-link" href="faq.html">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g>
                          <path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M9,12H7V7h2V12z M8,6C7.4,6,7,5.6,7,5s0.4-1,1-1 s1,0.4,1,1S8.6,6,8,6z"></path>
                        </g>
                      </svg>
                      <span>FAQ</span>
                    </a>
                  </li>

                  <li class="hide@md">
                    <a class="exsidenav__pop-link" href="login.html">
                      <svg class="icon" viewBox="0 0 16 16">
                        <path d="M14,0H6A2,2,0,0,0,4,2V4A1,1,0,0,0,6,4V2h8V14H6V12a1,1,0,0,0-2,0v2a2,2,0,0,0,2,2h8a2,2,0,0,0,2-2V2A2,2,0,0,0,14,0Z"/>
                        <path d="M8,11.5a.5.5,0,0,0,.327.469.5.5,0,0,0,.552-.144l3-3.5a.5.5,0,0,0,0-.65l-3-3.5A.5.5,0,0,0,8,4.5V7H1A1,1,0,0,0,1,9H8Z" opacity="0.5"/>
                      </svg>
                      <span>Login</span>
                    </a>
                  </li>

                  <li class="hide@md">
                    <a class="exsidenav__pop-link" href="sign-up.html">
                      <svg class="icon" viewBox="0 0 16 16">
                        <circle cx="7" cy="3.5" r="3.5"/>
                        <path d="M15.5,12H14V10.5a.5.5,0,0,0-.5-.5h-1a.5.5,0,0,0-.5.5V12H10.5a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5H12v1.5a.5.5,0,0,0,.5.5h1a.5.5,0,0,0,.5-.5V14h1.5a.5.5,0,0,0,.5-.5v-1A.5.5,0,0,0,15.5,12Z" opacity="0.5"/>
                        <path d="M8,13A4.988,4.988,0,0,1,9.469,9.46,6.918,6.918,0,0,0,7,9,7.025,7.025,0,0,0,.027,15.462a.5.5,0,0,0,.5.538h8.5A4.956,4.956,0,0,1,8,13Z"/>
                      </svg>
                      <span>Signup</span>
                    </a>
                  </li>
                </ul>
              </nav>

              <nav aria-label="Main">
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
                        <a class="exsidenav__link" href="basic-page.html" aria-current="page">Overview</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Structure</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Comments</a>
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
                            <a class="exsidenav__link" href="basic-page.html">expression()</a>
                          </li>

                          <li>
                            <a class="exsidenav__link" href="basic-page.html">url()</a>
                          </li>
                        </ul>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Older APIs</a>
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
                        <a class="exsidenav__link" href="basic-page.html">Overview</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Inspector</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Timeline</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Toolbar</a>
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
                        <a class="exsidenav__link" href="basic-page.html">Overview</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Customers</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Discounts</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Orders</a>
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
                        <a class="exsidenav__link" href="basic-page.html">Overview</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">How invoicing works</a>
                      </li>

                      <li class="exsidenav__label-wrapper">
                        <span class="exsidenav__label">Customers</span>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Managing customers</a>
                      </li>

                      <li>
                        <a class="exsidenav__link" href="basic-page.html">Taxes</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </div>

          <!-- sidebar footer -->
          <footer class="side-template-v3__footer margin-top-auto position-sticky bottom-0 z-index-2 padding-x-sm padding-left-0@md">
            <div class="border-top border-alpha padding-y-xs flex justify-between items-center">
              <p class="text-sm color-contrast-medium">&copy; MyProject</p>

              <ul class="radio-switch" id="switch-light-dark">
                <li class="radio-switch__item">
                  <input class="radio-switch__input sr-only" type="radio" name="radio-switch-name" id="radio-switch-1" checked value="light">
                  <label class="radio-switch__label" for="radio-switch-1"><svg class="icon icon--xs" viewBox="0 0 16 16">
                      <title>Enable light mode</title>
                      <path d="M7 0h2v2H7zM12.88 1.637l1.414 1.415-1.415 1.413-1.414-1.414zM14 7h2v2h-2zM12.95 14.433l-1.415-1.414 1.414-1.414 1.415 1.413zM7 14h2v2H7zM2.98 14.363L1.566 12.95l1.415-1.414 1.414 1.415zM0 7h2v2H0zM3.05 1.707L4.465 3.12 3.05 4.535 1.636 3.121z" />
                      <path d="M8 4C5.8 4 4 5.8 4 8s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4z" />
                    </svg></label>
                </li>

                <li class="radio-switch__item">
                  <input class="radio-switch__input sr-only" type="radio" name="radio-switch-name" id="radio-switch-2" value="dark">
                  <label class="radio-switch__label" for="radio-switch-2"><svg class="icon icon--xs" viewBox="0 0 16 16">
                      <title>Enable dark mode</title>
                      <path d="M6,0C2.5,0.9,0,4.1,0,7.9C0,12.4,3.6,16,8.1,16c3.8,0,6.9-2.5,7.9-6C9.9,11.7,4.3,6.1,6,0z"></path>
                    </svg></label>
                  <div aria-hidden="true" class="radio-switch__marker"></div>
                </li>
              </ul>
            </div>
          </footer>
        </div>
      </aside>

    @show
    <main class="side-template-v3__main position-relative z-index-1 flex-grow sidebar-loaded:show js-side-template-v3__main">
        <div class="padding-y-sm padding-left-md@md">
    @section('content')

    @show
        </div>
    </main>

@section('footerScripts')

    <livewire:scripts />
    <script src="{{ asset("js/scripts.js") }}"></script>
    {{-- <script src="{{ asset("js/alpine.min.js") }}"></script> --}}
       {{-- window.livewire.on('loadData', () => { --}}
         {{-- document.getElementsByTagName("html")[0].className += " js"; --}}
           {{-- }); --}}
    {{-- <script src="{{ asset("js/axios.min.js") }}"></script> --}}
@show
            </div>
        </div>
    </div>

</body>
      </html>