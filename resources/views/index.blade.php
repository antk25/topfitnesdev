@extends('layouts.base')
{{-- Переопределяем секцию content от базового шаблона --}}
@section('content')

<section class="position-relative z-index-1 padding-y-xl bg-cover bg-center" style="background-image: url('{{ asset("img/feature-v18-img-1.jpg") }}');">
    <div class="container max-width-adaptive-lg">
      <div class="margin-bottom-lg">
        <h1 class="text-center">Лидеры рейтингов</h1>
      </div>

      <div class="grid gap-sm">
  @foreach ($hits as $hit)
        <a class="card-v12 padding-top-sm radius-lg shadow-sm col-6@sm col-3@md" aria-controls="modal-name-{{ $loop->index }}" href="#0" aria-label="Link description">
          <div class="position-relative">
            <figure class="card-v12__figure radius-sm" >
              <img class="block width-100%" src="{{ $hit->getFirstMediaUrl('bracelet', 'thumb') }}"  alt="Image description">
            </figure>

            <svg class="icon card-v12__icon" viewBox="0 0 60 60">
              <g class="icon-group" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="30" x2="57" y2="30" />
                <line x1="57" y1="30" x2="43" y2="44" />
                <line x1="43" y1="16" x2="57" y2="30" />
              </g>
            </svg>
          </div>

          <div class="text-center padding-md">
            <h3 class="text-base">{{ $hit->name }}</h3>

            <div class="card-v12__separator border-top border-contrast-higher border-opacity-10% margin-x-auto margin-y-xs" role="presentation"></div>

            <p class="text-xs color-contrast-higher color-opacity-50% text-uppercase letter-spacing-lg">Yoga</p>
          </div>
        </a>

        <div class="modal modal--animate-translate-up flex flex-center bg-contrast-higher bg-opacity-90% padding-md js-modal" id="modal-name-{{ $loop->index }}">
  <div class="modal__content width-100% max-width-xs max-height-100% overflow-auto bg radius-md shadow-md" role="alertdialog" aria-labelledby="modal-title-{{ $loop->index }}" aria-describedby="modal-description-{{ $loop->index }}">
    <header class="bg-contrast-lower padding-y-sm padding-x-md flex items-center justify-between">
      <h4 class="text-truncate" id="modal-title-{{ $loop->index }}">{{ $hit->name }}</h4>

      <button class="reset modal__close-btn modal__close-btn--inner js-modal__close js-tab-focus">
        <svg class="icon" viewBox="0 0 20 20">
          <title>Close modal window</title>
          <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="3" x2="17" y2="17" />
            <line x1="17" y1="3" x2="3" y2="17" />
          </g>
        </svg>
      </button>
    </header>

    <div class="padding-y-sm padding-x-md">
      <div class="text-component">
        <p id="modal-description-{{ $loop->index }}">Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae culpa, inventore alias ab atque similique quod ea reprehenderit.</p>
        <div class="table-card bg radius-md padding-md shadow-xs">
  <div class="margin-bottom-md">
    <div class="flex items-baseline justify-between">
      <p class="color-contrast-medium">Оценки</p>
      <p>Общая оценка <span class="text-md color-primary font-bold">{{ $hit->grade_bracelet }}</span></p>
    </div>
  </div>

  <div class="tbl text-sm">
    <table class="tbl__table" aria-label="Таблица оценок">
      <thead class="tbl__header sr-only">
        <tr class="tbl__row">
          <th class="tbl__cell text-left" scope="col">
            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Оценка</span>
          </th>

          <th class="tbl__cell text-right" scope="col">
            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Значение</span>
          </th>
        </tr>
      </thead>

      <tbody class="tbl__body">
        @foreach ($hit->grades as $grade)
        <tr class="tbl__row">
          <td class="tbl__cell" role="cell"><span class="tooltip-trigger js-tooltip-trigger" title="{{ $grade->about }}">{{ $grade->name }}</span></td>


          <td class="tbl__cell" role="cell">
            <div class="flex justify-end">

              <div class="progress-bar inline-flex items-center js-progress-bar">
                <p class="sr-only" aria-live="polite" aria-atomic="true">Progress value is <span class="js-progress-bar__aria-value">{{ $grade->pivot->value * 10 }}%</span></p>

                <span class="progress-bar__value margin-left-xs order-2 font-bold" aria-hidden="true">
                     {{ number_format($grade->pivot->value, 1) }}
                </span>

                <div class="progress-bar__bg order-1" aria-hidden="true">
                  <div class="progress-bar__fill color-success" style="width: {{ $grade->pivot->value * 10 }}%;"></div>
                </div>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
      </div>
    </div>

    <footer class="padding-md">
      <div class="flex justify-end gap-xs">
        <button class="btn btn--subtle js-modal__close">Закрыть</button>
        <a href="/katalog/{{ $hit->slug }}" class="btn btn--primary">Подробнее</a>
      </div>
    </footer>
  </div>

</div>
  @endforeach
      </div>
    </div>
  </section>

    <section class="margin-y-lg">
      <div class="container max-width-adaptive-lg">
        <div class="margin-bottom-lg">
          <h1 class="text-center">Новые отзывы</h1>
        </div>

        <div class="grid gap-sm">
          @foreach ($reviews as $review)
            @include('main.review')
          @endforeach
        </div>
      </div>
    </section>

@endsection

@section('footerScripts')
