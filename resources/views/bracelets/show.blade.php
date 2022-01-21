@extends('layouts.base')

@section('content')

    <div class="container max-width-lg padding-top-md">
        {{ Breadcrumbs::render('bracelet', $bracelet) }}
    </div>

    <div class="container max-width-adaptive-lg padding-top-md">
        <div class="grid gap-md flex-row-reverse@md">
            <div class="col-3@md">
                {{--  Navigation to page --}}
                <div class="toc toc--static@md position-sticky@md text-sm@md js-toc">
                    <button class="reset toc__control no-js:is-hidden js-tab-focus js-toc__control" aria-controls="toc">
                        <span class="toc__control-text">
                            <i class="js-toc__control-label">Навигация по странице <span
                                    class="sr-only">- нажмите для выбора раздела.</span></i>
                            <i aria-hidden="true">Выбрать</i>
                        </span>

                        <svg class="icon toc__icon-arrow margin-left-xxxs no-js:is-hidden" viewBox="0 0 16 16"
                             aria-hidden="true">
                            <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square"
                               stroke-miterlimit="10">
                                <path d="M2 2l12 12"/>
                                <path d="M14 2L2 14"/>
                            </g>
                        </svg>
                    </button>

                    <nav class="toc__nav">
                        <ul class="toc__list js-toc__list">
                            <li class="toc__label" tabindex="0">Навигация по странице</li>
                            <li><a class="toc__link js-smooth-scroll" href="#toc1">Рейтинг и цены</a></li>
                            @if($bracelet->plus)
                                <li><a class="toc__link js-smooth-scroll" href="#toc2">Плюсы и минусы</a></li>
                            @endif
                            <li><a class="toc__link js-smooth-scroll" href="#toc3">Характеристики</a>
                                <ul class="toc__list">
                                    <li><a class="toc__link js-smooth-scroll" href="#toc3-1">Общие</a></li>
                                    <li><a class="toc__link js-smooth-scroll" href="#toc3-2">Конструкция</a></li>
                                    <li><a class="toc__link js-smooth-scroll" href="#toc3-3">Дисплей</a></li>
                                    <li><a class="toc__link js-smooth-scroll" href="#toc3-4">Модули и датчики</a></li>
                                    <li><a class="toc__link js-smooth-scroll" href="#toc3-5">Связь</a></li>
                                    <li><a class="toc__link js-smooth-scroll" href="#toc3-6">Функционал</a></li>
                                    <li><a class="toc__link js-smooth-scroll" href="#toc3-7">Аккумулятор</a></li>
                                </ul>
                            </li>
                            @if ($bracelet->reviews->count())
                                <li><a class="toc__link js-smooth-scroll" href="#toc4">Отзывы</a></li>
                            @endif
                            <li><a class="toc__link js-smooth-scroll" href="#toc5">Добавить отзыв</a></li>
                        </ul>
                    </nav>
                </div>
                {{-- End navigation to page --}}
            </div>

            <div class="col-9@md">
                <div class="toc-content js-toc-content">
                    <div class="margin-y-sm text-component">
                        <h1 id="toc1" class="toc-content__target">{{ $bracelet->subtitle }}</h1>
                    </div>
                    <div class="grid gap-xxs">
                        <div class="col-5@md">
                            {{-- Gallery --}}
                            <ul class="exp-gallery grid gap-xs js-exp-gallery" data-controls="expLightbox"
                                data-placeholder="assets/img/expandable-img-gallery-placeholder.svg">
                                @foreach ($media as $image)
                                    <li class="col-4 col-3@sm js-exp-gallery__item">
                                        <figure class="border border-contrast-middle border-opacity-30% shadow-xs">
                                            <img src="{{ $image->getFullUrl('320') }}"
                                                 data-modal-src="{{ $image->getFullUrl() }}" alt="Image Description">
                                            <figcaption class="sr-only js-exp-gallery__caption"></figcaption>
                                        </figure>
                                    </li>
                                @endforeach
                            </ul>
                            {{-- End gallery --}}
                        </div>
                        <div class="col-7@md">
                            {{-- Ratings --}}
                            <div class="table-card bg radius-md padding-sm shadow-sm">

                                @foreach ($bracelet->grades as $grade)
                                    <div
                                        class="progress-bar progress-bar--color-update js-progress-bar flex flex-column items-center margin-y-xxs">
                                        <p class="sr-only" aria-live="polite" aria-atomic="true">Оценка составляет <span
                                                class="js-progress-bar__aria-value">{{ $grade->pivot->value * 10 }}%</span>
                                        </p>

                                        <div class="margin-y-xxs width-100%">{{ $grade->name }} <span
                                                class="text-bold float-right">{{ number_format($grade->pivot->value, 1) }}</span>
                                        </div>

                                        <div class="progress-bar__bg width-100%" aria-hidden="true">
                                            <div class="progress-bar__fill"
                                                 style="width: {{ $grade->pivot->value * 10 }}%;"></div>
                                        </div>
                                    </div>

                                @endforeach
                                <div class="text-center">
                                    <span class="text-xxxl"><svg class="icon" viewBox="0 0 24 24"
                                                                 xmlns="http://www.w3.org/2000/svg"><path
                                                d="M22.765 9.397a.676.676 0 00-.538-.453l-6.64-1.015-2.976-6.34c-.222-.474-.999-.474-1.222 0L8.413 7.93l-6.64 1.015a.674.674 0 00-.381 1.139l4.824 4.945-1.14 6.99a.673.673 0 00.992.699L12 19.439l5.931 3.278a.672.672 0 00.993-.699l-1.14-6.99 4.824-4.945a.675.675 0 00.157-.686z"
                                                fill="#ffc107"/><path
                                                d="M5.574 15.362l-1.267 7.767a.751.751 0 001.103.777L12 20.264l6.59 3.643a.748.748 0 001.103-.778l-1.267-7.767 5.36-5.494a.75.75 0 00-.423-1.265l-7.378-1.127L12.678.432c-.247-.526-1.11-.526-1.357 0L8.015 7.476.637 8.603a.75.75 0 00-.424 1.265zm3.063-6.464a.75.75 0 00.565-.422L12 2.515l2.798 5.96a.747.747 0 00.565.422l6.331.967-4.605 4.72a.75.75 0 00-.204.645l1.08 6.617-5.602-3.096a.755.755 0 00-.726 0l-5.602 3.096 1.08-6.617a.75.75 0 00-.204-.645l-4.605-4.72z"/></svg> {{ $bracelet->grade_bracelet }}</span><br>
                                    Средний рейтинг
                                </div>
                            </div>
                            {{-- End Ratings --}}
                        </div>

                    </div>

                    {{-- Sellers --}}
                    @if ($bracelet->sellers->count())

                        <section class="margin-y-md">
                            <div class="text-divider"><span>Где купить</span></div>
                            <div class="table-card bg radius-md padding-sm shadow-sm">

                                <div class="tbl text-sm">
                                    <table class="tbl__table" aria-label="Table Example">
                                        <thead class="tbl__header sr-only">
                                        <tr class="tbl__row">
                                            <th class="tbl__cell text-left" scope="col">
                                                        <span
                                                            class="text-xs text-uppercase letter-spacing-lg font-semibold">Магазин</span>
                                            </th>

                                            <th class="tbl__cell text-left" scope="col">
                                                        <span
                                                            class="text-xs text-uppercase letter-spacing-lg font-semibold">Цена</span>
                                            </th>

                                            <th class="tbl__cell text-right" scope="col">
                                                        <span
                                                            class="text-xs text-uppercase letter-spacing-lg font-semibold">Купить</span>
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody class="tbl__body">
                                        @foreach ($bracelet->sellers as $seller)
                                            <tr class="tbl__row">
                                                <td class="tbl__cell text-md text-bold"
                                                    role="cell">{{ $seller->name }}</td>

                                                <td class="tbl__cell" role="cell">
                                                    @if ($seller->pivot->old_price != '')
                                                        <del
                                                            class="text-line-through text-bold color-contrast-medium margin-right-xxs">{{ $seller->pivot->old_price }}</del>
                                                        <a class="link-fx-1 color-contrast-higher text-bold color-success"
                                                           href="{{ $seller->pivot->link }}">
                                                            <span>{{ $seller->pivot->price }}</span>
                                                            <svg class="icon" viewBox="0 0 32 32"
                                                                 aria-hidden="true">
                                                                <g fill="none" stroke="currentColor"
                                                                   stroke-linecap="round"
                                                                   stroke-linejoin="round">
                                                                    <circle cx="16" cy="16" r="15.5"/>
                                                                    <line x1="10" y1="18" x2="16" y2="12"/>
                                                                    <line x1="16" y1="12" x2="22" y2="18"/>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <a class="link-fx-1 color-contrast-higher text-bold"
                                                           href="{{ $seller->pivot->link }}">
                                                            <span>{{ $seller->pivot->price }}</span>
                                                            <svg class="icon" viewBox="0 0 32 32"
                                                                 aria-hidden="true">
                                                                <g fill="none" stroke="currentColor"
                                                                   stroke-linecap="round"
                                                                   stroke-linejoin="round">
                                                                    <circle cx="16" cy="16" r="15.5"/>
                                                                    <line x1="10" y1="18" x2="16" y2="12"/>
                                                                    <line x1="16" y1="12" x2="22" y2="18"/>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </td>

                                                <td class="tbl__cell" role="cell">
                                                    <div class="flex justify-end">
                                                        <a rel="nofollow" target="_blank"
                                                           href="{{ $seller->pivot->link }}"
                                                           class="btn btn--primary">Купить</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    @endif
                    {{-- End sellers --}}
                    {{-- Plus and Minus --}}
                    @if($bracelet->plus)
                        <div class="t-article-v4__divider margin-y-md" aria-hidden="true"><span></span></div>
                        <section class="toc-content__target" id="toc2">
                            <div class="container grid">
                                <div class="col-6@sm">
                                    <h3 class="margin-y-sm text-center">Плюсы</h3>

                                    <ul class="list list--icons">
                                        @foreach ($bracelet->plus as $plus)
                                            <li>
                                                <div class="flex items-start">
                                                    <svg class="list__icon icon" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                                  stroke-linecap="square" stroke-miterlimit="10"
                                                                  stroke-width="2"/>
                                                    </svg>

                                                    <div>{{ $plus }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-6@sm">
                                    <h3 class="margin-y-sm text-center">Минусы</h3>
                                    <ul class="list list--icons">
                                        @foreach ($bracelet->minus as $minus)
                                            <li>
                                                <div class="flex items-start">
                                                    <svg class="list__icon icon" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                                           stroke-miterlimit="10" stroke-width="2">
                                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                                        </g>
                                                    </svg>

                                                    <div>{{ $minus }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </section>
                    @endif
                    {{-- End plus and minus --}}

                    {{-- Overview --}}
                    @if($bracelet->overview)
                        <div class="text-divider"><span>Подробный обзор</span></div>
                        <a class="banner" href="#" aria-label="Shop Now">
                            <div class="grid flex-row-reverse@md">
                                <div class="col-6@md overflow-hidden" aria-hidden="true">
                                    <div class="banner__figure width-100%"
                                         style="background-image: url({{ $bracelet->overview->getFirstMediaUrl('overviews') }});"></div>
                                </div>

                                <div class="col-6@md">
                                    <div
                                        class="text-component text-space-y-md height-100% flex flex-column padding-md padding-lg@md">
                                        <h2>{{ $bracelet->overview->name }}</h2>
                                        <p class="margin-top-sm margin-top-md@md"><span
                                                class="banner__link"><i>Полный обзор</i></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                    {{-- End overview --}}

                    {{-- Ratings --}}
                            <div class="text-divider"><span>Участвует в рейтингах</span></div>
                            <ul class="list list--ol">
                                @foreach ($bracelet->ratings as $rating)

                                    <li class="list-item arrow-list4">
                                        <a href="/{{ $rating->slug }}">{{ $rating->name }}</a> <span class="text-sm">на {{ $rating->pivot->position }} месте</span>
                                    </li>

                                @endforeach
                            </ul>
                    {{-- End ratings --}}

                    {{-- Manuals + comparisons --}}
                    <div class="text-divider"><span>Все материалы по браслету</span></div>
                    <ul class="list list--ol">
                        @foreach ($bracelet->manuals as $manual)
                            <li class="list-item arrow-list4">
                                <a href="manuals/{{ $manual->slug }}">{{ $manual->name }}</a>
                            </li>
                        @endforeach
                        @foreach ($bracelet->comparisons as $comparison)
                            <li class="list-item arrow-list4">
                                <a href="comparisons/{{ $comparison->slug }}">{{ $comparison->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    {{-- End manuals + comparisons --}}


                </div>



                <div id="expLightbox" class="modal exp-lightbox bg js-modal js-exp-lightbox" data-animation="on"
                     data-modal-first-focus=".js-exp-lightbox__body">
                    <div class="exp-lightbox__content pointer-events-none">
                        <header class="exp-lightbox__header">
                            <h3 class="exp-lightbox__title pointer-events-auto">Галерея</h2>

                                <menu class="menu-bar menu-bar--expanded@md pointer-events-auto js-menu-bar"
                                      data-menu-class="menu--overlay">
                                    <li class="menu-bar__item menu-bar__item--trigger js-menu-bar__trigger"
                                        role="menuitem" aria-label="More options">
                                        <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                                            <circle cx="8" cy="7.5" r="1.5"/>
                                            <circle cx="1.5" cy="7.5" r="1.5"/>
                                            <circle cx="14.5" cy="7.5" r="1.5"/>
                                        </svg>
                                    </li>

                                    <li class="menu-bar__item js-modal__close" role="menuitem">
                                        <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 24 24">
                                            <g stroke-linecap="square" stroke-linejoin="miter"
                                               stroke-miterlimit="10" stroke-width="2" stroke="currentColor"
                                               fill="none">
                                                <line x1="19" y1="5" x2="5" y2="19"></line>
                                                <line x1="19" y1="19" x2="5" y2="5"></line>
                                            </g>
                                        </svg>
                                        <span class="menu-bar__label reset">Закрыть</span>
                                    </li>
                                </menu>
                        </header>

                        <div class="exp-lightbox__body slideshow slideshow--transition-slide js-exp-lightbox__body"
                             data-swipe="on" data-navigation="off" data-zoom="on">
                            <ul class="slideshow__content js-exp-lightbox__slideshow">
                                <!-- gallery created in JS -->
                            </ul>

                            <ul>
                                <li class="slideshow__control js-slideshow__control">
                                    <button class="reset slideshow__btn pointer-events-auto js-tab-focus">
                                        <svg class="icon" viewBox="0 0 32 32"><title>Show previous slide</title>
                                            <path
                                                d="M20.768,31.395L10.186,16.581c-0.248-0.348-0.248-0.814,0-1.162L20.768,0.605l1.627,1.162L12.229,16 l10.166,14.232L20.768,31.395z"></path>
                                        </svg>
                                    </button>
                                </li>

                                <li class="slideshow__control js-slideshow__control">
                                    <button class="reset slideshow__btn pointer-events-auto js-tab-focus">
                                        <svg class="icon" viewBox="0 0 32 32"><title>Show next slide</title>
                                            <path
                                                d="M11.232,31.395l-1.627-1.162L19.771,16L9.605,1.768l1.627-1.162l10.582,14.813 c0.248,0.348,0.248,0.814,0,1.162L11.232,31.395z"></path>
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="t-article-v4__divider margin-y-lg" aria-hidden="true"><span></span></div>

                <section class="max-width-adaptive-sm container">
                    <div class="text-component text-center">
                        <h2 id="toc3" class="toc-content__target">Характеристики</h2>
                    </div>
                    <table class="prop-table width-100% text-sm" aria-label="Характеристики {{ $bracelet->title }}">
                        <tbody class="prop-table__body">

                        <tr class="text-md text-bold">
                            <th class="text-center color-primary padding-y-sm toc-content__target" colspan="2"
                                id="toc3-1">Общие
                            </th>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Год выпуска</th>
                            <td class="prop-table__cell">{{ $bracelet->year }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Страна-производитель</th>
                            <td class="prop-table__cell">{{ $bracelet->country }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Совместимость</th>
                            <td class="prop-table__cell">
                                @foreach($bracelet->compatibility as $item)
                                    {{ $item }}
                                @endforeach
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Приложение-ассистент</th>
                            <td class="prop-table__cell">{{ $bracelet->assistant_app }}</td>
                        </tr>


                        <tr class="text-md text-bold">
                            <th class="text-center color-primary padding-y-sm toc-content__target" colspan="2"
                                id="toc3-2">Конструкция
                            </th>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Материал ремешка</th>
                            <td class="prop-table__cell">
                                @foreach ($bracelet->material as $material)
                                    @if ($loop->last)
                                        {{ $material }}
                                    @else
                                        {{ $material }},
                                    @endif
                                @endforeach
                            </td>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Сменный браслет/ремешок</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->replaceable_strap == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Регулировка длины браслета</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->lenght_adj == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Возможные цвета браслета</th>
                            <td class="prop-table__cell">
                                <fieldset class="color-swatches  js-color-swatches">
                                    <legend
                                        class="color-swatches__legend text-sm color-contrast-medium margin-bottom-xs"
                                        aria-live="polite" aria-atomic="true">Цвет: <span
                                            class="color-swatches__color color-contrast-high js-color-swatches__color"></span>
                                    </legend>
                                    <select class="js-color-swatches__select" aria-label="Select a color">
                                        @foreach ($bracelet->colors as $color)
                                            @switch($color)
                                                @case('голубой')
                                                <option value="голубой" data-style="background-color: #00bfff;">
                                                    Голубой
                                                </option>
                                                @break
                                                @case('желтый')
                                                <option value="желтый" data-style="background-color: #ffff00;">
                                                    Желтый
                                                </option>
                                                @break
                                                @case('красный')
                                                <option value="красный" data-style="background-color: #ff0000;">
                                                    Красный
                                                </option>
                                                @break
                                                @case('оранжевый')
                                                <option value="оранжевый" data-style="background-color: #ffa500;">
                                                    Оранжевый
                                                </option>
                                                @break
                                                @case('розовый')
                                                <option value="розовый" data-style="background-color: #ffc0cb;">
                                                    Розовый
                                                </option>
                                                @break
                                                @case('серый')
                                                <option value="серый" data-style="background-color: #808080;">
                                                    Серый
                                                </option>
                                                @break
                                                @case('фиолетовый')
                                                <option value="фиолетовый" data-style="background-color: #8b00ff;">
                                                    Фиолетовый
                                                </option>
                                                @break
                                                @default
                                            @endswitch
                                        @endforeach
                                    </select>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Стандарты защиты</th>
                            <td class="prop-table__cell">
                                @foreach ($bracelet->protect_stand as $protect_stand)
                                    @if ($loop->last)
                                        {{ $protect_stand }}
                                    @else
                                        {{ $protect_stand }},
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Допустимые условия использования</th>
                            <td class="prop-table__cell">
                                @foreach ($bracelet->terms_of_use as $terms_of_use)
                                    @if ($loop->last)
                                        {{ $terms_of_use }}
                                    @else
                                        {{ $terms_of_use }},
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Габариты</th>
                            <td class="prop-table__cell">
                                {{ $bracelet->dimensions }}
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Вес</th>
                            <td class="prop-table__cell">
                                {{ $bracelet->weight }} г.
                            </td>
                        </tr>
                        <tr class="text-md text-bold">
                            <th class="text-center color-primary padding-y-sm toc-content__target" colspan="2"
                                id="toc3-3">Дисплей
                            </th>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Диагональ</th>
                            <td class="prop-table__cell">{{ $bracelet->disp_diag }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Технология</th>
                            <td class="prop-table__cell">{{ $bracelet->disp_tech }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Разрешение</th>
                            <td class="prop-table__cell">
                                {{ $bracelet->disp_resolution }}
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">PPI (плотность пикселей)</th>
                            <td class="prop-table__cell">{{ $bracelet->disp_ppi }} PPI</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Яркость</th>
                            <td class="prop-table__cell">{{ $bracelet->disp_brightness }} нит.</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Глубина цвета</th>
                            <td class="prop-table__cell">{{ $bracelet->disp_col_depth }} бит.</td>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Сенсорный</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->disp_sens == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Цветной</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->disp_color == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Always on Display (AoD)</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->disp_aod == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="text-md text-bold">
                            <th class="text-center color-primary padding-y-sm toc-content__target" colspan="2"
                                id="toc3-4">Модули и датчики
                            </th>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Датчики</th>
                            <td class="prop-table__cell">
                                @foreach ($bracelet->sensors as $sensors)
                                    @if ($loop->last)
                                        {{ $sensors }}
                                    @else
                                        {{ $sensors }},
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Встроенный GPS</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->gps == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Вибромотор</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->vibration == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Версия Bluetooth</th>
                            <td class="prop-table__cell">{{ $bracelet->blue_ver }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">NFC</th>
                            <td class="prop-table__cell">{{ $bracelet->nfc }}</td>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Другие интерфейсы</th>
                            <td class="prop-table__cell">
                                @foreach ($bracelet->other_interfaces as $other_interfaces)
                                    @if ($loop->last)
                                        {{ $other_interfaces }}
                                    @else
                                        {{ $other_interfaces }},
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr class="text-md text-bold">
                            <th class="text-center color-primary padding-y-sm toc-content__target" colspan="2"
                                id="toc3-5">Связь
                            </th>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Телефонные звонки</th>
                            <td class="prop-table__cell">{{ $bracelet->phone_calls }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Уведомления</th>
                            <td class="prop-table__cell">
                                @foreach($bracelet->notification as $item)
                                    {{ $item }}
                                @endforeach
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Отправка сообщений с браслета</th>
                            <td class="prop-table__cell">{{ $bracelet->send_messages }}</td>
                        </tr>
                        <tr class="text-md text-bold">
                            <th class="text-center color-primary padding-y-sm toc-content__target" colspan="2"
                                id="toc3-6">Функционал
                            </th>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Мониторинг</th>
                            <td class="prop-table__cell">
                                @foreach ($bracelet->monitoring as $monitoring)
                                    @if ($loop->last)
                                        {{ $monitoring }}
                                    @else
                                        {{ $monitoring }},
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Постоянное измерение
                                пульса
                            </th>
                            <td class="prop-table__cell">
                                @if ($bracelet->heart_rate == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Измерение кислорода в крови</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->blood_oxy == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Измерение артериального давления</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->blood_pressure == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Измерение стресса</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->stress == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Тренировочные режимы</th>
                            <td class="prop-table__cell">
                                @foreach ($bracelet->training_modes as $training_modes)
                                    @if ($loop->last)
                                        {{ $training_modes }}
                                    @else
                                        {{ $training_modes }},
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Автоматическое распознавание
                                тренировки
                            </th>
                            <td class="prop-table__cell">
                                @if ($bracelet->workout_recognition == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Напоминание об отсутствии активности
                            </th>
                            <td class="prop-table__cell">
                                @if ($bracelet->inactivity_reminder == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Поиск смартфона/браслета</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->search_smartphone == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Умный будильник</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->smart_alarm == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Управление камерой смартфона</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->camera_control == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Управление плеером смартфона</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->player_control == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Секундомер</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->stopwatch == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Таймер</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->timer == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Женский календарь</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->women_calendar == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Прогноз погоды</th>
                            <td class="prop-table__cell">
                                @if ($bracelet->weather_forecast == '1')
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                                        <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                                        <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                                  stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                                    </svg>
                                @else
                                    <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                                            included</title>
                                        <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                                        <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                                           stroke-miterlimit="10" stroke-width="2">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <line x1="17" y1="17" x2="7" y2="7"/>
                                        </g>
                                    </svg>
                            @endif
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Дополнительная информация</th>
                            <td class="prop-table__cell">{{ $bracelet->additional_info }}</td>
                        </tr>
                        <tr class="text-md text-bold">
                            <th class="text-center color-primary padding-y-sm toc-content__target" colspan="2"
                                id="toc3-7">Аккумулятор
                            </th>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Тип</th>
                            <td class="prop-table__cell">{{ $bracelet->type_battery }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Емкость</th>
                            <td class="prop-table__cell">{{ $bracelet->capacity_battery }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Время работы в режиме ожидания</th>
                            <td class="prop-table__cell">{{ $bracelet->standby_time }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Реальное время работы</th>
                            <td class="prop-table__cell">{{ $bracelet->real_time }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Время полной зарядки</th>
                            <td class="prop-table__cell">{{ $bracelet->full_charge_time }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Зарядное устройство</th>
                            <td class="prop-table__cell">{{ $bracelet->charger }}</td>
                        </tr>
                        </tbody>
                    </table>

                </section>
                <section class="margin-y-md container max-width-adaptive-sm toc-content__target" id="toc4">

                    @livewire('review.reviews', ['model' => $bracelet])

                </section>

            </div>

        </div>
@endsection


