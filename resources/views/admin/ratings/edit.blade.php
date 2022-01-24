@extends('admin.layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
@endpush
@section('content')

    <div class="container">

        <div class="flex justify-between bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
            <div>
                {{ Breadcrumbs::render('admin_rating', $rating) }}
            </div>
            <div>
                <a target="_blank" title="Откроется в новом окне" class="text-sm block font-bold text-decoration-none"
                   href="{{ route('pub.ratings.show', ['rating' => $rating]) }}">Посмотреть 👉</a>
            </div>
        </div>

        <div class="tabs js-tabs">
            <ul class="flex flex-wrap gap-sm js-tabs__controls margin-bottom-sm" aria-label="Tabs Interface">
                <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Рейтинг</a></li>
                <li><a href="#tab1Panel2" class="tabs__control">Комментарии</a></li>
                <li><a href="#tab1Panel3" class="tabs__control">Ссылки</a></li>
            </ul>

            <div class="js-tabs__panels">
                <section id="tab1Panel1" class="is-visible js-tabs__panel">

                    <form class="form-template-v3" method="POST"
                          action="{{ route('ratings.update', ['rating' => $rating->id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Сообщение об успешности сохранения --}}
                        @if(session('success'))

                            <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert"
                                 role="alert">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24"
                                             aria-hidden="true">
                                            <path
                                                d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
                                        </svg>

                                        <p class="text-sm"><strong>Успешно:</strong> {{ session('success') }}.</p>
                                    </div>

                                    <button
                                        class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
                                        <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                             stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            <title>Close alert</title>
                                            <line x1="3" y1="3" x2="17" y2="17"/>
                                            <line x1="17" y1="3" x2="3" y2="17"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                        {{-- Конец сообщения об успешности сохранения --}}

                        <x-admin.seo-block :model="$rating" :users="$users">

                        </x-admin.seo-block>

                        <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                            @include('admin.layouts.parts.htmlcomponents')
                            <x-admin.codemirror-editor :content="$rating->intro" name="intro" id="intro">
                                <h4>Основной контент (в начале статьи)</h4>
                                <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
                                    полный экран, ESC для выхода.</p>
                            </x-admin.codemirror-editor>

                            <x-admin.codemirror-editor :content="$rating->conclusion" name="conclusion" id="conclusion">
                                <h4>Выводы (в конце статьи)</h4>
                                <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
                                    полный экран, ESC для выхода.</p>
                            </x-admin.codemirror-editor>
                        </div>

                        <x-admin.add-cover :currentCover="$rating->getFirstMediaUrl('covers','320')" alt="Превью">

                        </x-admin.add-cover>


                        <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                            <h4>Тип таблицы</h4>
                            <div class="select margin-y-sm">
                                <select
                                    class="select__input form-control @error('type_table') form-control--error @enderror"
                                    name="type_table">
                                    <option value="">Выбрать тип таблицы</option>
                                    <option value="table-row.head" @if($rating->type_table == 'table-row.head') selected @endif>Как на амазоне</option>
                                    <option value="table-column.head" @if($rating->type_table == 'table-column.head') selected @endif>Обычная</option>
                                </select>

                                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                                    <g stroke-width="1" stroke="currentColor">
                                        <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round" stroke-miterlimit="10"
                                                  points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                                    </g>
                                </svg>
                            </div>

                            <h4>Характеристики для таблицы</h4>
                                <p class="text-sm color-contrast-medium">Порядок в таблице на фронте будет такой же как здесь!</p>
                            {{-- Add specs for table --}}
                                <div class="js-repeater" data-repeater-input-name="listspecs[n]">
                                    <div class="js-repeater__list">
                                        {{-- Используем функцию forelse, чтобы при отсутствии связей вывести пустую форму --}}
                                        @forelse ($rating->list_specs as $item)
                                            <div
                                                class="grid grid-col-4 gap-x-sm margin-y-md border radius-md padding-sm js-repeater__item">
                                                <div class="col-1@md">
                                                    <label class="form-label margin-bottom-xxs sr-only"
                                                           for="listspecs[{{ $loop->index }}][specs]">Характеристика</label>

                                                    <div class="select margin-bottom-xxs">
                                                        <select class="select__input form-control"
                                                                name="listspecs[{{ $loop->index }}][specs]"
                                                                id="listspecs[0][specs]"
                                                                class="form-control">
                                                            <option value="">-- Выбрать харктеристику --</option>
                                                            <option value="real_time"
                                                                    @if($item['specs'] == 'real_time') selected @endif>
                                                                    Время работы
                                                            </option>
                                                            <option value="country"
                                                                    @if($item['specs'] == 'country') selected @endif>
                                                                    Страна
                                                            </option>
                                                            <option value="compatibility"
                                                                    @if($item['specs'] == 'compatibility') selected @endif>
                                                                   Совместимость
                                                            </option>
                                                            <option value="protect_stand"
                                                                    @if($item['specs'] == 'protect_stand') selected @endif>
                                                                   Стандарты защиты
                                                            </option>
                                                            <option value="terms_of_use"
                                                                    @if($item['specs'] == 'terms_of_use') selected @endif>
                                                                    Условия использования
                                                            </option>
                                                            <option value="disp_diag"
                                                                    @if($item['specs'] == 'disp_diag') selected @endif>
                                                                    Диагональ дисплея
                                                            </option>
                                                            <option value="disp_tech"
                                                                    @if($item['specs'] == 'disp_tech') selected @endif>
                                                                    Технология дисплея
                                                            </option>
                                                            <option value="disp_resolution"
                                                                    @if($item['specs'] == 'disp_resolution') selected @endif>
                                                                    Разрешение дисплея
                                                            </option>
                                                            <option value="disp_sens"
                                                                    @if($item['specs'] == 'disp_sens') selected @endif>
                                                                    Сенсорный дисплей
                                                            </option>
                                                            <option value="disp_color"
                                                                    @if($item['specs'] == 'disp_color') selected @endif>
                                                                    Цветной дисплей
                                                            </option>
                                                            <option value="gps"
                                                                    @if($item['specs'] == 'gps') selected @endif>
                                                                    GPS
                                                            </option>
                                                            <option value="nfc"
                                                                    @if($item['specs'] == 'nfc') selected @endif>
                                                                    NFC
                                                            </option>
                                                            <option value="phone_calls"
                                                                    @if($item['specs'] == 'phone_calls') selected @endif>
                                                                    Телефонные звонки
                                                            </option>
                                                            <option value="heart_rate"
                                                                    @if($item['specs'] == 'heart_rate') selected @endif>
                                                                    Постоянное измерение пульса
                                                            </option>
                                                            <option value="blood_oxy"
                                                                    @if($item['specs'] == 'blood_oxy') selected @endif>
                                                                    Измерение кислорода
                                                            </option>
                                                            <option value="blood_pressure"
                                                                    @if($item['specs'] == 'blood_pressure') selected @endif>
                                                                    Измерение давления
                                                            </option>
                                                            <option value="smart_alarm"
                                                                    @if($item['specs'] == 'smart_alarm') selected @endif>
                                                                    Умный будильник
                                                            </option>
                                                            <option value="camera_control"
                                                                    @if($item['specs'] == 'camera_control') selected @endif>
                                                                    Управление камерой
                                                            </option>
                                                            <option value="player_control"
                                                                    @if($item['specs'] == 'player_control') selected @endif>
                                                                    Управление плеером
                                                            </option>
                                                            <option value="grade_bracelet"
                                                                    @if($item['specs'] == 'grade_bracelet') selected @endif>
                                                                    Общий рейтинг
                                                            </option>
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
                                                <div class="col-1@md">
                                                    <label class="form-label margin-bottom-xxs sr-only"
                                                           for="listspecs[{{ $loop->index }}][value]">Значение:</label>
                                                    <div>
                                                    <input class="form-control" type="text"
                                                           name="listspecs[{{ $loop->index }}][value]"
                                                           id="listspecs[{{ $loop->index }}][value]" value="{{ $item['value'] }}" placeholder="Имя столбца">
                                                    </div>
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
                                            {{-- Пустая форма при отсутствии связей --}}
                                        @empty
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
                                        @endforelse
                                    </div>
                                    <button class="btn btn--primary width-100% margin-top-xs js-repeater__add"
                                            type="button">+ Добавить характеристику
                                    </button>
                                </div>
                            {{-- End add specs --}}
                            <div class="margin-y-md"></div>
                            {{-- Add bracelets --}}
                            <h4>Добавить браслеты для рейтинга</h4>
                            <div class="js-repeater" data-repeater-input-name="allbracelets[n]">
                                <div class="js-repeater__list">
                                    {{-- Используем функцию forelse, чтобы при отсутствии связей вывести пустую форму --}}
                                    @forelse ($rating->bracelets as $item)
                                        <div
                                            class="grid grid-col-8 gap-sm margin-y-md border radius-md padding-sm js-repeater__item">
                                            <div class="col-2@md">
                                                <div class="select margin-bottom-xxs">
                                                    <select class="select__input form-control"
                                                            name="allbracelets[{{ $loop->index }}][bracelets]"
                                                            id="allbracelets[0][bracelets]"
                                                            class="form-control">
                                                        <option value="">-- Выбрать браслет --</option>
                                                        @foreach ($bracelets as $k => $v)
                                                            <option value="{{ $k }}" @if ($item->id == $k)
                                                            selected
                                                                @endif >{{ $v }}</option>
                                                        @endforeach
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
                                            <div class="col-3@md">
                                                <input class="form-control width-100%" type="text"
                                                       name="allbracelets[{{ $loop->index }}][head_rating]"
                                                       id="allbracelets[{{ $loop->index }}][head_rating]"
                                                       value="{{ $item->pivot->head_rating }}"
                                                       placeholder="Заголовок H2 для рейтинга">
                                            </div>

                                            <div class="col-3@md">
                                                <label class="form-label margin-bottom-xxs"
                                                       for="allbracelets[{{ $loop->index }}][position_rating]">Позиция:</label>
                                                <input class="form-control" type="number"
                                                       name="allbracelets[{{ $loop->index }}][position_rating]"
                                                       id="allbracelets[{{ $loop->index }}][position_rating]" min="0" max="20" step="1"
                                                       value="{{ $item->pivot->position }}">
                                            </div>

                                            <div class="col-8@md">
                                                <x-admin.codemirror-editor :content="$item->pivot->text_rating"
                                                                           name="allbracelets[{{ $loop->index }}][text_rating]"
                                                                           id="allbracelets[{{ $loop->index }}][text_rating]"
                                                                           placeholder="Описание браслета для рейтинга (только если нужно уникальное)">
                                                </x-admin.codemirror-editor>

                                                <button
                                                    class="btn width-100% btn--subtle margin-y-sm col-content js-repeater__remove btn--accent"
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
                                        {{-- Пустая форма при отсутствии связей --}}
                                    @empty
                                        <div
                                            class="grid grid-col-8 gap-x-sm margin-y-md border radius-md padding-sm js-repeater__item">
                                            <div class="col-2@md">
                                                <div class="select margin-bottom-xxs">
                                                    <select class="select__input form-control"
                                                            name="allbracelets[0][bracelets]"
                                                            id="allbracelets[0][bracelets]"
                                                            class="form-control">
                                                        <option value="">-- Выбрать браслет --</option>
                                                        @foreach ($bracelets as $k => $v)
                                                            <option value="{{ $k }}">{{ $v }}</option>
                                                        @endforeach
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
                                            <div class="col-3@md">
                                                <input class="form-control width-100%" type="text"
                                                       name="allbracelets[0][head_rating]"
                                                       id="allbracelets[][head_rating]"
                                                       placeholder="Заголовок H2 для рейтинга">
                                            </div>
                                            <div class="col-3@md">
                                                <label class="form-label margin-bottom-xxs"
                                                       for="allbracelets[0][position_rating]">Позиция:</label>
                                                <input class="form-control" type="number"
                                                       name="allbracelets[0][position_rating]"
                                                       id="allbracelets[0][position_rating]" min="0" max="20" step="1"
                                                       value="1">
                                            </div>

                                            <div class="col-8@md">
                                                <textarea class="form-control width-100%"
                                                          name="allbracelets[0][text_rating]"
                                                          id="allbracelets[][text_rating]" cols="33" rows="5"
                                                          placeholder="Описание браслета для выбранного рейтинга"></textarea>

                                                <button
                                                    class="btn width-100% margin-y-sm btn--subtle padding-x-xs col-content js-repeater__remove btn--accent"
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
                                    @endforelse
                                </div>
                                <div class="alert alert--warning alert--is-visible padding-sm radius-md js-alert" role="alert">
                                    <div class="flex items-center">
                                        <svg class="icon icon--sm alert__icon margin-right-sm" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12,0C5.383,0,0,5.383,0,12s5.383,12,12,12s12-5.383,12-12S18.617,0,12,0z M13.645,5L13,14h-2l-0.608-9 H13.645z M12,20c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C14,19.105,13.105,20,12,20z"></path>
                                        </svg>

                                        <p class="text-sm"><strong>Алгоритм добавления браслетов</strong></p>
                                    </div>

                                    <div class="flex margin-top-xxxs">
                                        <!-- 👇 spacer - occupy same space of alert__icon -->
                                        <svg class="icon icon--sm margin-right-sm" aria-hidden="true"></svg>

                                        <div class="text-component text-sm">
                                            <ol>
                                                <li>Добавить нужные модели</li>
                                                <li>Обязательно сохранить страницу</li>
                                                <li>Только потом редактировать индивидкальные поля у добавленных браслетов</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn--primary width-100% margin-top-xs js-repeater__add"
                                        type="button">+ Добавить браслет
                                </button>
                            </div>
                            {{-- End add bracelets --}}
                        </div>


                        <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

                            {{-- Add images --}}
                            <div class="text-component margin-y-sm">
                                <h4>Добавить картинки для статьи</h4>
                                <p class="text-md color-contrast-medium">Выберите одно или несколько изображений в
                                    формате
                                    <mark>jpg</mark>
                                    . После публикации рейтинга можно будет редактировать теги
                                    <mark>alt</mark>
                                    у каждой картинки.
                                </p>
                            </div>

                            <div class="file-upload inline-block">
                                <label for="files" class="file-upload__label btn btn--primary">
          <span class="flex items-center">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor"
                                                                        stroke-width="2"><path stroke-linecap="square"
                                                                                               stroke-linejoin="miter"
                                                                                               d="M2 16v6h20v-6"></path><path
                        stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path><path stroke-linecap="square"
                                                                                                stroke-linejoin="miter"
                                                                                                d="M18 8l-6-6-6 6"></path></g></svg>

            <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить</span>
          </span>
                                </label>

                                <input type="file" class="file-upload__input" name="files[]" id="files" multiple>
                            </div>
                            {{-- End add images --}}
                        </div>

                        <button class="btn btn--primary" type="submit">Сохранить</button>

                    </form>

                </section>

                <section id="tab1Panel2" class="js-tabs__panel">

                    {{-- Таблица комментариев для текущей страницы. В функции foreach заменить модель для вызова комментов --}}
                    <div class="text-component margin-bottom-md text-center">
                        <h2>Комментарии</h2>
                    </div>

                    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

                        <div class="tbl text-sm">

                            <table class="tbl__table border-bottom" aria-label="Таблица комментариев">
                                <thead class="tbl__header border-bottom">
                                <tr class="tbl__row">
                                    <th class="tbl__cell text-left" scope="col">
                                        <span class="font-semibold">ID</span>
                                    </th>

                                    <th class="tbl__cell text-left" scope="col">
                                        <span class="font-semibold">Пользователь</span>
                                    </th>

                                    <th class="tbl__cell text-left" scope="col">
                                        <span class="font-semibold">Ответ (id)</span>
                                    </th>

                                    <th class="tbl__cell text-left" scope="col">
                                        <span class="font-semibold">Текст</span>
                                    </th>

                                    <th class="tbl__cell text-left" scope="col">
                                        <span class="font-semibold">Дата</span>
                                    </th>

                                    <th class="tbl__cell text-left" scope="col">
                                        <span class="font-semibold">Действия</span>
                                    </th>
                                </tr>
                                </thead>

                                <tbody class="tbl__body">
                                @forelse ($rating->comments as $comment)
                                    <tr class="tbl__row">
                                        <td class="tbl__cell" role="cell">
                                            {{ $comment->id }}
                                        </td>

                                        <td class="tbl__cell" role="cell">
                                            <div class="flex items-center">
                                                <div class="line-height-xs">
                                                    @if ($comment->user_id)
                                                        {{ $comment->user->name }}<br>
                                                        <span class="text-sm color-contrast-medium">(id: {{ $comment->user->id }})</span>
                                                    @else
                                                        {{ $comment->username }}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td class="tbl__cell" role="cell">
                                            @if ($comment->parent_id)
                                                {{ $comment->parent_id }}
                                            @else
                                                --
                                            @endif
                                        </td>


                                        <td class="tbl__cell" width="200px" role="cell">
                                            {{ Str::limit($comment->comment, 100) }}

                                        </td>


                                        <td class="tbl__cell" role="cell">
                                            {{ $comment->created_at }}
                                        </td>

                                        <td class="tbl__cell text-right" role="cell">

                                            <div class="flex flex-wrap gap-xs">
                                                <a class="btn btn--primary btn--sm"
                                                   href="{{ route('comments.edit', ['comment' => $comment->id]) }}">
                                                    Изменить
                                                </a>

                                                <form method="POST"
                                                      action="{{ route('comments.destroy', ['comment' => $comment->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn--accent btn--sm">Удалить
                                                    </button>
                                                </form>

                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="tbl__cell text-center text-md" colspan="6">Нет комментариев</td>
                                    </tr>

                                @endforelse


                                </tbody>
                            </table>
                        </div>

                    </div>

                    {{-- Конец таблицы комментариев --}}

                </section>

                <section id="tab1Panel3" class="js-tabs__panel">
                    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                        @livewire('admin.create-links')
                    </div>
                </section>

            </div>

        </div>

        @endsection

        @push('js')
            <script src="{{ asset("js/admin/prism.min.js") }}"></script>
        @endpush

