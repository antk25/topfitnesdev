@extends('layouts.base')
{{-- Переопределяем секцию content от базового шаблона --}}
@section('content')
<section class="padding-y-xl">
<div class="container max-width-lg">
  <div class="text-component text-center margin-bottom-lg">
      <h1>Каталог фитнес-браслетов</h1>

      <p class="hide@md no-js:is-hidden"><button class="btn btn--primary" aria-controls="sidebar">Показать
              фильтры</button></p>
  </div>

  <div class="grid gap-md@md items-start@md">
      <aside class="sidebar sidebar--static@md col-3@md js-sidebar"
          data-static-class="sidebar--sticky-on-desktop z-index-1 bg-gradient-5" id="sidebar"
          aria-labelledby="sidebar-title">
          <div class="sidebar__panel">
              <header class="sidebar__header z-index-2">
                  <h3 class="text-md text-truncate" id="sidebar-title">Фильтры</h3>

                  <button class="reset sidebar__close-btn js-sidebar__close-btn js-tab-focus">
                      <svg class="icon icon--xs" viewBox="0 0 16 16">
                          <title>Close panel</title>
                          <g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                              stroke-linejoin="round" stroke-miterlimit="10">
                              <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                              <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                          </g>
                      </svg>
                  </button>
              </header>

              <div class="position-relative z-index-1">
                  <!-- start sidebar content -->
                  <div class="padding-sm">
                      <form action="/bracelets" method="get" id="braceletsFilter">
                          <div class="flex flex-column items-start margin-y-sm padding-x-md padding-x-xs@md">
                              <label class="form-label margin-bottom-xxxs text-bold" for="title">Название</label>
                              <input class="form-control width-100%" type="text" name="title" id="title"
                                  value="{{ request()->title }}">
                          </div>

                          <div class="padding-top-xxxs padding-x-md padding-bottom-sm padding-x-xs@md">
                              <ul class="flex flex-column gap-xxxs">
                                  <li>
                                      <input class="checkbox" type="checkbox" name="pulse_permanent"
                                          id="pulse_permanent" value="1" {{ request()->pulse_permanent == 1 ?
                                      'checked' : false }}>
                                      <label for="pulse_permanent">Постоянное измерение пульса</label>
                                  </li>
                                  <li>
                                      <input class="checkbox" type="checkbox" name="oxy_permanent"
                                          id="oxy_permanent" value="1" {{ request()->oxy_permanent == 1 ?
                                      'checked' : false }}>
                                      <label for="oxy_permanent">Измерение уровня кислорода</label>
                                  </li>
                                  <li>
                                      <input class="checkbox" type="checkbox" name="ad_permanent"
                                          id="ad_permanent" value="1" {{ request()->ad_permanent == 1 ? 'checked'
                                      : false }}>
                                      <label for="ad_permanent">Измерение АД</label>
                                  </li>
                              </ul>
                          </div>

                          <label class="form-label margin-bottom-xxxs text-bold" for="disp_tech">Технология
                              дисплея:</label>

                          <div class="select">
                              <select class="select__input form-control" name="disp_tech" id="disp_tech">
                                  <option value="">Выберите тип</option>
                                  <option value="AMOLED" {{ request()->disp_tech == 'AMOLED' ? 'selected' : ''
                                      }}>AMOLED</option>
                                  <option value="IPS" {{ request()->disp_tech == 'IPS' ? 'selected' : '' }}>IPS
                                  </option>
                                  <option value="TFT" {{ request()->disp_tech == 'TFT' ? 'selected' : '' }}>TFT
                                  </option>
                                  <option value="LED" {{ request()->disp_tech == 'LED' ? 'selected' : '' }}>LED
                                  </option>
                                  <option value="OLED" {{ request()->disp_tech == 'OLED' ? 'selected' : '' }}>OLED
                                  </option>
                                  <option value="TN" {{ request()->disp_tech == 'TN' ? 'selected' : '' }}>TN
                                  </option>
                              </select>

                              <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                                  <g stroke-width="1" stroke="currentColor">
                                      <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-miterlimit="10"
                                          points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                                  </g>
                              </svg>
                          </div>
                          <div class="margin-top-xs">
                            <div class="btns gap-xs">
                              <button type="submit" class="btn btn--primary btn--sm">Применить</button>
                              <button type="reset" class="btn btn--subtle btn--sm">Сбросить</button>
                            </div>
                          </div>
                      </form>
                  </div>
                  <!-- end sidebar content -->
              </div>
          </div>
      </aside>

      <main class="position-relative z-index-1 col-9@md">
          <!-- start main content -->
          <div class="padding-y-md padding-0@md">
              <div class="grid-switch js-grid-switch" data-gs-item-class-1="col-12 col-4@md"
                  data-gs-item-class-2="col-12" data-gs-content-class-1="card-v10--state-1"
                  data-gs-content-class-2="card-v10--state-2">
                  <div class="margin-bottom-sm text-right display@md no-js:is-hidden">
                      <div class="btns btns--radio js-grid-switch__controller">
                          <div>
                              <input type="radio" name="radio-view-option" id="radio-grid" value="1" checked>
                              <label class="btns__btn btns__btn--icon" for="radio-grid">
                                  <svg class="icon icon--xs" viewBox="0 0 16 16">
                                      <title>Grid</title>
                                      <g>
                                          <path
                                              d="M6,0H1C0.4,0,0,0.4,0,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1V1C7,0.4,6.6,0,6,0z">
                                          </path>
                                          <path
                                              d="M15,0h-5C9.4,0,9,0.4,9,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z">
                                          </path>
                                          <path
                                              d="M6,9H1c-0.6,0-1,0.4-1,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1v-5C7,9.4,6.6,9,6,9z">
                                          </path>
                                          <path
                                              d="M15,9h-5c-0.6,0-1,0.4-1,1v5c0,0.6,0.4,1,1,1h5c0.6,0,1-0.4,1-1v-5C16,9.4,15.6,9,15,9z">
                                          </path>
                                      </g>
                                  </svg>
                              </label>
                          </div>

                          <div>
                              <input type="radio" name="radio-view-option" id="radio-list" value="2">
                              <label class="btns__btn btns__btn--icon" for="radio-list">
                                  <svg class="icon icon--xs" viewBox="0 0 16 16">
                                      <title>List</title>
                                      <g>
                                          <rect width="16" height="3"></rect>
                                          <rect y="6" width="16" height="3"></rect>
                                          <rect y="12" width="16" height="3"></rect>
                                      </g>
                                  </svg>
                              </label>
                          </div>
                      </div>
                  </div>

                  <ul class="grid gap-md">
                      @foreach ($bracelets as $bracelet)
                      <li class="js-grid-switch__item">

                          <div class="card-v10 card-v10--state-1 height-100% js-grid-switch__content">
                              <a class="card-v10__img-link radius-lg shadow-lg"
                                  href="bracelets/{{ $bracelet->slug }}">
                                  <img src="assets/img/169-500x300.jpg" alt="Image description">
                              </a>

                              <div class="card-v10__content-wrapper">
                                  <div class="card-v10__content bg shadow-xs radius-lg">
                                      <div class="card-v10__body">
                                          <p class="card-v10__label text-uppercase color-primary letter-spacing-md">
                                              Category</p>

                                          <div class="text-component">
                                              <h1 class="card-v10__title"><a class="color-contrast-higher"
                                                      href="bracelets/{{ $bracelet->slug }}"> {{
                                                      $bracelet->subtitle }}</a></h1>
                                              <p class="card-v10__excerpt color-contrast-medium">{{
                                                  $bracelet->oxy_permanent == '1' ? 'Измерение уровня кислорода' :
                                                  '' }}</p>
                                              <p class="card-v10__excerpt color-contrast-medium">{{
                                                  $bracelet->pulse_permanent == '1' ? 'Постоянное измерение
                                                  пульса' : '' }}</p>
                                              <p class="card-v10__excerpt color-contrast-medium">{{
                                                  $bracelet->ad_permanent == '1' ? 'Измерение АД' : '' }}</p>
                                              <p class="card-v10__excerpt color-contrast-medium">
                                                  <strong>Технология дисплея:</strong> {{ $bracelet->disp_tech }}
                                              </p>
                                          </div>
                                      </div>

                                      <footer class="card-v10__footer">
                                          <ul class="card-v10__social-list">
                                              <li class="card-v10__social-item">
                                                  <button
                                                      class="reset card-v10__social-btn radius-md js-tab-focus"
                                                      aria-label="Like this content along with 12K other people">
                                                      <svg class="icon" viewBox="0 0 12 12">
                                                          <g>
                                                              <path
                                                                  d="M11.045,2.011a3.345,3.345,0,0,0-4.792,0c-.075.075-.15.225-.225.3-.075-.074-.15-.224-.225-.3a3.345,3.345,0,0,0-4.792,0,3.345,3.345,0,0,0,0,4.792l5.017,4.718L11.045,6.8A3.484,3.484,0,0,0,11.045,2.011Z">
                                                              </path>
                                                          </g>
                                                      </svg>

                                                      <span>12K</span>
                                                  </button>
                                              </li>

                                              <li class="card-v10__social-item">
                                                  <button
                                                      class="reset card-v10__social-btn radius-md js-tab-focus"
                                                      aria-label="Comment">
                                                      <svg class="icon" viewBox="0 0 12 12">
                                                          <g>
                                                              <path
                                                                  d="M6,0C2.691,0,0,2.362,0,5.267s2.691,5.266,6,5.266a6.8,6.8,0,0,0,1.036-.079l2.725,1.485A.505.505,0,0,0,10,12a.5.5,0,0,0,.5-.5V8.711A4.893,4.893,0,0,0,12,5.267C12,2.362,9.309,0,6,0Z">
                                                              </path>
                                                          </g>
                                                      </svg>

                                                      <span>Comment</span>
                                                  </button>
                                              </li>

                                              <li class="card-v10__social-item">
                                                  <button
                                                      class="reset card-v10__social-btn radius-md js-tab-focus"
                                                      aria-label="Share">
                                                      <svg class="icon" viewBox="0 0 12 12">
                                                          <g>
                                                              <path
                                                                  d="M6,4C2.975,4,0,5.8,0,11,1.575,8.45,3.6,8,6,8v3l6-5L6,1Z">
                                                              </path>
                                                          </g>
                                                      </svg>

                                                      <span>Share</span>
                                                  </button>
                                              </li>
                                          </ul>
                                      </footer>
                                  </div>
                              </div>
                          </div>
                      </li>
                      @endforeach
                  </ul>
                  {{ $bracelets->links() }}
              </div>
          </div>
          <!-- end main content -->
      </main>
  </div>
</div>
</section>
@endsection