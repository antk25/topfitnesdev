<header class="mega-nav mega-nav--mobile mega-nav--desktop@md position-relative js-mega-nav">
        <div class="mega-nav__container">
          <!-- 👇 logo -->
          <a href="#0" class="mega-nav__logo">
            <svg width="104" height="30" viewBox="0 0 104 30">
              <title>Go to homepage</title>
              <path d="M37.54 24.08V3.72h4.92v16.37h8.47v4zM60.47 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8 8 0 015.64-2.18 8.07 8.07 0 015.68 2.2 8.49 8.49 0 012 5.69 8.63 8.63 0 01-1.78 5.38 7.6 7.6 0 01-5.89 2.49zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.79 3-2.79 4.26.32 4.23 2.82 4.23zM95.49 24.37a7.82 7.82 0 01-5.73-2.25 8.36 8.36 0 01-2-5.62 8.32 8.32 0 012.08-5.71 8.4 8.4 0 0111.31 0 8.43 8.43 0 012 5.69 8.6 8.6 0 01-1.77 5.38 7.6 7.6 0 01-5.89 2.51zm0-3.67c2.42 0 2.73-3 2.73-4.23s-.31-4.26-2.73-4.26-2.8 3-2.8 4.26.31 4.23 2.83 4.23zM77.66 30c-5.74 0-7-3.25-7.23-4.52l4.6-.26c.41.91 1.17 1.41 2.76 1.41a2.45 2.45 0 002.82-2.53v-2.68a7 7 0 01-1.7 1.75 6.12 6.12 0 01-5.85-.08c-2.41-1.37-3-4.25-3-6.66 0-.89.12-3.67 1.45-5.42a5.67 5.67 0 014.64-2.4c1.2 0 3 .25 4.46 2.82V8.81h4.85v15.33a5.2 5.2 0 01-2.12 4.32A9.92 9.92 0 0177.66 30zm.15-9.66c2.53 0 2.81-2.69 2.81-3.91s-.31-4-2.81-4-2.81 2.8-2.81 4 .27 3.91 2.81 3.91zM55.56 3.72h9.81v2.41h-9.81z" fill="var(--color-contrast-higher)" />
              <circle cx="15" cy="15" r="15" fill="var(--color-primary)" />
            </svg>

          </a>

          <!-- 👇 icon buttons --mobile -->
          <div class="mega-nav__icon-btns mega-nav__icon-btns--mobile">
            @if (auth()->check())

            <a href="{{ route('profile.index') }}" class="mega-nav__icon-btn">

              <svg class="icon" viewBox="0 0 24 24">
                <title>Перейти к настройкам профиля</title>
                <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                  <circle cx="12" cy="6" r="4" />
                  <path d="M12 13a8 8 0 00-8 8h16a8 8 0 00-8-8z" />
                </g>
              </svg>
            </a>
                @else
                <a href="{{ route('login') }}" class="mega-nav__icon-btn">

                  <svg class="icon" viewBox="0 0 24 24">
                    <title>Войти или зарегистрироваться</title>
                    <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                      <circle cx="12" cy="6" r="4" />
                      <path d="M12 13a8 8 0 00-8 8h16a8 8 0 00-8-8z" />
                    </g>
                  </svg>
                </a>
                @endif

            <button class="reset mega-nav__icon-btn mega-nav__icon-btn--search js-tab-focus" aria-label="Toggle search" aria-controls="mega-nav-search">
              <svg class="icon" viewBox="0 0 24 24">
                <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                  <path d="M4.222 4.222l15.556 15.556" />
                  <path d="M19.778 4.222L4.222 19.778" />
                  <circle cx="9.5" cy="9.5" r="6.5" />
                </g>
              </svg>
            </button>

            <button class="reset mega-nav__icon-btn mega-nav__icon-btn--menu js-tab-focus" aria-label="Toggle menu" aria-controls="mega-nav-navigation">
              <svg class="icon" viewBox="0 0 24 24">
                <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                  <path d="M1 6h22" />
                  <path d="M1 12h22" />
                  <path d="M1 18h22" />
                </g>
              </svg>
            </button>
          </div>

          <div class="mega-nav__nav js-mega-nav__nav" id="mega-nav-navigation" role="navigation" aria-label="Main">
            <div class="mega-nav__nav-inner">
              <ul class="mega-nav__items">
                <li class="mega-nav__label">Menu</li>

                <!-- 👇 layout 1 -> tabbed content -->
                <li class="mega-nav__item js-mega-nav__item">
                  <button class="reset mega-nav__control js-mega-nav__control js-tab-focus">
                    Products
                    <i class="mega-nav__arrow-icon" aria-hidden="true">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                          <path d="M2 2l12 12" />
                          <path d="M14 2L2 14" />
                        </g>
                      </svg>
                    </i>
                  </button>

                  <div class="mega-nav__sub-nav-wrapper">
                    <div class="mega-nav__sub-nav mega-nav__sub-nav--layout-1">
                      <!-- 👇 links - visible on mobile -->
                      <ul class="mega-nav__sub-items">
                        <li class="mega-nav__sub-item">
                          <a href="#0" class="mega-nav__sub-link">
                            <span class="flex items-center gap-xs">

                              <i>Product One</i>
                            </span>
                          </a>
                        </li>

                        <li class="mega-nav__sub-item">
                          <a href="#0" class="mega-nav__sub-link">
                            <span class="flex items-center gap-xs">

                              <i>Product Two</i>
                            </span>
                          </a>
                        </li>

                        <li class="mega-nav__sub-item">
                          <a href="#0" class="mega-nav__sub-link">
                            <span class="flex items-center gap-xs">

                              <i>Product Three</i>
                            </span>
                          </a>
                        </li>
                      </ul>

                      <!-- 👇 tabs - visible on desktop -->
                      <div class="mega-nav__tabs grid gap-lg js-tabs" data-tabs-layout="vertical">
                        <ul class="col-4 mega-nav__tabs-controls js-tabs__controls" aria-label="Select a product">
                          <li>
                            <a href="#tabProduct1" class="mega-nav__tabs-control js-tab-focus" aria-selected="true">
                              <span class="flex items-center gap-xs">


                                <i class="margin-right-xxxs">Product One</i>

                                <svg class="icon icon--xs margin-left-auto" viewBox="0 0 16 16" aria-hidden="true">
                                  <path d="M5,2l6,6L5,14" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1" /></svg>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#tabProduct2" class="mega-nav__tabs-control js-tab-focus" aria-selected="true">
                              <span class="flex items-center gap-xs">


                                <i class="margin-right-xxxs">Product Two</i>

                                <svg class="icon icon--xs margin-left-auto" viewBox="0 0 16 16" aria-hidden="true">
                                  <path d="M5,2l6,6L5,14" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1" /></svg>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#tabProduct3" class="mega-nav__tabs-control js-tab-focus" aria-selected="true">
                              <span class="flex items-center gap-xs">


                                <i class="margin-right-xxxs">Product Three</i>

                                <svg class="icon icon--xs margin-left-auto" viewBox="0 0 16 16" aria-hidden="true">
                                  <path d="M5,2l6,6L5,14" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1" /></svg>
                              </span>
                            </a>
                          </li>
                        </ul>

                        <div class="col-8 js-tabs__panels">
                          <section id="tabProduct1" class="mega-nav__tabs-panel js-tabs__panel">
                            <a href="#0" class="mega-nav__tabs-img margin-bottom-md">

                            </a>

                            <div class="text-component">
                              <h1 class="text-xl">Product One</h1>
                              <p class="color-contrast-medium">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, quaerat.</p>
                              <p class="flex gap-xxs">
                                <a href="#0" class="btn btn--subtle">Learn More</a>
                                <a href="#0" class="btn btn--primary">Buy</a>
                              </p>
                            </div>
                          </section>

                          <section id="tabProduct2" class="mega-nav__tabs-panel js-tabs__panel">
                            <a href="#0" class="mega-nav__tabs-img margin-bottom-md">

                            </a>

                            <div class="text-component">
                              <h1 class="text-xl">Product Two</h1>
                              <p class="color-contrast-medium">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, quaerat.</p>
                              <p class="flex gap-xxs">
                                <a href="#0" class="btn btn--subtle">Learn More</a>
                                <a href="#0" class="btn btn--primary">Buy</a>
                              </p>
                            </div>
                          </section>

                          <section id="tabProduct3" class="mega-nav__tabs-panel js-tabs__panel">
                            <a href="#0" class="mega-nav__tabs-img margin-bottom-md">

                            </a>

                            <div class="text-component">
                              <h1 class="text-xl">Product Three</h1>
                              <p class="color-contrast-medium">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, quaerat.</p>
                              <p class="flex gap-xxs">
                                <a href="#0" class="btn btn--subtle">Learn More</a>
                                <a href="#0" class="btn btn--primary">Buy</a>
                              </p>
                            </div>
                          </section>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>

                <!-- 👇 layout 2 -> multiple lists -->
                <li class="mega-nav__item js-mega-nav__item">
                  <button class="reset mega-nav__control js-mega-nav__control js-tab-focus">
                    Lists
                    <i class="mega-nav__arrow-icon" aria-hidden="true">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                          <path d="M2 2l12 12" />
                          <path d="M14 2L2 14" />
                        </g>
                      </svg>
                    </i>
                  </button>

                  <div class="mega-nav__sub-nav-wrapper">
                    <div class="mega-nav__sub-nav mega-nav__sub-nav--layout-2">
               <ul class="mega-nav__sub-items">
                  <li class="mega-nav__label">Группа 1</li>
                  @foreach ($items as $item)
                  <li class="mega-nav__sub-item"><a href="{{ $item->link }}" class="mega-nav__sub-link">{{ $item->name }}</a></li>
                  @endforeach
                </ul>

                      <div class="mega-nav__card width-100% max-width-xs margin-x-auto">
                        <a href="#0" class="block radius-lg overflow-hidden">

                        </a>

                        <div class="margin-top-sm">
                          <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Browse all →</a></h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>

                <!-- 👇 layout 3 -> gallery -->
                <li class="mega-nav__item js-mega-nav__item">
                  <button class="reset mega-nav__control js-mega-nav__control js-tab-focus">
                    Gallery
                    <i class="mega-nav__arrow-icon" aria-hidden="true">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                          <path d="M2 2l12 12" />
                          <path d="M14 2L2 14" />
                        </g>
                      </svg>
                    </i>
                  </button>

                  <div class="mega-nav__sub-nav-wrapper">
                    <div class="mega-nav__sub-nav mega-nav__sub-nav--layout-3">
                      <div class="mega-nav__card">
                        <a href="#0" class="block radius-lg overflow-hidden">

                        </a>

                        <div class="margin-top-sm">
                          <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Clothing</a></h3>
                        </div>
                      </div>

                      <div class="mega-nav__card">
                        <a href="#0" class="block radius-lg overflow-hidden">

                        </a>

                        <div class="margin-top-sm">
                          <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Shoes</a></h3>
                        </div>
                      </div>

                      <div class="mega-nav__card">
                        <a href="#0" class="block radius-lg overflow-hidden">

                        </a>

                        <div class="margin-top-sm">
                          <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Home</a></h3>
                        </div>
                      </div>

                      <div class="mega-nav__card">
                        <a href="#0" class="block radius-lg overflow-hidden">

                        </a>

                        <div class="margin-top-sm">
                          <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Accessories</a></h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>

                <!-- 👇 layout 4 -> single list -->
                <li class="mega-nav__item js-mega-nav__item">
                  <button class="reset mega-nav__control js-mega-nav__control js-tab-focus">
                    Support
                    <i class="mega-nav__arrow-icon" aria-hidden="true">
                      <svg class="icon" viewBox="0 0 16 16">
                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                          <path d="M2 2l12 12" />
                          <path d="M14 2L2 14" />
                        </g>
                      </svg>
                    </i>
                  </button>

                  <div class="mega-nav__sub-nav-wrapper">
                    <div class="mega-nav__sub-nav mega-nav__sub-nav--layout-4">
                      <ul class="mega-nav__sub-items">
                        <li class="mega-nav__label">Help &amp; Support</li>
                        <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Documentation</a></li>
                        <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Questions &amp; Answers</a></li>
                        <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Contact us</a></li>
                      </ul>
                    </div>
                  </div>
                </li>

                <li class="mega-nav__label">Other</li>

                <!-- 👇 link -->
                <li class="mega-nav__item">
                  <a href="#0" class="mega-nav__control">Link</a>
                </li>
              </ul>

              <ul class="mega-nav__items">
                <!-- 👇 icon buttons --desktop -->
                @if (auth()->check())
                <li class="mega-nav__icon-btns mega-nav__icon-btns--desktop">
                  <div class="dropdown inline-block js-dropdown">
                    <div class="mega-nav__icon-btn dropdown__wrapper inline-block">
                      <a href="#0" class="color-inherit flex height-100% width-100% flex-center dropdown__trigger js-dropdown__trigger">
                        @if (Auth::user()->getFirstMediaUrl('avatars', 'thumb'))

                            <img class="radius-50%" src="{{ Auth::user()->getFirstMediaUrl('avatars', 'thumb') }}">

                          @else
                        <svg class="icon" viewBox="0 0 24 24">
                          <title>Go to account settings</title>
                          <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                            <circle cx="12" cy="6" r="4" />
                            <path d="M12 13a8 8 0 00-8 8h16a8 8 0 00-8-8z" />
                          </g>
                        </svg>
                        @endif
                      </a>

                      <ul class="dropdown__menu js-dropdown__menu" aria-label="submenu">
                        <li><a href="{{ route('profile.index') }}" class="dropdown__item">Профиль</a></li>
                        <li class="dropdown__separator" role="separator"></li>

                        <li><a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown__item">Выйти</a></li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                        @can('view-admin-panel')
                        <li><a href="/admin/dashboard" class="dropdown__item">Админка</a></li>
                        @endcan
                      </ul>
                    </div>
                  </div>

                  <button class="reset mega-nav__icon-btn mega-nav__icon-btn--search js-tab-focus" aria-label="Toggle search" aria-controls="mega-nav-search">
                    <svg class="icon" viewBox="0 0 24 24">
                      <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                        <path d="M4.222 4.222l15.556 15.556" />
                        <path d="M19.778 4.222L4.222 19.778" />
                        <circle cx="9.5" cy="9.5" r="6.5" />
                      </g>
                    </svg>
                  </button>
                </li>
                @else
                <li class="mega-nav__item">
                  <a href="{{ route('login') }}" class="btn btn--primary mega-nav__btn">Войти</a>
                </li>
                @endif

                <!-- 👇 button -->
                <li class="mega-nav__item">
                  <a href="#0" class="btn btn--primary mega-nav__btn">Download</a>
                </li>
              </ul>
            </div>
          </div>

          <!-- 👇 search -->
          <div class="mega-nav__search js-mega-nav__search" id="mega-nav-search">
            <div class="mega-nav__search-inner">
              <input class="form-control width-100%" type="reset search" name="megasite-search" id="megasite-search" placeholder="Search..." aria-label="Search">

              <div class="margin-top-lg">
                <p class="mega-nav__label">Quick Links</p>

                <ul>
                  <li><a href="#0" class="mega-nav__quick-link">Find a Store</a></li>
                  <li><a href="#0" class="mega-nav__quick-link">Your Orders</a></li>
                  <li><a href="#0" class="mega-nav__quick-link">Documentation</a></li>
                  <li><a href="#0" class="mega-nav__quick-link">Questions &amp; Answers</a></li>
                  <li><a href="#0" class="mega-nav__quick-link">Contact Us</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </header>
