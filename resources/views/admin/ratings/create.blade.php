@extends('admin.layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
@endpush

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('admin_rating_create') }}
</div>

  <form action="{{ route('ratings.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

      <x-admin.seo-block-create :users="$users">

      </x-admin.seo-block-create>


<div class="bg radius-md shadow-xs padding-md margin-bottom-md">
  @include('admin.layouts.parts.htmlcomponents')
    <x-admin.codemirror-editor :content="old('intro')" name="intro" id="intro">
        <h4>Основной контент (в начале статьи)</h4>
        <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
            полный экран, ESC для выхода.</p>
    </x-admin.codemirror-editor>

    <x-admin.codemirror-editor :content="old('conclusion')" name="conclusion" id="conclusion">
        <h4>Выводы (в конце статьи)</h4>
        <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
            полный экран, ESC для выхода.</p>
    </x-admin.codemirror-editor>
</div>


      <x-admin.add-images currentCover="placeholder">

      </x-admin.add-images>

      <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
        <div class="grid gap-xxs">
            <div class="col-6@md">
                    <h4>Тип таблицы</h4>
                    <div class="select margin-y-sm">
                        <select
                            class="select__input form-control @error('type_table') form-control--error @enderror"
                            name="type_table">
                            <option value="">Выбрать тип таблицы</option>
                            <option value="table-row.head" @if(old('type_table') == 'table-row.head') selected @endif>Как на амазоне</option>
                            <option value="table-column.head" @if(old('type_table') == 'table-column.head') selected @endif>Обычная</option>
                        </select>

                        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                            <g stroke-width="1" stroke="currentColor">
                                <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10"
                                        points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                            </g>
                        </svg>
                    </div>
            </div>
            <div class="col-6@md">
                <h4>Оценка для браслетов</h4>
                    <div class="select margin-y-sm">
                        <select
                            class="select__input form-control @error('type_grade') form-control--error @enderror"
                            name="type_grade">
                            <option value="">Выбрать тип оценки</option>
                            <option value="average_grade" @if(old('type_grade') == 'average_grade') selected @endif>Общий рейтинг</option>
                            <option value="average_swim_grade" @if(old('type_grade') == 'average_swim_grade') selected @endif>Плавание</option>
                            <option value="average_pulse_grade" @if(old('type_grade') == 'average_pulse_grade') selected @endif>Точность пульсометра</option>
                            <option value="average_pedometer_grade" @if(old('type_grade') == 'average_pedometer_grade') selected @endif>Точность шагомера</option>
                            <option value="average_smart_grade" @if(old('type_grade') == 'average_smart_grade') selected @endif>Умный будильник</option>
                            <option value="average_pressure_grade" @if(old('type_grade') == 'average_pressure_grade') selected @endif>Измерение давления</option>
                        </select>
                        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                            <g stroke-width="1" stroke="currentColor">
                                <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10"
                                        points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                            </g>
                        </svg>
                    </div>
            </div>
        </div>

          <h4>Характеристики для таблицы</h4>

          {{-- Add specs for table --}}
          <div class="js-repeater" data-repeater-input-name="listspecs[n]">
              <div class="js-repeater__list">
                      <div
                          class="grid gap-x-sm margin-y-md border radius-md padding-sm js-repeater__item">
                          <div class="col-4@md">
                              <div class="select margin-bottom-xxs">
                                  <select class="select__input form-control"
                                          name="listspecs[0][specs]" id="listspecs[0][specs]"
                                          class="form-control">
                                      <option value="">-- Выбрать харктеристику --</option>
                                      <option value="real_time">Время работы</option>
                                      <option value="country">Страна</option>
                                      <option value="compatibility">Совместимость</option>
                                      <option value="protect_stand">Стандарты защиты</option>
                                      <option value="terms_of_use">Условия использования</option>
                                      <option value="disp_diag">Диагональ дисплея</option>
                                      <option value="disp_tech">Технология дисплея</option>
                                      <option value="disp_resolution">Разрешение дисплея</option>
                                      <option value="disp_sens">Сенсорный дисплей</option>
                                      <option value="disp_color">Цветной дисплей</option>
                                      <option value="gps">GPS</option>
                                      <option value="nfc">NFC</option>
                                      <option value="phone_calls">Телефонные звонки</option>
                                      <option value="heart_rate">Постоянное измерение пульса</option>
                                      <option value="blood_oxy">Измерение кислорода</option>
                                      <option value="blood_pressure">Измерение давления</option>
                                      <option value="smart_alarm">Умный будильник</option>
                                      <option value="camera_control">Управление камерой</option>
                                      <option value="player_control">Управление плеером</option>
                                      <option value="grade_bracelet">Общий рейтинг</option>
                                  </select>

                                  <svg class="icon select__icon" aria-hidden="true"
                                       viewBox="0 0 16 16">
                                      <g stroke-width="1" stroke="currentColor">
                                          <polyline fill="none" stroke="currentColor"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-miterlimit="10"
                                                    points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                                      </g>
                                  </svg>
                              </div>
                          </div>
                          <div class="col-4@md">
                              <label class="form-label margin-bottom-xxs sr-only"
                                     for="listspecs[0][value]">Значение:</label>
                              <input class="form-control col" type="text"
                                     name="listspecs[0][value]" id="listspecs[0][value]">
                          </div>

                          <div class="col-1@md">
                              <button
                                  class="btn btn--subtle padding-x-xs col-content js-repeater__remove btn--accent"
                                  type="button">
                                  <svg class="icon" viewBox="0 0 20 20">
                                      <title>Remove item</title>

                                      <g fill="none" stroke="currentColor" stroke-linecap="round"
                                         stroke-linejoin="round" stroke-width="2">
                                          <line x1="1" y1="5" x2="19" y2="5"/>
                                          <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5"/>
                                          <path
                                              d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8"/>
                                      </g>
                                  </svg>
                              </button>

                          </div>
                      </div>
              </div>
              <button class="btn btn--primary width-100% margin-top-xs js-repeater__add"
                      type="button">+ Добавить характеристику
              </button>
          </div>

          <div class="alert alert--warning alert--is-visible padding-sm radius-md js-alert margin-top-sm" role="alert">
              <div class="flex items-center justify-between">
                  <div class="flex items-center">
                      <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
                          <path d="M12,0C5.383,0,0,5.383,0,12s5.383,12,12,12s12-5.383,12-12S18.617,0,12,0z M13.645,5L13,14h-2l-0.608-9 H13.645z M12,20c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C14,19.105,13.105,20,12,20z"></path>
                      </svg>

                      <p class="text-sm"><strong>Внимание:</strong> Редактировать позицию браслета в рейтинге, а также отдельный текст для него и заголовок можно будет после сохранения.
                      </p>
                  </div>

                  <button class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
                      <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                          <title>Close alert</title>
                          <line x1="3" y1="3" x2="17" y2="17" />
                          <line x1="17" y1="3" x2="3" y2="17" />
                      </svg>
                  </button>
              </div>
          </div>

          {{-- Add bracelets --}}
          <section class="margin-bottom-md">
              <div class="text-component">
                  <h4>Добавить браслеты, которые входят в рейтинг</h4>
              </div>
              <div class="js-repeater" data-repeater-input-name="allbracelets[n]">
                  <div class="js-repeater__list">
                      <div class="margin-y-md js-repeater__item">
                          <div class="grid gap-xs">
                              <div class="col">
                                  <div class="select margin-bottom-xxs">
                                      <select class="select__input form-control" name="allbracelets[0]" id="allbracelets[0]"
                                              class="form-control">
                                          <option value="">-- Выбрать браслет --</option>
                                          @foreach ($bracelets as $k => $v)
                                              <option value="{{ $k }}">{{ $v }}</option>
                                          @endforeach
                                      </select>

                                      <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                                  </div>
                              </div>
                              <div class="col-content">
                                  <button class="btn btn--accent padding-x-xs col-content js-repeater__remove" type="button">
                                      <svg class="icon" viewBox="0 0 20 20">
                                          <title>Remove item</title>

                                          <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                              <line x1="1" y1="5" x2="19" y2="5"/>
                                              <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5"/>
                                              <path d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8"/>
                                          </g>
                                      </svg>
                                  </button>
                              </div>
                          </div>
                      </div>
                  </div>
                  <button class="btn btn--primary width-100% margin-top-xs js-repeater__add" type="button">+ Добавить браслет</button>
              </div>
          </section>
          {{-- End add bracelets --}}

 </div>

  <button class="btn btn--success" type="submit">Сохранить</button>

</form>

@endsection


@push('js')
    <script src="{{ asset("js/admin/prism.min.js") }}"></script>
@endpush
