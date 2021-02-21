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
    <title>Document</title>
</head>
<body>
    <div class="app-ui js-app-ui">
        <!-- header -->
        <header class="app-ui__header shadow-xs padding-x-md padding-x-0@md">
          <div class="app-ui__logo-wrapper padding-x-sm@md">
            <a href="#0" class="app-ui__logo">
              <svg width="104" height="30" viewBox="0 0 104 30" fill="var(--color-contrast-higher)">
                <title>Go to homepage</title>
                <circle cx="15" cy="15" r="15" fill="var(--color-contrast-lower)" />
                <path d="M36.184,6.145h4.551l4.807,11.727h.2L50.553,6.145H55.1V23.6H51.525V12.239h-.146L46.862,23.514H44.425L39.908,12.2h-.145V23.6H36.184Z" />
                <path d="M61.8,23.846c-3.556,0-4.347-2.234-4.347-3.9a3.405,3.405,0,0,1,2.5-3.524c1.371-.521,3.771-.56,4.854-.866.485-.136.732-.377.732-.869,0-.555-.191-1.695-1.942-1.695A2.187,2.187,0,0,0,61.274,14.5l-3.357-.273c.249-1.193,1.349-3.886,5.7-3.886,2.913,0,4.257,1.246,4.778,1.9a3.944,3.944,0,0,1,.779,2.536V23.6H65.731V21.784h-.1A3.986,3.986,0,0,1,61.8,23.846Zm1.04-2.5a2.543,2.543,0,0,0,2.727-2.42v-1.39a8.013,8.013,0,0,1-2.523.589c-.637.079-2.122.351-2.122,1.7C60.925,21.035,62.059,21.341,62.843,21.341Z" />
                <path d="M72,23.6V10.509h3.52v2.284h.136a3.513,3.513,0,0,1,1.2-1.845,3.867,3.867,0,0,1,3.084-.5v3.222c-.169-.057-2.266-.7-3.523.558a2.657,2.657,0,0,0-.789,1.964V23.6Z" />
                <path d="M89.425,10.509v2.726H86.962v6.342a1.307,1.307,0,0,0,.341,1.014,2.092,2.092,0,0,0,1.789.145l.571,2.7c-.182.057-3.132,1-5.143-.515a3.348,3.348,0,0,1-1.189-2.869V13.235h-1.79V10.509h1.79V7.372h3.631v3.137Z" />
                <path d="M97.615,23.855A6,6,0,0,1,91.9,20.7a7.7,7.7,0,0,1-.783-3.583c0-2.22,1-6.776,6.349-6.776,5.7,0,6.153,5.165,6.153,6.647v1H94.709v.008a2.864,2.864,0,0,0,2.966,3.154,2.41,2.41,0,0,0,2.513-1.517l3.359.221C103.291,21.065,102.094,23.855,97.615,23.855Zm-2.906-8.122h5.5a2.576,2.576,0,0,0-2.677-2.685A2.772,2.772,0,0,0,94.709,15.733Z" />
                <path d="M25.607,4.393,4.393,25.607A15,15,0,0,0,25.607,4.393Z" />
              </svg>
            </a>
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
              <input class="reset expandable-search__input js-expandable-search__input" type="search" name="expandable-search" id="expandable-search" placeholder="Search...">
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
              <a class="app-ui__header-btn js-tab-focus" href="#0">
                <svg class="icon" viewBox="0 0 20 20">
                  <title>Notifications</title>
                  <path d="M16,12V7a6,6,0,0,0-6-6h0A6,6,0,0,0,4,7v5L2,16H18Z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" />
                  <path d="M7.184,18a2.982,2.982,0,0,0,5.632,0Z" />
                </svg>
      
                <span class="app-ui__notification-indicator"><i class="sr-only">You have 6 notifications</i></span>
              </a>
      
              <a class="app-ui__header-btn js-tab-focus" href="#0">
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
                  <a class="app-ui__user-btn js-dropdown__trigger js-tab-focus" href="#0">
                    <img src="../../../app/assets/img/author-img-1.jpg" alt="Author picture">
                  </a>
      
                  <ul class="dropdown__menu js-dropdown__menu" aria-label="dropdown">
                    <li>
                      <a class="dropdown__item" href="#0">Item One</a>
                    </li>
      
                    <li>
                      <a class="dropdown__item" href="#0">Item Two</a>
                    </li>
      
                    <li class="dropdown__sub-wrapper js-dropdown__sub-wrapper">
                      <a class="dropdown__item" href="#0">
                        Item Three
                        <svg class="icon" aria-hidden="true" viewBox="0 0 12 12">
                          <polyline stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" points="3.5 0.5 9.5 6 3.5 11.5"></polyline>
                        </svg>
                      </a>
      
                      <ul class="dropdown__menu js-dropdown__menu" aria-label="submenu">
                        <li><a class="dropdown__item" href="#0">Sub Item One</a></li>
                        <li><a class="dropdown__item" href="#0">Sub Item Two</a></li>
                        <li><a class="dropdown__item" href="#0">Sub Item Three</a></li>
                      </ul>
                    </li>
      
                    <li>
                      <a class="dropdown__item" href="#0">Item Four</a>
                    </li>
      
                    <hr class="dropdown__separator" role="separator">
      
                    <li>
                      <a class="dropdown__item" href="#0">Item Five</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </header>
      
        <!-- navigation -->
        <div class="app-ui__nav js-app-ui__nav" id="app-ui-navigation">
          <!-- (mobile-only) search -->
          <div class="padding-x-md padding-top-md hide@md">
            <div class="search-input search-input--icon-right">
              <input class="search-input__input form-control" type="search" name="search-input" id="search-input" placeholder="Search..." aria-label="Search">
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
                <a href="#0" class="sidenav__link">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M6,0H1C0.4,0,0,0.4,0,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1V1C7,0.4,6.6,0,6,0z M5,5H2V2h3V5z"></path>
                      <path d="M15,0h-5C9.4,0,9,0.4,9,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,5h-3V2h3V5z"></path>
                      <path d="M6,9H1c-0.6,0-1,0.4-1,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1v-5C7,9.4,6.6,9,6,9z M5,14H2v-3h3V14z"></path>
                      <path d="M15,9h-5c-0.6,0-1,0.4-1,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1v-5C16,9.4,15.6,9,15,9z M14,14h-3v-3h3V14z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Dashboard</span>
      
                  <span class="sidenav__counter">12 <i class="sr-only">notifications</i></span>
                </a>
      
                <button class="reset sidenav__sublist-control js-sidenav__sublist-control js-tab-focus" aria-label="Toggle sub navigation">
                  <svg class="icon" viewBox="0 0 12 12">
                    <polygon points="4 3 8 6 4 9 4 3" /></svg>
                </button>
      
                <ul class="sidenav__list">
                  <li class="sidenav__item">
                    <a href="#0" class="sidenav__link">
                      <span class="sidenav__text text-sm@md">New widget</span>
                    </a>
                  </li>
      
                  <li class="sidenav__item">
                    <a href="#0" class="sidenav__link">
                      <span class="sidenav__text text-sm@md">Analytics</span>
                    </a>
                  </li>
                </ul>
      
              </li>
      
              <li class="sidenav__item sidenav__item--expanded">
                <a href="#0" class="sidenav__link" aria-current="page">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M14,7H2v7c0,0.6,0.4,1,1,1h10c0.6,0,1-0.4,1-1V7z"></path>
                      <rect y="1" width="16" height="4"></rect>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Products</span>
                </a>
      
                <button class="reset sidenav__sublist-control js-sidenav__sublist-control js-tab-focus" aria-label="Toggle sub navigation">
                  <svg class="icon" viewBox="0 0 12 12">
                    <polygon points="4 3 8 6 4 9 4 3" /></svg>
                </button>
      
                <ul class="sidenav__list">
                  <li class="sidenav__item">
                    <a href="#0" class="sidenav__link">
                      <span class="sidenav__text text-sm@md">Add new</span>
                    </a>
                  </li>
      
                  <li class="sidenav__item">
                    <a href="#0" class="sidenav__link">
                      <span class="sidenav__text text-sm@md">Categories</span>
                    </a>
                  </li>
                </ul>
              </li>
      
              <li class="sidenav__item">
                <a href="#0" class="sidenav__link">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M14,6.883V13H2V6.82L0,5.695V14c0,0.553,0.448,1,1,1h14c0.552,0,1-0.447,1-1V5.783L14,6.883z"></path>
                      <path d="M15,1H1C0.4,1,0,1.4,0,2v1.4l8,4.5l8-4.4V2C16,1.4,15.6,1,15,1z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Messages</span>
      
                  <span class="sidenav__counter">18 <i class="sr-only">notifications</i></span>
                </a>
              </li>
            </ul>
      
            <div class="sidenav__divider margin-y-xs" role="presentation"></div>
      
            <div class="sidenav__label margin-bottom-xxxs">
              <span class="text-sm color-contrast-medium text-xs@md">Other</span>
            </div>
      
            <ul class="sidenav__list">
              <li class="sidenav__item">
                <a href="#0" class="sidenav__link">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Settings</span>
                </a>
              </li>
      
              <li class="sidenav__item">
                <a href="#0" class="sidenav__link">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M12.25,8.231C11.163,9.323,9.659,10,8,10S4.837,9.323,3.75,8.231C1.5,9.646,0,12.145,0,15v1h16 v-1C16,12.145,14.5,9.646,12.25,8.231z"></path>
                      <circle cx="8" cy="4" r="4"></circle>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Account</span>
                </a>
              </li>
            </ul>
          </nav>
      
          <div class="padding-md padding-sm@md margin-top-auto">
            <button class="btn btn--primary width-100% text-sm@md">Button</button>
          </div>
        </div>
      
        <!-- main content -->
        <main class="app-ui__body padding-md">
          <div class="text-component">
            <h1 class="text-lg">Main Content</h1>
            <p class="text-sm color-contrast-medium">This is the main dashboard content.</p>
          </div>
        </main>
      </div>

    <script src="{{ asset("js/scripts.js") }}"></script>
</body>
</html>