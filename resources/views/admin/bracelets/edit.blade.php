@extends('admin.layouts.base')

@section('content')

<div class="container">
  <div class="tabs js-tabs">
    <ul class="flex flex-wrap gap-sm js-tabs__controls" aria-label="Tabs Interface">
      <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Браслет</a></li>
      <li><a href="#tab1Panel2" class="tabs__control">Отзывы</a></li>
    </ul>

    <div class="js-tabs__panels">
      <section id="tab1Panel1" class="padding-top-md js-tabs__panel">
        <form class="form-template-v3" method="POST" action="{{ route('bracelets.update', ['bracelet' => $bracelet->id]) }}">
          @csrf
          @method('PUT')
          <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
            <div class="text-component margin-bottom-md text-center">
              <h2>Редактирование браслета {{ $bracelet->name }}</h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            </div>
  
            <div class="margin-bottom-xs">
              <div class="grid gap-xxs items-center@md">
                <div class="col-4@md">
                  <label class="form-label" for="name">Название браслета</label>
                </div>
  
                <div class="col-8@md">
                  <input class="form-control width-100%" type="text" name="name" id="name" value="{{ $bracelet->name }}" required>
                </div>
              </div>
            </div>
  
            <div class="margin-bottom-xs">
              <div class="grid gap-xxs items-center@md">
                <div class="col-4@md">
                  <label class="form-label" for="slug">URI (SLUG)</label>
                </div>
  
                <div class="col-8@md">
                  <input class="form-control width-100%" type="text" name="slug" id="slug" value="{{ $bracelet->slug }}" required>
                </div>
              </div>
            </div>
  
            <div class="margin-bottom-xs">
              <div class="grid gap-xxs items-center@md">
                <div class="col-4@md">
                  <label class="form-label" for="title">Title</label>
                </div>
  
                <div class="col-8@md">
                  <input class="form-control width-100%" type="text" name="title" id="title" value="{{ $bracelet->title }}">
                </div>
              </div>
            </div>
  
            <div class="margin-bottom-xs">
              <div class="grid gap-xxs items-center@md">
                  <div class="col-4@md">
                      <label class="form-label" for="brand_id">Бренд</label>
                    </div>
                  <div class="col-8@md">
                      <div class="autocomplete position-relative select-auto js-select-auto js-autocomplete" data-autocomplete-dropdown-visible-class="autocomplete--results-visible">
                          <label class="form-label margin-bottom-xxs" for="autocomplete-input-id">Start typing Weasley:</label>
  
                          <!-- select -->
                          <select name="brand_id" id="brand_id" class="js-select-auto__select">
                              @foreach ($brands as $k => $v)
                              <option value="{{ $k }}" @if ($braceletbrand->name == $v)
                                selected
                              @endif>{{ $v }}</option>
                              @endforeach
  
                          </select>
  
                          <!-- input -->
                          <div class="select-auto__input-wrapper">
                            <input class="form-control js-autocomplete__input js-select-auto__input" type="text" name="autocomplete-input-id" id="autocomplete-input-id" placeholder="Выбрать бренд" autocomplete="off" value="{{ $braceletbrand->name }}">
  
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
              </div>
            </div>
  
            <div>
              <div class="grid gap-xxs items-center@md">
                <div class="col-4@md">
                  <label class="form-label" for="description">Описание</label>
                  <p class="text-xs color-contrast-medium margin-top-xxxxs">Опционально</p>
                </div>
  
                <div class="col-8@md">
                  <textarea class="form-control width-100%" name="description" id="code">{{ $bracelet->description }}</textarea>
                </div>
              </div>
            </div>
          </fieldset>
  
  
          <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
              <div class="text-component margin-bottom-md text-center">
                <h2>Общие</h2>
              </div>
  
              <div class="margin-bottom-xs">
                  <div class="grid gap-xxs items-center@md">
                    <div class="col-4@md">
                      <label class="form-label" for="year">Год выпуска</label>
                    </div>
  
                    <div class="col-8@md">
                      <input class="form-control width-100%" type="text" name="year" id="year">
                    </div>
                  </div>
                </div>
  
                <div class="margin-bottom-xs">
                  <div class="grid gap-xxs items-center@md">
                    <div class="col-4@md">
                      <label class="form-label" for="country">Страна</label>
                    </div>
  
                    <div class="col-8@md">
                      <input class="form-control width-100%" type="text" name="country" id="country">
                    </div>
                  </div>
                </div>
  
                <div class="margin-bottom-xs">
                  <div class="grid gap-xxs items-center@md">
                    <div class="col-4@md">
                      <label class="form-label" for="compatibility">Совместимость</label>
                    </div>
  
                    <div class="col-8@md">
                      <input class="form-control width-100%" type="text" name="compatibility" id="compatibility">
                    </div>
                  </div>
                </div>
  
                <div class="margin-bottom-xs">
                  <div class="grid gap-xxs items-center@md">
                    <div class="col-4@md">
                      <label class="form-label" for="assistant_app">Приложение ассистент</label>
                    </div>
  
                    <div class="col-8@md">
                      <input class="form-control width-100%" type="text" name="assistant_app" id="assistant_app">
                    </div>
                  </div>
                </div>
  
              <div class="margin-bottom-md">
                <div class="grid gap-xxs items-center@md">
                  <div class="col-4@md">
                    <div class="form-label">Make a choice</div>
                  </div>
  
                  <div class="col-8@md">
                    <ul class="flex flex-wrap gap-md">
                      <li>
                        <input class="radio" type="radio" name="radioButton" id="radio1" checked>
                        <label for="radio1">Option 1</label>
                      </li>
  
                      <li>
                        <input class="radio" type="radio" name="radioButton" id="radio2">
                        <label for="radio2">Option 2</label>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
  
              <div class="flex flex-column items-start">
                  <label class="form-label margin-bottom-xxxs" for="material">Select one or multiple options:</label>
  
                  <div class="multi-select inline-block js-multi-select" data-trigger-class="btn btn--subtle justify-between" data-no-select-text="Материал" data-multi-select-text="{n} выбрано" data-inset-label="on">
                    <select name="material[]" id="material[]" multiple>
                      <option value="силикон" @if(in_array('силикон', $bracelet->material)) selected @endif>силикон</option>
                      <option value="металл" @if(in_array('металл', $bracelet->material)) selected @endif>металл</option>
                      <option value="резина" @if(in_array('резина', $bracelet->material)) selected @endif>резина</option>
                      <option value="кожа" @if(in_array('кожа', $bracelet->material)) selected @endif>кожа</option>
                      <option value="фторэластомер" @if(in_array('фторэластомер', $bracelet->material)) selected @endif>фторэластомер</option>
                      <option value="текстиль" @if(in_array('текстиль', $bracelet->material)) selected @endif>текстиль</option>
                      <option value="нейлон" @if(in_array('нейлон', $bracelet->material)) selected @endif>нейлон</option>
                    </select>
  
                    <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
                  </div>
                </div>
              <div>
                <div class="grid gap-xxs items-center@md">
                  <div class="col-4@md">
                    <div class="form-label">Choose 1+ options</div>
                  </div>
  
                  <div class="col-8@md">
                    <ul class="flex flex-wrap gap-md">
                      <li>
                        <input class="checkbox" type="checkbox" id="checkbox1">
                        <label for="checkbox1">Option 1</label>
                      </li>
  
                      <li>
                        <input class="checkbox" type="checkbox" id="checkbox2">
                        <label for="checkbox2">Option 2</label>
                      </li>
  
                      <li>
                        <input class="checkbox" type="checkbox" id="checkbox3">
                        <label for="checkbox3">Option 3</label>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </fieldset>
            <h2>Рейтинги</h2>
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
                        <textarea x-model="field.text_rating" class="form-control width-100%" name="text_rating[]" id="code"></textarea>
                      </td>
                       <td class="table__cell" role="cell"><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                    </tr>
                   </template>
                  </tbody>
                  <tfoot>
                    <tr class="table__row">
                       <td colspan="4" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Добавить браслет</button></td>
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
                        <input x-model="field.value" class="form-control" type="number" name="value[]" min="1" max="10" step="0.01">
                      </td>
                      <td class="table__cell  text-left" role="cell">
                        <input x-model="field.position_grade" class="form-control" type="number" name="position_grade[]" min="0" max="10" step="1">
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
  
          <div class="text-right">
            <button type="submit" class="btn btn--primary">Отправить</button>
          </div>
        </form>
      </section>

      <section id="tab1Panel2" class="padding-top-md js-tabs__panel">
        <div class="text-component">
          <h1 class="text-lg">Отзывы</h1>
          <p>Список отзывов для браслета</p>

          <div class="bg radius-md padding-md shadow-xs">
            <p class="color-contrast-medium margin-bottom-sm">Таблица отзывов</p>
          
            <div class="int-table-actions padding-bottom-xxxs border-bottom border-contrast-lower" data-table-controls="table-1">
          
              <menu class="menu-bar js-int-table-actions__no-items-selected js-menu-bar">
                <li class="menu-bar__item menu-bar__item--trigger js-menu-bar__trigger" role="menuitem" aria-label="More options">
                  <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" /></svg>
                </li>
          
                <li class="menu-bar__item " role="menuitem">
                  <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M8,3c1.179,0,2.311,0.423,3.205,1.17L8.883,6.492l6.211,0.539L14.555,0.82l-1.93,1.93 C11.353,1.632,9.71,1,8,1C4.567,1,1.664,3.454,1.097,6.834l1.973,0.331C3.474,4.752,5.548,3,8,3z"></path>
                      <path d="M8,13c-1.179,0-2.311-0.423-3.205-1.17l2.322-2.322L0.906,8.969l0.539,6.211l1.93-1.93 C4.647,14.368,6.29,15,8,15c3.433,0,6.336-2.454,6.903-5.834l-1.973-0.331C12.526,11.248,10.452,13,8,13z"></path>
                    </g>
                  </svg>
                  <span class="menu-bar__label">Refresh</span>
                </li>
          
                <li class="menu-bar__item " role="menuitem">
                  <a href="{{ route('reviews.create') }}"><svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M15,16H1c-0.6,0-1-0.4-1-1V3c0-0.6,0.4-1,1-1h3v2H2v10h12V9h2v6C16,15.6,15.6,16,15,16z"></path>
                      <path d="M10,3c-3.2,0-6,2.5-6,7c1.1-1.7,2.4-3,6-3v3l6-5l-6-5V3z"></path>
                    </g>
                  </svg>
                  <span class="menu-bar__label">Export</span>
                </a>
                </li>
              </menu>
          
              <menu class="menu-bar is-hidden js-int-table-actions__items-selected js-menu-bar">
                <li class="menu-bar__item menu-bar__item--trigger js-menu-bar__trigger" role="menuitem" aria-label="More options">
                  <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" /></svg>
                </li>
          
                <li class="menu-bar__item " role="menuitem">
                  <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M2,6v8c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V6H2z"></path>
                      <path d="M12,3V1c0-0.6-0.4-1-1-1H5C4.4,0,4,0.4,4,1v2H0v2h16V3H12z M10,3H6V2h4V3z"></path>
                    </g>
                  </svg>
                  <span class="menu-bar__label">Delete</span>
                </li>
          
                <li class="menu-bar__item " role="menuitem">
                  <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M15.977,4.887a.975.975,0,0,0-.04-.2.909.909,0,0,0-.089-.186,1.048,1.048,0,0,0-.048-.1l-3-4A1,1,0,0,0,12,0H4a1,1,0,0,0-.8.4l-3,4a1.048,1.048,0,0,0-.048.1.892.892,0,0,0-.089.187.957.957,0,0,0-.04.2A.885.885,0,0,0,0,5v9a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V5A.87.87,0,0,0,15.977,4.887ZM8,13.5,5,10H7V7H9v3h2ZM3,4,4.5,2h7L13,4Z"></path>
                    </g>
                  </svg>
                  <span class="menu-bar__label">Archive</span>
                </li>
          
                <li class="menu-bar__item " role="menuitem">
                  <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g>
                      <path d="M14.6,5.6l-8.2,8.2C6.9,13.9,7.5,14,8,14c3.6,0,6.4-3.1,7.6-4.9c0.5-0.7,0.5-1.6,0-2.3 C15.4,6.5,15,6.1,14.6,5.6z"></path>
                      <path d="M14.3,0.3L11.6,3C10.5,2.4,9.3,2,8,2C4.4,2,1.6,5.1,0.4,6.9c-0.5,0.7-0.5,1.6,0,2.2c0.5,0.8,1.4,1.8,2.4,2.7 l-2.5,2.5c-0.4,0.4-0.4,1,0,1.4C0.5,15.9,0.7,16,1,16s0.5-0.1,0.7-0.3l14-14c0.4-0.4,0.4-1,0-1.4S14.7-0.1,14.3,0.3z M5.3,9.3 C5.1,8.9,5,8.5,5,8c0-1.7,1.3-3,3-3c0.5,0,0.9,0.1,1.3,0.3L5.3,9.3z"></path>
                    </g>
                  </svg>
                  <span class="menu-bar__label">Hide</span>
                </li>
          
              </menu>
            </div>
          
            <div id="table-1" class="int-table text-sm js-int-table">
              <div class="int-table__inner">
                @if (count($reviews))
                <table class="int-table__table" aria-label="Interactive table example">
                  <thead class="int-table__header js-int-table__header">
                    <tr class="int-table__row">
                      <td class="int-table__cell">
                        <div class="custom-checkbox int-table__checkbox">
                          <input class="custom-checkbox__input js-int-table__select-all" type="checkbox" aria-label="Select all rows" />
                          <div class="custom-checkbox__control" aria-hidden="true"></div>
                        </div>
                      </td>
          
                      <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort">
                        <div class="flex items-center">
                          <span>ID</span>
          
                          <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                            <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                            <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" /></svg>
                        </div>
          
                        <ul class="sr-only js-int-table__sort-list">
                          <li>
                            <input type="radio" name="sortingId" id="sortingIdNone" value="none" checked>
                            <label for="sortingIdNone">No sorting</label>
                          </li>
          
                          <li>
                            <input type="radio" name="sortingId" id="sortingIdAsc" value="asc">
                            <label for="sortingIdAsc">Sort in ascending order</label>
                          </li>
          
                          <li>
                            <input type="radio" name="sortingId" id="sortingIdDes" value="desc">
                            <label for="sortingIdDes">Sort in descending order</label>
                          </li>
                        </ul>
                      </th>
          
                      <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort">
                        <div class="flex items-center">
                          <span>Название</span>
          
                          <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                            <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                            <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" /></svg>
                        </div>
          
                        <ul class="sr-only js-int-table__sort-list">
                          <li>
                            <input type="radio" name="sortingName" id="sortingNameNone" value="none" checked>
                            <label for="sortingNameNone">No sorting</label>
                          </li>
          
                          <li>
                            <input type="radio" name="sortingName" id="sortingNameAsc" value="asc">
                            <label for="sortingNameAsc">Sort in ascending order</label>
                          </li>
          
                          <li>
                            <input type="radio" name="sortingName" id="sortingNameDes" value="desc">
                            <label for="sortingNameDes">Sort in descending order</label>
                          </li>
                        </ul>
                      </th>
          
                      <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort">
                        <div class="flex items-center">
                          <span>Title</span>
          
                          <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                            <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                            <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" /></svg>
                        </div>
          
                        <ul class="sr-only js-int-table__sort-list">
                          <li>
                            <input type="radio" name="sortingEmail" id="sortingEmailNone" value="none" checked>
                            <label for="sortingEmailNone">No sorting</label>
                          </li>
          
                          <li>
                            <input type="radio" name="sortingEmail" id="sortingEmailAsc" value="asc">
                            <label for="sortingEmailAsc">Sort in ascending order</label>
                          </li>
          
                          <li>
                            <input type="radio" name="sortingEmail" id="sortingEmailDes" value="desc">
                            <label for="sortingEmailDes">Sort in descending order</label>
                          </li>
                        </ul>
                      </th>
          
                      <th class="int-table__cell int-table__cell--th text-left">
                        Description
                      </th>
          
                      <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort" data-date-format="dd-mm-yyyy">
                        <div class="flex items-center">
                          <span>Добавлен</span>
          
                          <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                            <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                            <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" /></svg>
                        </div>
          
                        <ul class="sr-only js-int-table__sort-list">
                          <li>
                            <input type="radio" name="sortingDate" id="sortingDateNone" value="none" checked>
                            <label for="sortingDateNone">No sorting</label>
                          </li>
          
                          <li>
                            <input type="radio" name="sortingDate" id="sortingDateAsc" value="asc">
                            <label for="sortingDateAsc">Sort in ascending order</label>
                          </li>
          
                          <li>
                            <input type="radio" name="sortingDate" id="sortingDateDes" value="desc">
                            <label for="sortingDateDes">Sort in descending order</label>
                          </li>
                        </ul>
                      </th>
                        <th class="int-table__cell int-table__cell--th text-left">Action</th>
                    </tr>
                  </thead>
          
                  <tbody class="int-table__body js-int-table__body">
                    @foreach ($reviews as $review)
                    <tr class="int-table__row">
                      <th class="int-table__cell" scope="row">
                        <div class="custom-checkbox int-table__checkbox">
                          <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                          <div class="custom-checkbox__control" aria-hidden="true"></div>
                        </div>
                      </th>
                      <td class="int-table__cell">{{ $review->id }}</td>
                      <td class="int-table__cell"><a href="{{ route('reviews.edit', ['review' => $review->id]) }}">{{ $review->name }}</a></td>
                      <td class="int-table__cell"></td>
                      <td class="int-table__cell max-width-xxxxs">{{ $review->review_text }}</td>
                      <td class="int-table__cell">{{ $review->created_at->diffForHumans() }}</td>
                      <td class="int-table__cell">
        
                        <form method="POST" action="{{ route('reviews.destroy', ['review' => $review->id]) }}">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn--primary text-sm">Удалить</button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
        
                @else
                 <p>Таблица брендов пустая</p>
                @endif
              </div>
            </div>
          
          
            <div class="flex items-center justify-between padding-top-sm">
              <p class="text-sm">450 results</p>
          
              {{ $reviews->links() }}
              {{-- <nav class="pagination text-sm" aria-label="Pagination">
                <ul class="pagination__list flex flex-wrap gap-xxxs">
                  <li>
                    <a href="#0" class="pagination__item">
                      <svg class="icon" viewBox="0 0 16 16">
                        <title>Go to previous page</title>
                        <g stroke-width="1.5" stroke="currentColor">
                          <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="9.5,3.5 5,8 9.5,12.5 "></polyline>
                        </g>
                      </svg>
                    </a>
                  </li>
          
                  <li>
                    <span class="pagination__jumper flex items-center">
                      <input aria-label="Page number" class="form-control" type="text" id="pageNumber" name="pageNumber" value="1">
                      <em>of 50</em>
                    </span>
                  </li>
          
                  <li>
                    <a href="#0" class="pagination__item">
                      <svg class="icon" viewBox="0 0 16 16">
                        <title>Go to next page</title>
                        <g stroke-width="1.5" stroke="currentColor">
                          <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline>
                        </g>
                      </svg>
                    </a>
                  </li>
                </ul>
              </nav> --}}
            </div>
          </div>
        </div>
      </section>
    </div>
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
      fields: [
        @foreach ($bracelet->ratings as $item)
        {
          'ratings': '{{ $item->id }}',
          'position': '{{ $item->pivot->position }}',
          'text_rating': '{!! $item->pivot->text_rating !!}'
        },
        @endforeach
      ],
      addNewField() {
          this.fields.push({
              ratings: '',
              position: '',
              text_rating: '',
           });
        },
        removeField(index) {
           this.fields.splice(index, 1);
         }
      }
  }

  function handler2() {
      return {
        fields: [
          @foreach ($bracelet->grades as $item)
        {
          'grades': '{{ $item->id }}',
          'value': '{{ $item->pivot->value }}',
          'position_grade': '{{ $item->pivot->position }}'
        },
        @endforeach
        ],
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
        fields: [
          @foreach ($bracelet->sellers as $item)
        {
          'sellers': '{{ $item->id }}',
          'link': '{{ $item->pivot->link }}',
          'price': '{{ $item->pivot->price }}',
          'old_price': '{{ $item->pivot->old_price }}'
        },
        @endforeach
        ],
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
    </script>
@endsection