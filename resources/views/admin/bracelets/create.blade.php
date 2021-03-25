@extends('admin.layouts.base')

@section('content')

<div class="container">
  <form class="form-template-v3" method="POST" action="{{ route('bracelets.store') }}"  enctype="multipart/form-data">
    @csrf
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Новый браслет</h2>
        <p>Добавить новый браслет в каталог.</p>
      </div>

      <div class="margin-y-sm">
        <input class="checkbox" type="checkbox" id="popular" name="popular">
        <label for="popular">Популярный</label>&nbsp;&nbsp;&nbsp;
        
        <input class="checkbox" type="checkbox" id="hit" name="hit">
        <label for="hit">Лидер</label>&nbsp;&nbsp;&nbsp;
        
        <input class="checkbox" type="checkbox" id="published" name="published" checked>
        <label for="published">Опубликован</label>&nbsp;&nbsp;&nbsp;
        
        <input class="checkbox" type="checkbox" id="selection" name="selection">
        <label for="selection">Учавствует в подборе</label>&nbsp;&nbsp;&nbsp;
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="name">Название модели</label>
          <input class="form-control width-100%" type="text" name="name" id="name">
          <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название, menutitle</p>
        </div>

        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="slug">URI (SLUG)</label>
        <input class="form-control width-100%" type="text" name="slug" id="slug">
        </div>
      </div>

      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="title">Title</label>
        <input class="form-control width-100%" type="text" name="title" id="title">
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="subtitle">Subtitle (h1)</label>
          <input class="form-control width-100%" type="text" name="subtitle" id="subtitle">
        </div>
        <div class="col-6@md">
          <div class="character-count js-character-count">
            <label class="form-label margin-bottom-xxs" for="textareaName">Description:</label>
            <textarea class="form-control width-100% js-character-count__input" name="description" id="description" maxlength="300"></textarea>
            <div class="character-count__helper character-count__helper--dynamic text-sm margin-top-xxxs" aria-live="polite" aria-atomic="true">
              Осталось <span class="js-character-count__counter"></span> символов
            </div>
            <div class="character-count__helper character-count__helper--static text-sm margin-top-xxxs">Макс 300 символов</div>
          </div>
        </div>
      </div>


      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <div class="autocomplete position-relative select-auto js-select-auto js-autocomplete" data-autocomplete-dropdown-visible-class="autocomplete--results-visible">
                    <label class="form-label margin-bottom-xxs" for="autocomplete-input-id">Выбрать бренд:</label>

                    <!-- select -->
                    <select name="brand_id" id="brand_id" class="js-select-auto__select">
                        @foreach ($brands as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach

                    </select>

                    <!-- input -->
                    <div class="select-auto__input-wrapper">
                      <input class="form-control js-autocomplete__input js-select-auto__input" type="text" name="autocomplete-input-id" id="autocomplete-input-id" placeholder="Выбрать бренд" autocomplete="off">

                      <div class="select-auto__input-icon-wrapper">
                        <!-- arrow icon -->
                        <svg class="icon" viewBox="0 0 16 16">
                          <title>Open selection</title>
                          <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>

                        <!-- close X icon -->
                        <button class="reset select-auto__input-btn js-select-auto__input-btn js-tab-focus">
                          <svg class="icon" viewBox="0 0 16 16">
                            <title>Reset selection</title>
                            <path d="M8,0a8,8,0,1,0,8,8A8,8,0,0,0,8,0Zm3.707,10.293a1,1,0,1,1-1.414,1.414L8,9.414,5.707,11.707a1,1,0,0,1-1.414-1.414L6.586,8,4.293,5.707A1,1,0,0,1,5.707,4.293L8,6.586l2.293-2.293a1,1,0,1,1,1.414,1.414L9.414,8Z" />
                          </svg>
                        </button>
                      </div>
                    </div>

                    <!-- dropdown -->
                    <div class="autocomplete__results select-auto__results js-autocomplete__results">
                      <ul id="autocomplete1" class="autocomplete__list js-autocomplete__list">
                        <li class="select-auto__group-title padding-y-xs padding-x-sm color-contrast-medium is-hidden js-autocomplete__result" data-autocomplete-template="optgroup" role="presentation">
                          <span class="text-truncate text-sm" data-autocomplete-label></span>
                        </li>

                        <li class="select-auto__option padding-y-xs padding-x-sm is-hidden js-autocomplete__result" data-autocomplete-template="option">
                          <span class="is-hidden" data-autocomplete-value></span>
                          <div class="text-truncate" data-autocomplete-label></div>
                        </li>

                        <li class="select-auto__no-results-msg padding-y-xs padding-x-sm text-truncate is-hidden js-autocomplete__result" data-autocomplete-template="no-results" role="presentation"></li>
                      </ul>
                    </div>
                    <p class="sr-only" aria-live="polite" aria-atomic="true"><span class="js-autocomplete__aria-results">0</span> нет результатов.</p>
                  </div>
        </div>

        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="position">Позиция для каталога</label>
        <input class="form-control width-100%" type="number" name="position" id="position" min="0" max="300" step="1" value="1">
        </div>
      </div>

      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="about">Описание</label>
            <textarea class="form-control width-100%" name="about" id="code"></textarea>
      </div>
    </fieldset>


    <fieldset>
    <div class="text-component margin-bottom-md text-center">
      <h2>Плюсы - Минусы</h2>
    </div>
     <div class="grid gap-xs margin-y-xs">
      <div class="col-6@md">
        <div class="js-repeater" data-repeater-input-name="plus[n]">
        <ul class="grid gap-xs js-repeater__list">
          <li class="js-repeater__item">
            <div class="grid gap-xs">
              <input class="form-control col" type="text" name="plus[0]" id="plus[0]" placeholder="Плюс">

              <button class="btn btn--subtle padding-x-xs col-content js-repeater__remove" type="button">
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
          </li>
        </ul>

        <button class="btn btn--success width-100% margin-top-xs js-repeater__add" type="button">+ Плюс</button>
      </div>
      </div>
      <div class="col-6@md">
        <div class="js-repeater" data-repeater-input-name="minus[n]">
        <ul class="grid gap-xs js-repeater__list">
          <li class="js-repeater__item">
            <div class="grid gap-xs">
              <input class="form-control col" type="text" name="minus[0]" id="minus[0]" placeholder="Минус">

              <button class="btn btn--subtle padding-x-xs col-content js-repeater__remove" type="button">
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
          </li>
        </ul>

        <button class="btn btn--accent width-100% margin-top-xs js-repeater__add" type="button">+ Минус</button>
      </div>
      </div>

    </div>
<div class="text-component margin-bottom-md text-center">
          <h2>Покупателям нравится</h2>
        </div>
    <div class="js-repeater" data-repeater-input-name="buyers_like[n]">
      <ul class="grid gap-xs js-repeater__list">
        <li class="js-repeater__item">
          <div class="grid gap-xs">
            <input class="form-control col" type="text" name="buyers_like[0]" id="buyers_like[0]" placeholder="Что нравится">

            <button class="btn btn--subtle padding-x-xs col-content js-repeater__remove" type="button">
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
        </li>
      </ul>

      <button class="btn btn--primary width-100% margin-top-xs js-repeater__add" type="button">+ Добавить поле</button>
    </div>
    </fieldset>

    <fieldset class="margin-y-md padding-bottom-md border-bottom">
        <div class="text-component margin-bottom-md text-center">
          <h2>Общие</h2>
        </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxs" for="year">Год выпуска</label>
          <input class="form-control width-100%" type="number" name="year" id="year" min="2010" max="2022" step="1" value="2020">
        </div>
        <div class="col-4@md">
          <div class="autocomplete position-relative select-auto js-select-auto js-autocomplete" data-autocomplete-dropdown-visible-class="autocomplete--results-visible">
            <label class="form-label margin-bottom-xxs" for="autocomplete-input-id">Выбрать страну:</label>

            <!-- select -->
            <select name="country" id="country" class="js-select-auto__select">
                <option value="Россия">Россия</option>
                <option value="Китай">Китай</option>
                <option value="США">США</option>
                <option value="Южная Корея">Южная Корея</option>
                <option value="Канада">Канада</option>
                <option value="Финляндия">Финляндия</option>
                <option value="Япония">Япония</option>
            </select>

            <!-- input -->
            <div class="select-auto__input-wrapper">
              <input class="form-control js-autocomplete__input js-select-auto__input" type="text" name="autocomplete-input-id" id="autocomplete-input-id" placeholder="Выбрать страну" autocomplete="off">

              <div class="select-auto__input-icon-wrapper">
                <!-- arrow icon -->
                <svg class="icon" viewBox="0 0 16 16">
                  <title>Open selection</title>
                  <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>

                <!-- close X icon -->
                <button class="reset select-auto__input-btn js-select-auto__input-btn js-tab-focus">
                  <svg class="icon" viewBox="0 0 16 16">
                    <title>Reset selection</title>
                    <path d="M8,0a8,8,0,1,0,8,8A8,8,0,0,0,8,0Zm3.707,10.293a1,1,0,1,1-1.414,1.414L8,9.414,5.707,11.707a1,1,0,0,1-1.414-1.414L6.586,8,4.293,5.707A1,1,0,0,1,5.707,4.293L8,6.586l2.293-2.293a1,1,0,1,1,1.414,1.414L9.414,8Z" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- dropdown -->
            <div class="autocomplete__results select-auto__results js-autocomplete__results">
              <ul id="autocomplete1" class="autocomplete__list js-autocomplete__list">
                <li class="select-auto__group-title padding-y-xs padding-x-sm color-contrast-medium is-hidden js-autocomplete__result" data-autocomplete-template="optgroup" role="presentation">
                  <span class="text-truncate text-sm" data-autocomplete-label></span>
                </li>

                <li class="select-auto__option padding-y-xs padding-x-sm is-hidden js-autocomplete__result" data-autocomplete-template="option">
                  <span class="is-hidden" data-autocomplete-value></span>
                  <div class="text-truncate" data-autocomplete-label></div>
                </li>

                <li class="select-auto__no-results-msg padding-y-xs padding-x-sm text-truncate is-hidden js-autocomplete__result" data-autocomplete-template="no-results" role="presentation"></li>
              </ul>
            </div>
            <p class="sr-only" aria-live="polite" aria-atomic="true"><span class="js-autocomplete__aria-results">0</span> results found.</p>
          </div>
        </div>
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxs" for="compatibility">Совместимость</label>
          <input class="form-control width-100%" type="text" name="compatibility" id="compatibility">
        </div>
      </div>
      <div class="grid gap-xxs">
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxs" for="assistant_app">Приложение ассистент</label>
          <input class="form-control width-100%" type="text" name="assistant_app" id="assistant_app">
        </div>

      </div>
    </fieldset>

    <fieldset class="margin-y-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Конструкция</h2>
      </div>
      <div class="grid gap-xxs">
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxs" for="material">Материал браслета/ремешка</label>
            <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
              <select name="material[]" id="material[]" multiple>
                <option value="силикон">силикон</option>
                <option value="металл">металл</option>
                <option value="резина">резина</option>
                <option value="кожа">кожа</option>
                <option value="фторэластомер">фторэластомер</option>
                <option value="текстиль">текстиль</option>
                <option value="нейлон">нейлон</option>
                <option value="термополиуретан">термополиуретан</option>
              </select>


              <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
            </div>
        </div>
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxs" for="colors">Возможные цвета</label>
            <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
              <select name="colors[]" id="colors[]" multiple>
                <option value="черный">черный</option>
                <option value="белый">белый</option>
                <option value="голубой">голубой</option>
                <option value="желтый">желтый</option>
                <option value="зеленый">зеленый</option>
                <option value="коричневый">коричневый</option>
                <option value="красный">красный</option>
                <option value="оранжевый">оранжевый</option>
                <option value="розовый">розовый</option>
                <option value="серый">серый</option>
                <option value="синий">синий</option>
                <option value="фиолетовый">фиолетовый</option>
              </select>
              <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
            </div>
        </div>
      </div>

      <div class="grid gap-xxs margin-y-md">
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxs" for="protect_stand">Стандарты защиты</label>
            <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
              <select name="protect_stand[]" id="protect_stand[]" multiple>
                <option value="IP68">IP68</option>
                <option value="IP57">IP57</option>
                <option value="WR50">WR50</option>
                <option value="IP67">IP67</option>
                <option value="WR20">WR20</option>
                <option value="WR30">WR30</option>
                <option value="IPX5">IPX5</option>
                <option value="IP65">IP65</option>
                <option value="IP56">IP56</option>
              </select>

              <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
            </div>
        </div>
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxs" for="terms_of_use">Допустимые условия использования</label>
            <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
              <select name="terms_of_use[]" id="terms_of_use[]" multiple>
                <option value="пыль">пыль</option>
                <option value="брызги">брызги</option>
                <option value="дождь">дождь</option>
                <option value="мытье рук">мытье рук</option>
                <option value="душ">душ</option>
                <option value="плавание">плавание</option>
              </select>
              <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
            </div>
        </div>
      </div>

      <div class="margin-y-sm">
        <input class="checkbox" type="checkbox" id="replaceable_strap" name="replaceable_strap">
        <label for="replaceable_strap">Сменный браслет/ремешок</label>&nbsp;&nbsp;&nbsp;
        <input class="checkbox" type="checkbox" id="lenght_adj" name="lenght_adj">
        <label for="lenght_adj">Регулировка длины ремешка</label>&nbsp;&nbsp;&nbsp;
      </div>

      <div class="grid gap-xxs">
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="dimensions">Размеры</label>
          <input class="form-control width-100%" type="text" name="dimensions">
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="weight">Вес</label>
          <input class="form-control width-100%" type="number" name="weight" min="1" max="300" step="0.1" value="">
        </div>
      </div>
    </fieldset>

    <fieldset class="margin-y-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Дисплей</h2>
      </div>

      <div class="grid gap-xxs">
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="disp_tech">Технология дисплея:</label>
          <div class="select">
            <select class="select__input form-control" name="disp_tech" id="disp_tech">
                <option value="">Выбрать из списка</option>
                <option value="AMOLED">AMOLED</option>
                <option value="IPS">IPS</option>
                <option value="TFT">TFT</option>
                <option value="POLED">POLED</option>
                <option value="OLED">OLED</option>
                <option value="LCD">LCD</option>
            </select>
            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
          </div>
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="disp_resolution">Разрешение дисплея</label>
          <input class="form-control width-100%" type="text" name="disp_resolution">
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="disp_ppi">Плотность пикселей (PPI)</label>
          <input class="form-control width-100%" type="number" name="disp_ppi" min="100" max="1000" step="1" value="">
        </div>
      </div>

      <div class="grid gap-xxs margin-y-sm">
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="disp_brightness">Яркость (нит)</label>
          <input class="form-control width-100%" type="number" name="disp_brightness" min="100" max="1000" step="1" value="">
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="disp_col_depth">Глубина цвета (бит)</label>
          <input class="form-control width-100%" type="number" name="disp_col_depth" min="16" max="256" step="1" value="">
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="disp_diag">Диагональ (дюймы)</label>
          <input class="form-control width-100%" type="number" name="disp_diag" min="0.1" max="3" step="0.1" value="">
        </div>
        <div class="col-3@md"></div>
      </div>

      <div class="margin-y-sm">
        <input class="checkbox" type="checkbox" id="disp_sens" name="disp_sens">
        <label for="disp_sens">Сенсорный</label>&nbsp;&nbsp;&nbsp;
        <input class="checkbox" type="checkbox" id="disp_color" name="disp_color">
        <label for="disp_color">Цветной</label>&nbsp;&nbsp;&nbsp;
        <input class="checkbox" type="checkbox" id="disp_aod" name="disp_aod">
        <label for="disp_aod">Always on Display (AoD)</label>
      </div>

    </fieldset>

    <fieldset class="margin-y-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Модули и датчики</h2>
      </div>

      <div class="grid gap-xxs margin-y-sm">
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxs" for="sensors">Датчики</label>
          <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
            <select name="sensors[]" id="sensors[]" multiple>
              <option value="акселерометр">акселерометр</option>
              <option value="GPS">GPS</option>
              <option value="пульсометр">пульсометр</option>
              <option value="гироскоп">гироскоп</option>
              <option value="датчик освещенности">датчик освещенности</option>
              <option value="термометр">термометр</option>
              <option value="высотомер">высотомер</option>
            </select>
            <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
          </div>
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxs" for="other_interfaces">Другие интерфейсы</label>
          <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
            <select name="other_interfaces[]" id="other_interfaces[]" multiple>
              <option value="Wi-Fi">Wi-Fi</option>
              <option value="USB">USB</option>
              <option value="BLE">BLE</option>
              <option value="ANT+">ANT+</option>
              <option value="BR">BR</option>
              <option value="EDR">EDR</option>
            </select>
            <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
          </div>
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="nfc">NFC</label>
          <input class="form-control width-100%" type="text" name="nfc">
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="blue_ver">Весия Bluetooth</label>
          <input class="form-control width-100%" type="number" name="blue_ver" min="2" max="8" step="0.1" value="">
        </div>
      </div>

      <div class="margin-y-sm">
        <input class="checkbox" type="checkbox" id="gps" name="gps">
        <label for="gps">Встроенный GPS</label>&nbsp;&nbsp;&nbsp;
        <input class="checkbox" type="checkbox" id="vibration" name="vibration">
        <label for="vibration">Вибромотор</label>&nbsp;&nbsp;&nbsp;
      </div>

    </fieldset>

    <fieldset class="margin-y-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Связь</h2>
      </div>

      <div class="grid gap-xxs margin-y-sm">
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="phone_calls">Телефонные звонки</label>
          <input class="form-control width-100%" type="text" name="phone_calls">
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="notification">Уведомления</label>
          <input class="form-control width-100%" type="text" name="notification">
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="send_messages">Отправка сообщений с браслета</label>
          <input class="form-control width-100%" type="text" name="send_messages">
        </div>
        <div class="col-3@md"></div>
      </div>

    </fieldset>

    <fieldset class="margin-y-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Функционал</h2>
      </div>
      <div class="grid gap-xxs margin-y-sm">
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxs" for="monitoring">Мониторинг</label>
          <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
            <select name="monitoring[]" id="monitoring[]" multiple>
              <option value="пульса">пульса</option>
              <option value="сна">сна</option>
              <option value="калорий">калорий</option>
              <option value="физической активности">физической активности</option>
              <option value="стресса">стресса</option>
            </select>
            <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
          </div>
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxs" for="training_modes">Тренировочные режимы</label>
          <div class="multi-select js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
            <select name="training_modes[]" id="training_modes[]" multiple>
                <option value="ходьба на улице">ходьба на улице</option>
                <option value="ходьба">ходьба</option>
                <option value="велотренажер">велотренажер</option>
                <option value="бег на улице">бег на улице</option>
                <option value="бег">бег</option>
                <option value="беговая дорожка">беговая дорожка</option>
                <option value="ходьба на дорожке">ходьба на дорожке</option>
                <option value="свободная тренировка">свободная тренировка</option>
                <option value="скакалка">скакалка</option>
                <option value="велосипед">велосипед</option>
                <option value="подъем на гору">подъем на гору</option>
                <option value="плавание">плавание</option>
                <option value="пресс">пресс</option>
                <option value="альпинизм">альпинизм</option>
                <option value="скалолазание">скалолазание</option>
                <option value="баскетбол">баскетбол</option>
                <option value="футбол">футбол</option>
                <option value="поход">поход</option>
                <option value="горный спорт">горный спорт</option>
                <option value="настольный теннис">настольный теннис</option>
                <option value="эллиптический тренажер">эллиптический тренажер</option>
                <option value="игра с мячом">игра с мячом</option>
                <option value="90 альтернативных активностей">90 альтернативных активностей</option>
                <option value="плавание в бассейне">плавание в бассейне</option>
                <option value="жиросжигательный бег">жиросжигательный бег</option>
                <option value="гребной тренажер">гребной тренажер</option>
                <option value="плавание в открытом водоеме">плавание в открытом водоеме</option>
                <option value="степпер">степпер</option>
                <option value="бадминтон">бадминтон</option>
                <option value="прыжки на скакалке">прыжки на скакалке</option>
                <option value="йога">йога</option>
                <option value="скручивания">скручивания</option>
                <option value="выпады">выпады</option>
                <option value="приседания">приседания</option>
                <option value="прыжки звезда">прыжки звезда</option>
                <option value="пилатес">пилатес</option>
            </select>
            <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
          </div>
        </div>
        <div class="col-3@md">
          <label class="form-label margin-bottom-xxxs" for="additional_info">Дополнительная информация</label>
          <textarea class="form-control width-100%" name="additional_info" id="additional_info"></textarea>
        </div>
      </div>

      <div class="grid gap-xxs margin-y-sm">
        <div class="col-6@md">
          <input class="checkbox" type="checkbox" id="heart_rate" name="heart_rate">
          <label for="heart_rate">Постоянное измерение пульса</label><br>
          <input class="checkbox" type="checkbox" id="bood_oxy" name="bood_oxy">
          <label for="bood_oxy">Измерение кислорода в крови</label><br>
          <input class="checkbox" type="checkbox" id="blood_pressure" name="blood_pressure">
          <label for="blood_pressure">Измерение артериального давления</label><br>
          <input class="checkbox" type="checkbox" id="stress" name="stress">
          <label for="stress">Измерение стресса</label><br>
          <input class="checkbox" type="checkbox" id="workout_recognition" name="workout_recognition">
          <label for="workout_recognition">Автоматическое распознавание тренировки</label><br>
          <input class="checkbox" type="checkbox" id="inactivity_reminder" name="inactivity_reminder">
          <label for="inactivity_reminder">Напоминание об отсутствии активности</label><br>
          <input class="checkbox" type="checkbox" id="search_smartphone" name="search_smartphone">
          <label for="search_smartphone">Поиск смартфона/браслета</label>
        </div>
        <div class="col-6@md">
          <input class="checkbox" type="checkbox" id="smart_alarm" name="smart_alarm">
          <label for="smart_alarm">Умный будильник</label><br>
          <input class="checkbox" type="checkbox" id="camera_control" name="camera_control">
          <label for="camera_control">Управление камерой смартфона</label><br>
          <input class="checkbox" type="checkbox" id="player_control" name="player_control">
          <label for="player_control">Управление плеером смартфона</label><br>
          <input class="checkbox" type="checkbox" id="timer" name="timer">
          <label for="timer">Таймер</label><br>
          <input class="checkbox" type="checkbox" id="stopwatch" name="stopwatch">
          <label for="stopwatch">Секундомер</label><br>
          <input class="checkbox" type="checkbox" id="women_calendar" name="women_calendar">
          <label for="women_calendar">Женский календарь</label><br>
          <input class="checkbox" type="checkbox" id="weather_forecast" name="weather_forecast">
          <label for="weather_forecast">Прогноз погоды</label><br>
        </div>
      </div>
    </fieldset>

    <fieldset class="margin-y-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Аккумулятор</h2>
      </div>
      <div class="grid gap-xxs margin-y-sm">
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxxs" for="type_battery">Тип:</label>
          <div class="select">
            <select class="select__input form-control" name="type_battery" id="type_battery">
                <option value="">Выбрать из списка</option>
                <option value="Li-Ion">Li-Ion</option>
                <option value="Li-Pol">Li-Pol</option>
            </select>
            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
          </div>
        </div>
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxxs" for="capacity_battery">Емкость (мАч)</label>
          <input class="form-control width-100%" type="number" name="capacity_battery" min="10" max="2000" step="1" value="">
        </div>
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxxs" for="standby_time">Время работы в режиме ожидания (часов)</label>
          <input class="form-control width-100%" type="number" name="standby_time" min="3" max="2000" step="1" value="">
        </div>
      </div>
      
      <div class="grid gap-xxs margin-y-sm">
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxxs" for="real_time">Реальное время работы (дней)</label>
          <input class="form-control width-100%" type="number" name="real_time" min="1" max="1000" step="1" value="">
        </div>
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxxs" for="full_charge_time">Время полной зарядки</label>
          <input class="form-control width-100%" type="number" name="full_charge_time" min="10" max="2000" step="1" value="">
        </div>
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxxs" for="charger">Зарядное устройство</label>
          <input class="form-control width-100%" type="text" name="charger">
        </div>
      </div>

    </fieldset>
      
    
    <input type="file" multiple name="files[]">


      <div class="row" x-data="handler()">
        <div class="col">

          <table class="table table--expanded@xs position-relative z-index-1 width-100% js-table">
            <thead class="table__header">
              <tr class="table__row">
                <th class="table__cell text-left" scope="col">#</th>
                <th class="table__cell text-left" scope="col">Рейтинг</th>
                <th class="table__cell text-right" scope="col">Позиция</th>
                <th class="table__cell text-right" scope="col">Текст</th>
                <th class="table__cell text-right" scope="col">Удалить</th>
              </tr>
            </thead>
            <tbody class="table__body">
              <template x-for="(field, index) in fields" :key="index">
              <tr class="table__row">
                <td x-text="index + 1"></td>
                <td class="table__cell" role="cell">
                  <div class="select">
                    <select class="select__input form-control" name="ratings[]"  x-model="field.ratings">
                      @foreach ($ratings as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                      @endforeach
                    </select>

                    <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                  </div>
                </td>
                <td class="table__cell  text-left" role="cell">
                  <input x-model="field.position" class="form-control" type="number" name="position[]" min="0" max="20" step="1">
                </td>
                <td class="table__cell" role="cell">
                  <textarea class="form-control width-100%" name="text_rating[]" id="code"></textarea>
                </td>
                 <td class="table__cell" role="cell"><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
              </tr>
             </template>
            </tbody>
            <tfoot>
              <tr class="table__row">
                 <td colspan="4" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Добавить рейтинг</button></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>


      <h2>Оценки</h2>

      <div class="row" x-data="handler2()">
        <div class="col">

          <table class="table table--expanded@xs position-relative z-index-1 width-100% js-table">
            <thead class="table__header">
              <tr class="table__row">
                <th class="table__cell text-left" scope="col">#</th>
                <th class="table__cell text-left" scope="col">Оценка</th>
                <th class="table__cell text-right" scope="col">Значение</th>
                <th class="table__cell text-right" scope="col">Позиция</th>
                <th class="table__cell text-right" scope="col">Удалить</th>
              </tr>
            </thead>
            <tbody class="table__body">
              <template x-for="(field, index) in fields" :key="index">
              <tr class="table__row">
                <td x-text="index + 1"></td>
                <td class="table__cell" role="cell">
                  <div class="select">
                    <select class="select__input form-control" name="grades[]"  x-model="field.grades">
                      @foreach ($grades as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                      @endforeach
                    </select>

                    <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                  </div>
                </td>
                <td class="table__cell  text-left" role="cell">
                  <input x-model="field.value" class="form-control" type="number" name="value[]" min="0" max="20" step="1">
                </td>
                <td class="table__cell  text-left" role="cell">
                  <input x-model="field.position_grade" class="form-control" type="number" name="position_grade[]" min="0" max="20" step="1">
                </td>
                 <td class="table__cell" role="cell"><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
              </tr>
             </template>
            </tbody>
            <tfoot>
              <tr class="table__row">
                 <td colspan="4" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Добавить оценку</button></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>


      <h2>Продавцы</h2>

      <div class="row" x-data="handler3()">
        <div class="col">

          <table class="table table--expanded@xs position-relative z-index-1 width-100% js-table">
            <thead class="table__header">
              <tr class="table__row">
                <th class="table__cell text-left" scope="col">#</th>
                <th class="table__cell text-left" scope="col">Название</th>
                <th class="table__cell text-right" scope="col">Значение</th>
                <th class="table__cell text-right" scope="col">Позиция</th>
                <th class="table__cell text-right" scope="col">Удалить</th>
              </tr>
            </thead>
            <tbody class="table__body">
              <template x-for="(field, index) in fields" :key="index">
              <tr class="table__row">
                <td x-text="index + 1"></td>
                <td class="table__cell" role="cell">
                  <div class="select">
                    <select class="select__input form-control" name="sellers[]"  x-model="field.sellers">
                      @foreach ($sellers as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                      @endforeach
                    </select>

                    <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                  </div>
                </td>
                <td class="table__cell  text-left" role="cell">
                  <input x-model="field.link" class="form-control" type="text" name="link[]">
                </td>
                <td class="table__cell  text-left" role="cell">
                  <input x-model="field.price" class="form-control" type="text" name="price[]">
                </td>

                <td class="table__cell  text-left" role="cell">
                  <input x-model="field.old_price" class="form-control" type="text" name="old_price[]">
                </td>
                 <td class="table__cell" role="cell"><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
              </tr>
             </template>
            </tbody>
            <tfoot>
              <tr class="table__row">
                 <td colspan="4" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Добавить оценку</button></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      
      
      <section class="bg bg-white padding-sm">
      <p class="color-contrast-medium margin-bottom-sm">Добавить картинки</p>
              <div class="row" x-data="handler4()">
                <table class="tbl__table border-bottom border-2" aria-label="Table Example">
                    <thead class="tbl__header border-bottom border-2">
                      <tr class="tbl__row">
                        <th class="tbl__cell text-left" scope="col">
                          <span class="text-xs text-uppercase letter-spacing-lg font-semibold">#</span>
                          </th>
  
                          <th class="tbl__cell text-left" scope="col">
                          <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Файл</span>
                          </th>
  
                          <th class="tbl__cell text-left" scope="col">
                          <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Alt</span>
                          </th>
  
                          <th class="tbl__cell" scope="col">
                          <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Удалить</span>
                          </th>
                      </tr>
                    </thead>
                    <tbody class="tbl__body">
                      <template x-for="(field, index) in fields" :key="index">
                      <tr class="tbl__row">
                        <td x-text="index + 1"></td>
                        <td class="tbl__cell" role="cell">
  
  
                            <input type="file" class="file-upload__input" name="files[]">
  
                         </td>
                        <td class="tbl__cell" role="cell">
                          <input x-model="field.nameimg" class="form-control" type="text" name="nameimg[]">
                        </td>
                         <td class="tbl__cell" role="cell"><button type="button" class="btn btn--accent text-sm" @click="removeField(index)">&times;</button></td>
                      </tr>
                     </template>
                    </tbody>
                    <tfoot>
                      <tr class="tbl__cell">
                         <td colspan="4" class="text-left"><button type="button" class="btn btn--success text-sm" @click="addNewField()">+ Добавить картинку</button></td>
                      </tr>
                    </tfoot>
                  </table>
              </div>
            </section>
    <div class="text-right">
      <button type="submit" class="btn btn--primary">Отправить</button>
    </div>
  </form>

</div>

@endsection

@section('scripts')
@parent
<script src="{{ asset("js/admin/alpine.min.js") }}"></script>
<script src="{{ asset("js/admin/codemirror.js") }}"></script>
    <script src="{{ asset("js/admin/closetag.js") }}"></script>
    <script src="{{ asset("js/admin/htmlmixed.js") }}"></script>
    <script src="{{ asset("js/admin/css.js") }}"></script>
    <script src="{{ asset("js/admin/javascript.js") }}"></script>
    <script src="{{ asset("js/admin/xml.js") }}"></script>
    <script src="{{ asset("js/admin/xml-fold.js") }}"></script>
    <script>
      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        mode: 'text/html',
        autoCloseTags: true
      });

  function handler() {
      return {
        fields: [],
        addNewField() {
            this.fields.push({
                ratings: '',
                position: '',
                text_rating: ''
            });
          },
          removeField(index) {
            this.fields.splice(index, 1);
          }
        }
  }


  function handler2() {
      return {
        fields: [],
        addNewField() {
            this.fields.push({
                grades: '',
                value: '',
                position_grade: ''
            });
          },
          removeField(index) {
            this.fields.splice(index, 1);
          }
        }
  }

  function handler3() {
      return {
        fields: [],
        addNewField() {
            this.fields.push({
                sellers: '',
                link: '',
                price: '',
                old_price: ''
            });
          },
          removeField(index) {
            this.fields.splice(index, 1);
          }
        }
  }

  function handler4() {
    return {
      fields: [],
      addNewField() {
          this.fields.push({
              files: '',
              nameimg: '',
              sizeimg: '',
           });
        },
        removeField(index) {
           this.fields.splice(index, 1);
         }

      }
  }
    </script>
@endsection