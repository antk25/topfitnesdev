@extends('layouts.base')
{{-- Переопределяем секцию content от базового шаблона --}}
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

            <div class="search-input search-input--icon-left margin-bottom-sm">
              <form>
                <input class="search-input__input form-control" type="search" name="filter[name]" id="filter[name]" placeholder="Поиск по названию..." aria-label="Search">

                <button class="search-input__btn">
                  <svg class="icon" viewBox="0 0 20 20"><title>Submit</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="8" cy="8" r="6"/><line x1="12.242" y1="12.242" x2="18" y2="18"/></g></svg>
                </button>

            </div>


            <fieldset>

                <legend class="form-legend">Защита</legend>

                <ul class="flex flex-column gap-xxxs">
                  <li>
                    <input class="radio radio--bg" type="radio" id="radio-1" name="filter[protect_stand]" value="high"
                    @if (!empty($request->filter['protect_stand']) && $request->filter['protect_stand'] == 'high')
                     checked
                    @endif>

                    <label for="radio-1" class="text-sm">Высокая</label>
                    <p class="text-xs color-contrast-medium x-iq">Плавание, дождь, пыль</p>
                  </li>

                  <li>
                    <input class="radio radio--bg" type="radio" id="radio-2" name="filter[protect_stand]" value="medium"
                    @if (!empty($request->filter['protect_stand']) && $request->filter['protect_stand'] == 'medium')
                     checked
                    @endif>
                    <label for="radio-2" class="text-sm">Средняя</label>
                    <p class="text-xs color-contrast-medium x-iq">Мытье рук, пыль</p>
                  </li>

                </ul>
                          </fieldset>


                  <ul class="flex flex-column gap-xxxs text-sm">
                    <li>
                      <input class="checkbox" type="checkbox" name="filter[heart_rate]" value="1" id="filter[heart_rate]"
                      @if (!empty($request->filter['heart_rate']) && $request->filter['heart_rate'] == true)
                      checked
                      @endif>
                      <label for="filter[heart_rate]">Постоянное измерение пульса</label>
                    </li>
                    <li>
                      <input class="checkbox" type="checkbox" name="filter[blood_oxy]" value="1" id="filter[blood_oxy]"
                      @if (!empty($request->filter['blood_oxy']) && $request->filter['blood_oxy'] == true)
                      checked
                      @endif>
                      <label for="filter[blood_oxy]">Измерение кислорода в крови</label>
                    </li>
                    <li>
                      <input class="checkbox" type="checkbox" name="filter[blood_pressure]" value="1" id="filter[blood_pressure]"
                      @if (!empty($request->filter['blood_pressure']) && $request->filter['blood_pressure'] == true)
                      checked
                      @endif>
                      <label for="filter[blood_pressure]">Измерение артериального давления</label>
                    </li>
                    <li>
                      <input class="checkbox" type="checkbox" name="filter[smart_alarm]" value="1" id="filter[smart_alarm]"
                      @if (!empty($request->filter['smart_alarm']) && $request->filter['smart_alarm'] == true)
                      checked
                      @endif>
                      <label for="filter[smart_alarm]">Умный будильник</label>
                    </li>
                    <li>
                      <input class="checkbox" type="checkbox" name="filter[gps]" value="1" id="filter[gps]"
                      @if (!empty($request->filter['gps']) && $request->filter['gps'] == true)
                      checked
                      @endif>
                      <label for="filter[gps]">GPS</label>
                    </li>

                  </ul>

                  <button class="btn btn-sm btn--primary margin-sm" type="submit">Применить</button>
                        </form>


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
@endsection
@section('content')

      <div class="text-component text-center margin-bottom-lg">
          <h1>Каталог фитнес-браслетов</h1>
      </div>




                    @foreach ($bracelets as $bracelet)
                    <div class="border radius-md padding-sm grid gap-md gap-lg@lg margin-bottom-sm shadow-sm">

                        <div class="col-2">
                        <a href="katalog/{{ $bracelet->slug }}"  aria-label="Подробнее о браслете {{ $bracelet->name }}">
                            <img src="{{ $bracelet->getFirstMediaUrl('bracelet', 'thumb') }}">
                        </a>
                        </div>

                        <div class="col-7">
                            <p class="text-md"><a href="katalog/{{ $bracelet->slug }}">{{ $bracelet->subtitle }}</a></p>
                            <div class="text-sm margin-top-sm">
                                <span class="color-contrast-medium">Поддержка NFC:</span> @if ($bracelet->nfc != '') Да @else Нет @endif<br>
                                <span class="color-contrast-medium">Пульсоксиметр:</span> @if ($bracelet->oxy_permanent != '') Да @else Нет @endif<br>
                                <span class="color-contrast-medium">Измерение давления:</span> @if ($bracelet->ad_permanent != '') Да @else Нет @endif<br>
                                <span class="color-contrast-medium">Совместимость:</span> {{ $bracelet->compatibility }}<br>
                                <span class="color-contrast-medium">Разрешение дисплея:</span> {{ $bracelet->disp_resolution }}<br>
                                <span class="color-contrast-medium">Постоянное измерение пульса:</span> {{ $bracelet->heart_rate }}<br>
                                <span class="color-contrast-medium">GPS:</span> {{ $bracelet->gps }}<br>
                                <span class="color-contrast-medium">Защита:</span> @foreach ($bracelet->protect_stand as $item)
                                   {{ $item }},
                                @endforeach<br>


                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-sm">
                            @if ($bracelet->avg_price != '')
                            <span class="color-contrast-medium">Средняя цена:</span> {{ $bracelet->avg_price }} руб<br>
                                @endif
                            </div>
                        </div>
                        </div>
                    @endforeach


@endsection
@section('footerScripts')