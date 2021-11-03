@extends('layouts.base')

@section('title')
{{ $rating->title }}
@endsection

@section('description')
{{ $rating->description }}
@endsection

@section('content')
<div class="position-relative z-index-1 bg-contrast-lower padding-y-lg">
  <div class="container max-width-adaptive-md">

    <article class="t-article-v4 bg padding-md padding-x-lg@md padding-y-xl@md">

      <div class="text-component text-center line-height-lg v-space-xxl max-width-xs margin-x-auto">
        <p class="text-xs text-uppercase letter-spacing-lg color-contrast-medium">{{ $rating->created_at->diffForHumans() }}</p>
        <h1>{{ $rating->subtitle }}</h1>
      </div>

      <div class="t-article-v4__divider margin-y-lg" aria-hidden="true"><span></span></div>

      <div class="text-component line-height-lg v-space-md">
        <div class="tbl text-sm margin-y-md">
          <table class="tbl__table border-bottom border-2" aria-label="Table Example">
            <thead class="tbl__header border-bottom border-2">
              <tr class="tbl__row">
                <th class="tbl__cell text-left" scope="col">
                  <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Модель</span>
                </th>

                <th class="tbl__cell text-left" scope="col">
                  <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Время работы</span>
                </th>

                <th class="tbl__cell" scope="col">
                  <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Цветной дисплей</span>
                </th>

                <th class="tbl__cell text-left" scope="col">
                  <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Рейтинг</span>
                </th>
              </tr>
            </thead>

            <tbody class="tbl__body">
              @foreach ($rating->bracelets as $bracelet)
              <tr class="tbl__row">
                <td class="tbl__cell" role="cell">
                  <div class="flex items-center">
                    <figure class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                      <img class="block width-100% height-100% object-cover" src="{{ $bracelet->getFirstMediaUrl('bracelet', 'thumb') }}">
                    </figure>

                    <div class="line-height-xs">
                      <p class="margin-bottom-xxxxs text-bold">{{ $bracelet->name }}</p>
                    </div>
                  </div>
                </td>

                <td class="tbl__cell" role="cell">{{ $bracelet->real_time }} {{ trans_choice('день|дня|дней',$bracelet->real_time) }}</td>

                <td class="tbl__cell text-center" role="cell">
                  @if ($bracelet->disp_color == 1)
                  <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg>
                @else
                  <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not included</title><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg>
                @endif
                </td>

                <td class="tbl__cell" role="cell">
                  <span class="inline-block text-sm bg-success bg-opacity-20% text-bold radius-full padding-y-xxxs padding-x-xs ws-nowrap">{{ $bracelet->grade_bracelet }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        {!! $rating->text !!}

        @foreach ($rating->bracelets as $bracelet)
            <h2>{{ $bracelet->name }}</h2>

            <div class="grid grid-gap-md items-center">
              <div class="col-4@sm">
              <img loading="lazy" data-src="{{ $bracelet->getFirstMediaUrl('bracelet') }}" src="/assets/theme/back-image/lazy-load-placeholder.svg"
          class="block width-100% shadow-xs">
        <noscript>
          <img class="block width-100%" src="{{ $bracelet->getFirstMediaUrl('bracelet') }}">
        </noscript>
          </div>

          <div class="col-8@sm">
            <table class="prop-table width-100% text-sm" aria-label="Property Table Example">
              <tbody class="prop-table__body">
                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">Страна-производитель</th>
                  <td class="prop-table__cell">{{ $bracelet->country }}</td>
                </tr>

                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">Год выпуска</th>
                  <td class="prop-table__cell">{{ $bracelet->year }}</td>
                </tr>
                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">Время работы на одной зарядке</th>
                  <td class="prop-table__cell">{{ $bracelet->real_time }} {{ trans_choice('день|дня|дней',$bracelet->real_time) }}</td>
                </tr>

                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">Цветной дисплей</th>
                  <td class="prop-table__cell">@if ($bracelet->disp_color == 1) <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция доступна</title><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg> @else <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция недоступна</title><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg> @endif</td>
                </tr>
                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">Умный будильник</th>
                  <td class="prop-table__cell">@if ($bracelet->smart_alarm == 1) <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция доступна</title><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg> @else <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция недоступна</title><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg> @endif</td>
                </tr>
                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">Диагональ</th>
                  <td class="prop-table__cell">{{ $bracelet->disp_diag }}"</td>
                </tr>
                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">Разрешение экрана</th>
                  <td class="prop-table__cell">{{ $bracelet->disp_resolution }}</td>
                </tr>

                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">Мониторинг</th>
                  <td class="prop-table__cell">@foreach ($bracelet->monitoring as $monitoring)
                      @if ($loop->last)
                         {{ $monitoring }}
                     @else
                     {{ $monitoring }},
                     @endif
                     @endforeach
                    </td>
                </tr>

                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">NFC</th>
                  <td class="prop-table__cell">@if ($bracelet->nfc != '') <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция доступна</title><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg> @else <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция недоступна</title><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg> @endif</td>
                </tr>

                <tr class="prop-table__row">
                  <th class="prop-table__cell prop-table__cell--th">GPS</th>
                  <td class="prop-table__cell">@if ($bracelet->gps == 1) <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция доступна</title><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg> @else <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция недоступна</title><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg> @endif</td>
                </tr>

              </tbody>
            </table>
          </div>
            </div>
            <section class="grid grid-gap-sm margin-y-md">
              <div class="col-9@md">
            @foreach ($bracelet->grades as $grade)
        <div class="progress-bar progress-bar--color-update js-progress-bar flex flex-column items-center margin-y-xxs">
          <p class="sr-only" aria-live="polite" aria-atomic="true">Оценка составляет <span class="js-progress-bar__aria-value">{{ $grade->pivot->value * 10 }}%</span></p>

          <div class="margin-y-xxs width-100%">{{ $grade->name }} <span class="text-bold float-right">{{ number_format($grade->pivot->value, 1) }}</span></div>

          <div class="progress-bar__bg width-100%" aria-hidden="true">
            <div class="progress-bar__fill" style="width: {{ $grade->pivot->value * 10 }}%;"></div>
          </div>
        </div>

        @endforeach
      </div>
      <div class="col-3@md margin-y-auto text-center">
        <div class="text-center">
        <span class="text-xxxl"><svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.765 9.397a.676.676 0 00-.538-.453l-6.64-1.015-2.976-6.34c-.222-.474-.999-.474-1.222 0L8.413 7.93l-6.64 1.015a.674.674 0 00-.381 1.139l4.824 4.945-1.14 6.99a.673.673 0 00.992.699L12 19.439l5.931 3.278a.672.672 0 00.993-.699l-1.14-6.99 4.824-4.945a.675.675 0 00.157-.686z" fill="#ffc107"/><path d="M5.574 15.362l-1.267 7.767a.751.751 0 001.103.777L12 20.264l6.59 3.643a.748.748 0 001.103-.778l-1.267-7.767 5.36-5.494a.75.75 0 00-.423-1.265l-7.378-1.127L12.678.432c-.247-.526-1.11-.526-1.357 0L8.015 7.476.637 8.603a.75.75 0 00-.424 1.265zm3.063-6.464a.75.75 0 00.565-.422L12 2.515l2.798 5.96a.747.747 0 00.565.422l6.331.967-4.605 4.72a.75.75 0 00-.204.645l1.08 6.617-5.602-3.096a.755.755 0 00-.726 0l-5.602 3.096 1.08-6.617a.75.75 0 00-.204-.645l-4.605-4.72z"/></svg> {{ $bracelet->grade_bracelet }}</span><br>
        Средний рейтинг
        </div>
      </div>
    </section>
    @if ($bracelet->sellers->count())

    <section class="margin-y-sm">
      <div class="table-card bg radius-md padding-sm shadow-sm">
        <div class="margin-bottom-md">
          <div class="flex items-baseline justify-between">
            <p class="color-contrast-medium">Где купить в Москве и регионах</p>
          </div>
        </div>

        <div class="tbl text-sm">
          <table class="tbl__table" aria-label="Table Example">
            <thead class="tbl__header sr-only">
              <tr class="tbl__row">
                <th class="tbl__cell text-left" scope="col">
                  <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Магазин</span>
                </th>

                <th class="tbl__cell text-left" scope="col">
                  <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Цена</span>
                </th>

                <th class="tbl__cell text-right" scope="col">
                  <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Купить</span>
                </th>
              </tr>
            </thead>

            <tbody class="tbl__body">
              @foreach ($bracelet->sellers as $seller)
                <tr class="tbl__row">
                  <td class="tbl__cell text-md text-bold" role="cell">{{ $seller->name }}</td>

                  <td class="tbl__cell" role="cell">
                  @if ($seller->pivot->old_price != '')
                    <del class="text-line-through text-bold color-contrast-medium margin-right-xxs">{{ $seller->pivot->old_price }}</del>
                    <a class="link-fx-1 color-contrast-higher text-bold color-success" href="{{ $seller->pivot->link }}">
                      <span>{{ $seller->pivot->price }}</span>
                      <svg class="icon" viewBox="0 0 32 32" aria-hidden="true">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="16" cy="16" r="15.5" />
                          <line x1="10" y1="18" x2="16" y2="12" />
                          <line x1="16" y1="12" x2="22" y2="18" />
                        </g>
                      </svg>
                    </a>
                  @else
                    <a class="link-fx-1 color-contrast-higher text-bold" href="{{ $seller->pivot->link }}">
                      <span>{{ $seller->pivot->price }}</span>
                      <svg class="icon" viewBox="0 0 32 32" aria-hidden="true">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="16" cy="16" r="15.5" />
                          <line x1="10" y1="18" x2="16" y2="12" />
                          <line x1="16" y1="12" x2="22" y2="18" />
                        </g>
                      </svg>
                    </a>
                  @endif
                  </td>

                  <td class="tbl__cell" role="cell">
                    <div class="flex justify-end">
                      <a rel="nofollow" target="_blank" href="{{ $seller->pivot->link }}" class="btn btn--primary">Купить</a>
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
            {!! $bracelet->pivot->text_rating !!}


            <section class="margin-y-lg">
              <div class="text-divider"><span>Плюсы и минусы {{ $bracelet->name }}</span></div>
              <div class="container grid">
                <div class="col-6@sm">
                  <h3 class="margin-y-sm text-center">Плюсы</h3>

                  <ul class="list list--icons">
                    @foreach ($bracelet->plus as $plus)
                    <li>
                      <div class="flex items-start">
                        <svg class="list__icon icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg>

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
                        <svg class="list__icon icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg>

                        <div>{{ $minus }}</div>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>

            </section>
        @endforeach

      </div>
    </article>

    <div class="bg padding-md padding-x-lg@md margin-y-sm@md">
      <div class="text-component">
      <h2>Наши рекомендации</h2>
      </div>
     <ol class="margin-bottom-md margin-top-md" aria-label="Наши рекомендации">
      @foreach ($topbracelets as $topbracelet)
      <li class="cart__product flex padding-y-sm">
        <div class="cart__product-img margin-right-sm">
          <a href="#0" class="radius-md shadow-md"><img src="{{ $topbracelet->getFirstMediaUrl('bracelet', 'thumb') }}"></a>
        </div>

        <div class="cart__product-info">
          <div class="text-component v-space-sm">
            <h2 class="text-md"><a class="link-fx-5" href="/katalog/{{ $topbracelet->slug }}" class="color-inherit">{{ $topbracelet->name }}</a></h2>
            <p class="text-sm color-contrast-medium"><span class="text-bold">Оценка:</span> <span class="inline-block text-sm bg-success bg-opacity-20% text-bold radius-full padding-y-xxxs padding-x-xs ws-nowrap">{{ $topbracelet->grade_bracelet }}</span></p>
            <p class="text-sm color-contrast-medium">
              <span class="text-bold">Мониторинг:</span> @foreach ($topbracelet->monitoring as $monitoring)
                      @if ($loop->last)
                         {{ $monitoring }}
                     @else
                     {{ $monitoring }},
                     @endif
                     @endforeach
            </p>
          </div>

          <div class="cart__product-tot">

            <div>
              <p class="text-md"><span class="text-sm">Средняя цена:</span> {{ $topbracelet->avg_price }} Р.</p>

              <a href="/katalog/{{ $topbracelet->slug }}" class="cart__remove-btn margin-top-xxs">Сравнить цены</a>
            </div>
          </div>
        </div>
      </li>
     @endforeach
</ol>

    </div>


    <div class="bg padding-md padding-x-lg@md margin-y-sm@md">
    @livewire('comments', ['rating' => $rating->id, 'user' => $user, 'post_id' => $rating->id, 'commentable_type' => get_class($rating)])

      {{-- <livewire:comments :comments="$rating->comments", :user="$user", :post_id='$rating->id'> --}}
      </div>
  </div>
</div>
@if (Auth::check())
@can('view-admin-panel')
<div class="fab fab--bottom-right js-fab">
  <div class="position-relative container max-width-sm height-100%">
    <button class="reset fab__btn js-tab-focus js-fab__btn" aria-label="Toggle new message popover">
      <span class="fab__icon-wrapper">
        <svg class="icon fab__icon" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><line x1="12" y1="3" x2="12" y2="21"/><line x1="21" y1="12" x2="3" y2="12"/></g></svg>
      </span>

      <span class="fab__icon-wrapper">
        <svg class="icon fab__icon" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><line x1="19" y1="5" x2="5" y2="19"/><line x1="19" y1="19" x2="5" y2="5"/></g></svg>
      </span>
    </button>

    <div class="fab__popover js-fab__popover" role="dialog">
      <div class="fab__popover-inner js-fab__popover-inner">
        <div class="fab__content">
          <menu class="fab__menu">

            <li>
              <a class="fab__menu-item fab__menu-item--cta text-sm@md js-tab-focus" href="/admin/ratings/{{ $rating->id }}/edit">
                <figure class="fab__menu-img">
                  <svg class="icon" viewBox="0 0 16 16"><g><path d="M15.207,8.793l-5.5-5.5c-0.391-0.391-1.023-0.391-1.414,0l-7,7c-0.128,0.128-0.219,0.289-0.263,0.464l-1,4 c-0.085,0.341,0.015,0.701,0.263,0.95C0.483,15.897,0.738,16,1,16c0.081,0,0.162-0.01,0.243-0.03l4-1 c0.176-0.044,0.336-0.135,0.464-0.263L12,8.414L13.086,9.5l-3.293,3.293c-0.391,0.391-0.391,1.023,0,1.414 c0.391,0.391,1.023,0.391,1.414,0l4-4C15.598,9.816,15.598,9.184,15.207,8.793z"></path><path d="M11.121,1.879l3,3l1.258-1.258c0.828-0.828,0.828-2.172,0-3v0c-0.828-0.828-2.172-0.828-3,0 L11.121,1.879L11.121,1.879z"></path></g></svg>
                </figure>

                <span class="fab__menu-label">Редактировать</span>
              </a>
            </li>
          </menu>
        </div>
      </div>
    </div>
  </div>
</div>
@endcan
@endif


@endsection

@section('footerScripts')
@parent

@endsection



