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
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    
<livewire:styles />
    <title>Управление сайтом Topfitnesbraslet</title>
</head>
<body>
    <div class="app-ui js-app-ui">
        <!-- header -->
        <header class="app-ui__header shadow-xs padding-x-md padding-x-0@md">
          <div class="app-ui__logo-wrapper padding-x-sm@md">
            <a href="/" class="app-ui__logo">
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
            <button class="btn btn--primary" aria-controls="modal-explorer">Быстрый доступ</button>

            <div class="modal modal--animate-fade bg-contrast-higher bg-opacity-90% padding-x-md padding-y-lg js-modal" id="modal-explorer" data-modal-first-focus=".js-autocomplete__input">
              <div class="modal__content explorer width-100% max-width-xs max-height-100% overflow-auto margin-x-auto flex flex-column bg radius-md shadow-md js-explorer" data-autocomplete-dropdown-visible-class="explorer--results-visible" data-autocomplete-searching-class="explorer--searching" id="explorer-link-variation">
                <div class="explorer__input-wrapper flex-shrink-0">
                  <input class="reset explorer__input width-100% js-autocomplete__input" type="text" name="autocomplete-input" id="autocomplete-input" placeholder="Type Project..." autocomplete="off">

                  <div class="explorer__loader position-absolute top-0 right-0 padding-right-sm height-100% flex items-center" aria-hidden="true">
                    <div class="circle-loader circle-loader--v1">
                      <div class="circle-loader__circle"></div>
                    </div>
                  </div>
                </div>

                <div class="explorer__results flex-grow js-autocomplete__results">
                  <ul class="explorer__list js-autocomplete__list">
                    <!-- no results item template -->
                    <li class="js-autocomplete__item is-hidden" data-autocomplete-template="no-results">
                      <button class="reset explorer__result explorer__result--none">
                        <span class="text-sm color-contrast-medium" data-autocomplete-label></span>
                      </button>
                    </li>

                    <!-- link item template -->
                    <li class="js-autocomplete__item is-hidden" data-autocomplete-template="link">
                      <a class="explorer__result" data-autocomplete-url>
                        <span class="flex flex-column items-start">
                          <i data-autocomplete-label></i>
                          <i class="explorer__label" data-autocomplete-category></i>
                        </span>
                      </a>
                    </li>
                  </ul>
                </div>

                <p class="sr-only" aria-live="polite" aria-atomic="true"><span class="js-autocomplete__aria-results">0</span> ничего не найдено.</p>
              </div>

              <button class="reset modal__close-btn modal__close-btn--outer display@md js-modal__close js-tab-focus">
                <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Close modal window</title><g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="3" x2="21" y2="21"/><line x1="21" y1="3" x2="3" y2="21"/></g></svg>
              </button>
            </div>
          </div>
        </header>
      
        <!-- navigation -->
        <div class="app-ui__nav js-app-ui__nav" id="app-ui-navigation">
          
      
          <!-- side navigation -->
          <nav class="sidenav padding-y-sm js-sidenav">
            <div class="sidenav__label margin-bottom-xxxs">
              <span class="text-sm color-contrast-medium text-xs@md">Главное меню</span>
            </div>
      
            <ul class="sidenav__list">
      
              <li class="sidenav__item">
                <a href="{{ route('brands.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'brands') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Бренды</span>
                </a>
              </li>

              <li class="sidenav__item">
                <a href="{{ route('bracelets.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'bracelets') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Браслеты</span>
                </a>
              </li>

              <li class="sidenav__item">
                <a href="{{ route('ratings.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'ratings') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Рейтинги</span>
                </a>
              </li>

              <li class="sidenav__item">
                <a href="{{ route('grades.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'grades') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Оценки</span>
                </a>
              </li>

              <li class="sidenav__item">
                <a href="{{ route('sellers.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'sellers') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Продавцы</span>
                </a>
              </li>

              <li class="sidenav__item">
                <a href="{{ route('reviews.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'reviews') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Отзывы</span>
                </a>
              </li>

              <li class="sidenav__item">
                <a href="{{ route('posts.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'posts') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Статьи блога</span>
                </a>
              </li>        
              
              <li class="sidenav__item">
                <a href="{{ route('comments.index') }}" class="sidenav__link" aria-current="{{ (request()->segment(2) == 'comments') ? 'page' : '' }}">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <circle cx="6" cy="8" r="2"></circle>
                      <path d="M10,2H6C2.7,2,0,4.7,0,8s2.7,6,6,6h4c3.3,0,6-2.7,6-6S13.3,2,10,2z M10,12H6c-2.2,0-4-1.8-4-4s1.8-4,4-4h4 c2.2,0,4,1.8,4,4S12.2,12,10,12z"></path>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Комментарии</span>
                </a>
              </li>
            </ul>
      
            <div class="sidenav__divider margin-y-xs" role="presentation"></div>
      
            <div class="sidenav__label margin-bottom-xxxs">
              <span class="text-sm color-contrast-medium text-xs@md">Другое</span>
            </div>
      
            <ul class="sidenav__list">
      
              <li class="sidenav__item">
                <a href="{{ route('profile.index') }}" class="sidenav__link">
                  <svg class="icon sidenav__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M12.25,8.231C11.163,9.323,9.659,10,8,10S4.837,9.323,3.75,8.231C1.5,9.646,0,12.145,0,15v1h16 v-1C16,12.145,14.5,9.646,12.25,8.231z"></path>
                      <circle cx="8" cy="4" r="4"></circle>
                    </g>
                  </svg>
                  <span class="sidenav__text text-sm@md">Профиль</span>
                </a>
              </li>
            </ul>
          </nav>
      
          <div class="padding-md padding-sm@md margin-top-auto">
            <button class="btn btn--primary width-100% text-sm@md">Button</button>
          </div>
        </div>

        <main class="app-ui__body padding-md">
        @section('content')
        @show
        </main>
        
      </div>
@section('scripts')

<livewire:scripts />

<script src="{{ asset("js/admin/scripts.js") }}"></script>

<script>
  if(document.getElementById('explorer-link-variation')) { // --link variation
    // use different results for the --link variation 
    explorerQuickLinks = [
      { 
        label: 'Добавить бренд', 
        class: 'js-explorer__link',
        url: '{{ route('brands.create') }}',
        category: 'Бренды',
        template: 'link'
      },
      { 
        label: 'Добавить браслет', 
        class: 'js-explorer__link',
        url: '{{ route('bracelets.create') }}',
        category: 'Браслеты',
        template: 'link'
      },
      { 
        label: 'Добавить рейтинг', 
        class: 'js-explorer__link',
        url: '{{ route('ratings.create') }}',
        category: 'Рейтинги',
        template: 'link'
      },
      { 
        label: 'Добавить статью в блог', 
        class: 'js-explorer__link',
        url: '{{ route('posts.create') }}',
        category: 'Блог',
        template: 'link'
      }
    ];
  
    explorerAdditionalLinks = [
      { 
        label: 'Добавить оценку', 
        class: 'js-explorer__link',
        url: '{{ route('grades.create') }}',
        category: 'Оценки',
        template: 'link'
      },
      { 
        label: 'Добавить продавца', 
        class: 'js-explorer__link',
        url: '{{ route('sellers.create') }}',
        category: 'Продавцы',
        template: 'link'
      },
      { 
        label: 'Добавить отзыв', 
        class: 'js-explorer__link',
        url: '{{ route('reviews.create') }}',
        category: 'Отзывы',
        template: 'link'
      }
    ];
  }
</script>
@show
  </body>
</html>