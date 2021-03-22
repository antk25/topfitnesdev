@extends('admin.layouts.base')

@section('content')

<div class="container">
  <div class="tabs js-tabs">
    <ul class="flex flex-wrap gap-sm js-tabs__controls" aria-label="Tabs Interface">
      <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Браслет</a></li>
      <li><a href="#tab1Panel2" class="tabs__control">Отзывы</a></li>
      <li><a href="#tab1Panel3" class="tabs__control">Картинки</a></li>
    </ul>

    <div class="js-tabs__panels">
      <section id="tab1Panel1" class="padding-top-md js-tabs__panel">
        <form class="form-template-v3" method="POST" action="{{ route('bracelets.update', ['bracelet' => $bracelet->id]) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
            <div class="text-component margin-bottom-md text-center">
              <h2>Редактирование браслета {{ $bracelet->name }}</h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            </div>
  
            <div class="margin-y-sm">
              <input class="checkbox" type="checkbox" id="popular" name="popular" @if ($bracelet->popular == 1)checked @endif>
              <label for="popular">Популярный</label>&nbsp;&nbsp;&nbsp;
              <input class="checkbox" type="checkbox" id="published" name="published" @if ($bracelet->published == 1)checked @endif>
              <label for="published">Опубликован</label>&nbsp;&nbsp;&nbsp;
            </div>
      
            <div class="grid gap-xxs margin-bottom-xs">
              <div class="col-6@md">
                <label class="form-label margin-bottom-xxs" for="name">Название модели</label>
                <input class="form-control width-100%" type="text" name="name" id="name" value="{{ $bracelet->name }}">
                <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название, menutitle</p>
              </div>
      
              <div class="col-6@md">
                <label class="form-label margin-bottom-xxs" for="slug">URI (SLUG)</label>
              <input class="form-control width-100%" type="text" name="slug" id="slug" value="{{ $bracelet->slug }}">
              </div>
            </div>
      
            <div class="margin-bottom-xs">
              <label class="form-label margin-bottom-xxs" for="title">Title</label>
              <input class="form-control width-100%" type="text" name="title" id="title" value="{{ $bracelet->title }}">
            </div>
      
            <div class="grid gap-xxs margin-bottom-xs">
              <div class="col-6@md">
                <label class="form-label margin-bottom-xxs" for="subtitle">Subtitle (h1)</label>
                <input class="form-control width-100%" type="text" name="subtitle" id="subtitle" value="{{ $bracelet->subtitle }}">
              </div>
              <div class="col-6@md">
                <div class="character-count js-character-count">
                  <label class="form-label margin-bottom-xxs" for="textareaName">Description:</label>
                  <textarea class="form-control width-100% js-character-count__input" name="description" id="description" maxlength="300">{{ $bracelet->description }}</textarea>
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
      
              <div class="col-6@md">
                <label class="form-label margin-bottom-xxs" for="position">Позиция для каталога</label>
              <input class="form-control width-100%" type="number" name="position" id="position" min="0" max="300" step="1" value="{{ $bracelet->position }}">
              </div>
            </div>
  
  
            <div class="margin-bottom-xs">
              <label class="form-label margin-bottom-xxs" for="about">Описание</label>
              <textarea class="form-control width-100%" name="about" id="code">{{ $bracelet->about }}</textarea>
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
                  @foreach ($bracelet->plus as $plus)
                  <li class="js-repeater__item">
                    <div class="grid gap-xs">
                      <input class="form-control col" type="text" name="plus[{{ $loop->index }}]" id="plus[{{ $loop->index }}]" value="{{ $plus }}">
        
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
                  @endforeach
                </ul>
        
                <button class="btn btn--success width-100% margin-top-xs js-repeater__add" type="button">+ Плюс</button>
              </div>
              </div>
              <div class="col-6@md">
                <div class="js-repeater" data-repeater-input-name="minus[n]">
                <ul class="grid gap-xs js-repeater__list">
                  @foreach ($bracelet->minus as $minus)
                  <li class="js-repeater__item">
                    <div class="grid gap-xs">
                      <input class="form-control col" type="text" name="minus[{{ $loop->index }}]" id="minus[{{ $loop->index }}]" value="{{ $minus }}">
        
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
                  @endforeach
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
                @foreach ($bracelet->buyers_like as $buyers_like)
                <li class="js-repeater__item">
                  <div class="grid gap-xs">
                    <input class="form-control col" type="text" name="buyers_like[{{ $loop->index }}]" id="buyers_like[{{ $loop->index }}]" value="{{ $buyers_like }}">
        
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
                @endforeach
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
                <input class="form-control width-100%" type="number" name="year" id="year" min="2010" max="2022" step="1" value="{{ $bracelet->year }}">
              </div>
              <div class="col-4@md">
                <div class="autocomplete position-relative select-auto js-select-auto js-autocomplete" data-autocomplete-dropdown-visible-class="autocomplete--results-visible">
                          <label class="form-label margin-bottom-xxs" for="autocomplete-input-id">Выбрать страну:</label>
      
                          <!-- select -->
                          <select name="country" id="country" class="js-select-auto__select">
                            <option value="Китай" @if ($bracelet->country == 'Китай')selected @endif>Китай</option>
                            <option value="США" @if ($bracelet->country == 'США')selected @endif>США</option>
                            <option value="Россия" @if ($bracelet->country == 'Россия')selected @endif>Россия</option>
                            <option value="Южная Корея" @if ($bracelet->country == 'Южная Корея')selected @endif>Южная Корея</option>
                            <option value="Япония" @if ($bracelet->country == 'Япония')selected @endif>Япония</option>
                            <option value="Канада" @if ($bracelet->country == 'Канада')selected @endif>Канада</option>
                            <option value="Финляндия" @if ($bracelet->country == 'Финляндия')selected @endif>Финляндия</option>
                          </select>
      
                          <!-- input -->
                          <div class="select-auto__input-wrapper">
                            <input class="form-control js-autocomplete__input js-select-auto__input" type="text" name="autocomplete-input-id" id="autocomplete-input-id" placeholder="Выбрать страну" autocomplete="off" value="{{ $bracelet->country }}">
      
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
                <input class="form-control width-100%" type="text" name="compatibility" id="compatibility" value="{{ $bracelet->compatibility }}">
              </div>
            </div>
            <div class="grid gap-xxs">
              <div class="col-4@md">
                <label class="form-label margin-bottom-xxs" for="assistant_app">Приложение ассистент</label>
                <input class="form-control width-100%" type="text" name="assistant_app" id="assistant_app" value="{{ $bracelet->assistant_app }}">
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
                      <option value="силикон" @if(in_array('силикон', $bracelet->material)) selected @endif>силикон</option>
                      <option value="металл" @if(in_array('металл', $bracelet->material)) selected @endif>металл</option>
                      <option value="резина" @if(in_array('резина', $bracelet->material)) selected @endif>резина</option>
                      <option value="кожа" @if(in_array('кожа', $bracelet->material)) selected @endif>кожа</option>
                      <option value="фторэластомер" @if(in_array('фторэластомер', $bracelet->material)) selected @endif>фторэластомер</option>
                      <option value="текстиль" @if(in_array('текстиль', $bracelet->material)) selected @endif>текстиль</option>
                      <option value="нейлон" @if(in_array('нейлон', $bracelet->material)) selected @endif>нейлон</option>
                      <option value="термополиуретан" @if(in_array('термополиуретан', $bracelet->material)) selected @endif>термополиуретан</option>
                    </select>
      
                    <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
                  </div>
              </div>
              <div class="col-4@md">
                <label class="form-label margin-bottom-xxs" for="colors">Возможные цвета</label>
                  <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
                    <select name="colors[]" id="colors[]" multiple>
                      <option value="белый" @if(in_array('белый', $bracelet->colors)) selected @endif>белый</option>
                      <option value="голубой" @if(in_array('голубой', $bracelet->colors)) selected @endif>голубой</option>
                      <option value="желтый" @if(in_array('желтый', $bracelet->colors)) selected @endif>желтый</option>
                      <option value="зеленый" @if(in_array('зеленый', $bracelet->colors)) selected @endif>зеленый</option>
                      <option value="коричневый" @if(in_array('коричневый', $bracelet->colors)) selected @endif>коричневый</option>
                      <option value="красный" @if(in_array('красный', $bracelet->colors)) selected @endif>красный</option>
                      <option value="оранжевый" @if(in_array('оранжевый', $bracelet->colors)) selected @endif>оранжевый</option>
                      <option value="розовый" @if(in_array('розовый', $bracelet->colors)) selected @endif>розовый</option>
                      <option value="серый" @if(in_array('серый', $bracelet->colors)) selected @endif>серый</option>
                      <option value="синий" @if(in_array('синий', $bracelet->colors)) selected @endif>синий</option>
                      <option value="фиолетовый" @if(in_array('фиолетовый', $bracelet->colors)) selected @endif>фиолетовый</option>
                      <option value="черный" @if(in_array('черный', $bracelet->colors)) selected @endif>черный</option>
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
                      <option value="IP68" @if(in_array('IP68', $bracelet->protect_stand)) selected @endif>IP68</option>
                      <option value="IP57" @if(in_array('IP57', $bracelet->protect_stand)) selected @endif>IP57</option>
                      <option value="WR50" @if(in_array('WR50', $bracelet->protect_stand)) selected @endif>WR50</option>
                      <option value="IP67" @if(in_array('IP67', $bracelet->protect_stand)) selected @endif>IP67</option>
                      <option value="WR20" @if(in_array('WR20', $bracelet->protect_stand)) selected @endif>WR20</option>
                      <option value="WR30" @if(in_array('WR30', $bracelet->protect_stand)) selected @endif>WR30</option>
                      <option value="IPX5" @if(in_array('IPX5', $bracelet->protect_stand)) selected @endif>IPX5</option>
                      <option value="IP65" @if(in_array('IP65', $bracelet->protect_stand)) selected @endif>IP65</option>
                      <option value="IP56" @if(in_array('IP56', $bracelet->protect_stand)) selected @endif>IP56</option>
                    </select>
      
                    <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
                  </div>
              </div>
              <div class="col-4@md">
                <label class="form-label margin-bottom-xxs" for="terms_of_use">Допустимые условия использования</label>
                  <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
                    <select name="terms_of_use[]" id="terms_of_use[]" multiple>
                      <option value="пыль" @if(in_array('пыль', $bracelet->terms_of_use)) selected @endif>пыль</option>
                      <option value="брызги" @if(in_array('брызги', $bracelet->terms_of_use)) selected @endif>брызги</option>
                      <option value="дождь" @if(in_array('дождь', $bracelet->terms_of_use)) selected @endif>дождь</option>
                      <option value="мытье рук" @if(in_array('мытье рук', $bracelet->terms_of_use)) selected @endif>мытье рук</option>
                      <option value="душ" @if(in_array('душ', $bracelet->terms_of_use)) selected @endif>душ</option>
                      <option value="плавание" @if(in_array('плавание', $bracelet->terms_of_use)) selected @endif>плавание</option>
                    </select>
                    <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
                  </div>
              </div>
            </div>
      
            <div class="margin-y-sm">
              <input class="checkbox" type="checkbox" id="replaceable_strap" name="replaceable_strap" @if ($bracelet->replaceable_strap == 1)
                 checked 
              @endif>
              <label for="replaceable_strap">Сменный браслет/ремешок</label>&nbsp;&nbsp;&nbsp;
              <input class="checkbox" type="checkbox" id="lenght_adj" name="lenght_adj" @if ($bracelet->lenght_adj == 1)
              checked 
              @endif>
              <label for="lenght_adj">Регулировка длины ремешка</label>&nbsp;&nbsp;&nbsp;
            </div>
      
            <div class="grid gap-xxs">
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="dimensions">Размеры</label>
                <input class="form-control width-100%" type="text" name="dimensions" value="{{ $bracelet->dimensions }}">
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="weight">Вес</label>
                <input class="form-control width-100%" type="number" name="weight" min="1" max="300" step="0.1" value="{{ $bracelet->weight }}">
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
                      <option value="AMOLED" @if ($bracelet->disp_tech == 'AMOLED')selected @endif>AMOLED</option>
                      <option value="IPS" @if ($bracelet->disp_tech == 'IPS')selected @endif>IPS</option>
                      <option value="TFT" @if ($bracelet->disp_tech == 'TFT')selected @endif>TFT</option>
                      <option value="POLED" @if ($bracelet->disp_tech == 'POLED')selected @endif>POLED</option>
                      <option value="OLED" @if ($bracelet->disp_tech == 'OLED')selected @endif>OLED</option>
                      <option value="LCD" @if ($bracelet->disp_tech == 'LCD')selected @endif>LCD</option>
                  </select>
                  <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                </div>
              </div>

              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="disp_resolution">Разрешение дисплея</label>
                <input class="form-control width-100%" type="text" name="disp_resolution" value="{{ $bracelet->disp_resolution }}">
              </div>

              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="disp_ppi">Плотность пикселей (PPI)</label>
                <input class="form-control width-100%" type="number" name="disp_ppi" value="{{ $bracelet->disp_ppi }}" min="100" max="1000" step="1" value="">
              </div>
            </div>
      
            <div class="grid gap-xxs margin-y-sm">
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="disp_brightness">Яркость (нит)</label>
                <input class="form-control width-100%" type="number" name="disp_brightness" value="{{ $bracelet->disp_brightness }}" min="100" max="1000" step="1" value="">
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="disp_col_depth">Глубина цвета (бит)</label>
                <input class="form-control width-100%" type="number" name="disp_col_depth" value="{{ $bracelet->disp_col_depth }}" min="16" max="256" step="1" value="">
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="disp_diag">Диагональ (дюймы)</label>
                <input class="form-control width-100%" type="number" name="disp_diag" value="{{ $bracelet->disp_diag }}" min="0.1" max="3" step="0.1" value="">
              </div>
              <div class="col-3@md"></div>
            </div>
      
            <div class="margin-y-sm">
              <input class="checkbox" type="checkbox" id="disp_sens" name="disp_sens" @if ($bracelet->disp_sens == 1) checked @endif>
              <label for="disp_sens">Сенсорный</label>&nbsp;&nbsp;&nbsp;
              <input class="checkbox" type="checkbox" id="disp_color" name="disp_color" @if ($bracelet->disp_color == 1) checked @endif>
              <label for="disp_color">Цветной</label>&nbsp;&nbsp;&nbsp;
              <input class="checkbox" type="checkbox" id="disp_aod" name="disp_aod" @if ($bracelet->disp_aod == 1) checked @endif>
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
                    <option value="акселерометр" @if(in_array('акселерометр', $bracelet->sensors)) selected @endif>акселерометр</option>
                    <option value="GPS" @if(in_array('GPS', $bracelet->sensors)) selected @endif>GPS</option>
                    <option value="пульсометр" @if(in_array('пульсометр', $bracelet->sensors)) selected @endif>пульсометр</option>
                    <option value="гироскоп" @if(in_array('гироскоп', $bracelet->sensors)) selected @endif>гироскоп</option>
                    <option value="датчик освещенности" @if(in_array('датчик освещенности', $bracelet->sensors)) selected @endif>датчик освещенности</option>
                    <option value="термометр" @if(in_array('термометр', $bracelet->sensors)) selected @endif>термометр</option>
                    <option value="высотомер" @if(in_array('высотомер', $bracelet->sensors)) selected @endif>высотомер</option>
                  </select>
                  <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
                </div>
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxs" for="other_interfaces">Другие интерфейсы</label>
                <div class="multi-select  js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
                  <select name="other_interfaces[]" id="other_interfaces[]" multiple>
                    <option value="Wi-Fi" @if(in_array('Wi-Fi', $bracelet->other_interfaces)) selected @endif>Wi-Fi</option>
                    <option value="USB" @if(in_array('USB', $bracelet->other_interfaces)) selected @endif>USB</option>
                    <option value="BLE" @if(in_array('BLE', $bracelet->other_interfaces)) selected @endif>BLE</option>
                    <option value="ANT+" @if(in_array('ANT+', $bracelet->other_interfaces)) selected @endif>ANT+</option>
                    <option value="BR" @if(in_array('BR', $bracelet->other_interfaces)) selected @endif>BR</option>
                    <option value="EDR" @if(in_array('EDR', $bracelet->other_interfaces)) selected @endif>EDR</option>
                  </select>
                  <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
                </div>
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="nfc">NFC</label>
                <input class="form-control width-100%" type="text" name="nfc" value="{{ $bracelet->nfc }}">
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="blue_ver">Версия Bluetooth</label>
                <input class="form-control width-100%" type="number" name="blue_ver" value="{{ $bracelet->blue_ver }}" min="2" max="8" step="0.1" value="">
              </div>
            </div>
      
            <div class="margin-y-sm">
              <input class="checkbox" type="checkbox" id="gps" name="gps" @if ($bracelet->gps == 1) checked @endif>
              <label for="gps">Встроенный GPS</label>&nbsp;&nbsp;&nbsp;
              <input class="checkbox" type="checkbox" id="vibration" name="vibration" @if ($bracelet->vibration == 1) checked @endif>
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
                <input class="form-control width-100%" type="text" name="phone_calls" value="{{ $bracelet->phone_calls }}">
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="notification">Уведомления</label>
                <input class="form-control width-100%" type="text" name="notification" value="{{ $bracelet->notification }}">
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="send_messages">Отправка сообщений с браслета</label>
                <input class="form-control width-100%" type="text" name="send_messages" value="{{ $bracelet->send_messages }}">
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
                    <option value="пульса" @if(in_array('пульса', $bracelet->monitoring)) selected @endif>пульса</option>
                    <option value="сна" @if(in_array('сна', $bracelet->monitoring)) selected @endif>сна</option>
                    <option value="калорий" @if(in_array('калорий', $bracelet->monitoring)) selected @endif>калорий</option>
                    <option value="физической активности" @if(in_array('физической активности', $bracelet->monitoring)) selected @endif>физической активности</option>
                    <option value="стресса" @if(in_array('стресса', $bracelet->monitoring)) selected @endif>стресса</option>
                  </select>
                  <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
                </div>
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxs" for="training_modes">Тренировочные режимы</label>
                <div class="multi-select js-multi-select" data-trigger-class="btn btn--success justify-between" data-no-select-text="Выбрано" data-multi-select-text="{n} выбрано" data-inset-label="on">
                  <select name="training_modes[]" id="training_modes[]" multiple>
                    <option value="ходьба на улице" @if(in_array('ходьба на улице', $bracelet->training_modes)) selected @endif>ходьба на улице</option>
                    <option value="ходьба" @if(in_array('ходьба', $bracelet->training_modes)) selected @endif>ходьба</option>
                    <option value="велотренажер" @if(in_array('велотренажер', $bracelet->training_modes)) selected @endif>велотренажер</option>
                    <option value="бег на улице" @if(in_array('бег на улице', $bracelet->training_modes)) selected @endif>бег на улице</option>
                    <option value="бег" @if(in_array('бег', $bracelet->training_modes)) selected @endif>бег</option>
                    <option value="беговая дорожка" @if(in_array('беговая дорожка', $bracelet->training_modes)) selected @endif>беговая дорожка</option>
                    <option value="ходьба на дорожке" @if(in_array('ходьба на дорожке', $bracelet->training_modes)) selected @endif>ходьба на дорожке</option>
                    <option value="свободная тренировка" @if(in_array('свободная тренировка', $bracelet->training_modes)) selected @endif>свободная тренировка</option>
                    <option value="скакалка" @if(in_array('скакалка', $bracelet->training_modes)) selected @endif>скакалка</option>
                    <option value="велосипед" @if(in_array('велосипед', $bracelet->training_modes)) selected @endif>велосипед</option>
                    <option value="подъем на гору" @if(in_array('подъем на гору', $bracelet->training_modes)) selected @endif>подъем на гору</option>
                    <option value="плавание" @if(in_array('плавание', $bracelet->training_modes)) selected @endif>плавание</option>
                    <option value="пресс" @if(in_array('пресс', $bracelet->training_modes)) selected @endif>пресс</option>
                    <option value="альпинизм" @if(in_array('альпинизм', $bracelet->training_modes)) selected @endif>альпинизм</option>
                    <option value="скалолазание" @if(in_array('скалолазание', $bracelet->training_modes)) selected @endif>скалолазание</option>
                    <option value="баскетбол" @if(in_array('баскетбол', $bracelet->training_modes)) selected @endif>баскетбол</option>
                    <option value="футбол" @if(in_array('футбол', $bracelet->training_modes)) selected @endif>футбол</option>
                    <option value="поход" @if(in_array('поход', $bracelet->training_modes)) selected @endif>поход</option>
                    <option value="горный спорт" @if(in_array('горный спорт', $bracelet->training_modes)) selected @endif>горный спорт</option>
                    <option value="настольный теннис" @if(in_array('настольный теннис', $bracelet->training_modes)) selected @endif>настольный теннис</option>
                    <option value="эллиптический тренажер" @if(in_array('эллиптический тренажер', $bracelet->training_modes)) selected @endif>эллиптический тренажер</option>
                    <option value="игра с мячом" @if(in_array('игра с мячом', $bracelet->training_modes)) selected @endif>игра с мячом</option>
                    <option value="90 альтернативных активностей" @if(in_array('90 альтернативных активностей', $bracelet->training_modes)) selected @endif>90 альтернативных активностей</option>
                    <option value="плавание в бассейне" @if(in_array('плавание в бассейне', $bracelet->training_modes)) selected @endif>плавание в бассейне</option>
                    <option value="жиросжигательный бег" @if(in_array('жиросжигательный бег', $bracelet->training_modes)) selected @endif>жиросжигательный бег</option>
                    <option value="гребной тренажер" @if(in_array('гребной тренажер', $bracelet->training_modes)) selected @endif>гребной тренажер</option>
                    <option value="плавание в открытом водоеме" @if(in_array('плавание в открытом водоеме', $bracelet->training_modes)) selected @endif>плавание в открытом водоеме</option>
                    <option value="степпер" @if(in_array('степпер', $bracelet->training_modes)) selected @endif>степпер</option>
                    <option value="бадминтон" @if(in_array('бадминтон', $bracelet->training_modes)) selected @endif>бадминтон</option>
                    <option value="прыжки на скакалке" @if(in_array('прыжки на скакалке', $bracelet->training_modes)) selected @endif>прыжки на скакалке</option>
                    <option value="йога" @if(in_array('йога', $bracelet->training_modes)) selected @endif>йога</option>
                    <option value="скручивания" @if(in_array('скручивания', $bracelet->training_modes)) selected @endif>скручивания</option>
                    <option value="выпады" @if(in_array('выпады', $bracelet->training_modes)) selected @endif>выпады</option>
                    <option value="приседания" @if(in_array('приседания', $bracelet->training_modes)) selected @endif>приседания</option>
                    <option value="прыжки звезда" @if(in_array('прыжки звезда', $bracelet->training_modes)) selected @endif>прыжки звезда</option>
                    <option value="пилатес" @if(in_array('пилатес', $bracelet->training_modes)) selected @endif>пилатес</option>
                  </select>
                  <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12"><path d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z"/></svg>
                </div>
              </div>
              <div class="col-3@md">
                <label class="form-label margin-bottom-xxxs" for="additional_info">Дополнительная информация</label>
                <textarea class="form-control width-100%" name="additional_info" id="additional_info">{{ $bracelet->additional_info }}</textarea>
              </div>
              <div class="col-3@md">
      
              </div>
            </div>
      
            <div class="grid gap-xxs margin-y-sm">
              <div class="col-6@md">
                <input class="checkbox" type="checkbox" id="heart_rate" name="heart_rate" @if ($bracelet->heart_rate == 1) checked @endif>
                <label for="heart_rate">Постоянное измерение пульса</label><br>
                <input class="checkbox" type="checkbox" id="bood_oxy" name="bood_oxy" @if ($bracelet->bood_oxy == 1) checked @endif>
                <label for="bood_oxy">Измерение кислорода в крови</label><br>
                <input class="checkbox" type="checkbox" id="blood_pressure" name="blood_pressure" @if ($bracelet->blood_pressure == 1) checked @endif>
                <label for="blood_pressure">Измерение артериального давления</label><br>
                <input class="checkbox" type="checkbox" id="stress" name="stress" @if ($bracelet->stress == 1) checked @endif>
                <label for="stress">Измерение стресса</label><br>
                <input class="checkbox" type="checkbox" id="workout_recognition" name="workout_recognition" @if ($bracelet->workout_recognition == 1) checked @endif>
                <label for="workout_recognition">Автоматическое распознавание тренировки</label><br>
                <input class="checkbox" type="checkbox" id="inactivity_reminder" name="inactivity_reminder" @if ($bracelet->inactivity_reminder == 1) checked @endif>
                <label for="inactivity_reminder">Напоминание об отсутствии активности</label><br>
                <input class="checkbox" type="checkbox" id="search_smartphone" name="search_smartphone" @if ($bracelet->search_smartphone == 1) checked @endif>
                <label for="search_smartphone">Поиск смартфона/браслета</label>
              </div>
              <div class="col-6@md">
                <input class="checkbox" type="checkbox" id="smart_alarm" name="smart_alarm" @if ($bracelet->smart_alarm == 1) checked @endif>
                <label for="smart_alarm">Умный будильник</label><br>
                <input class="checkbox" type="checkbox" id="camera_control" name="camera_control" @if ($bracelet->camera_control == 1) checked @endif>
                <label for="camera_control">Управление камерой смартфона</label><br>
                <input class="checkbox" type="checkbox" id="player_control" name="player_control" @if ($bracelet->player_control == 1) checked @endif>
                <label for="player_control">Управление плеером смартфона</label><br>
                <input class="checkbox" type="checkbox" id="timer" name="timer" @if ($bracelet->timer == 1) checked @endif>
                <label for="timer">Таймер</label><br>
                <input class="checkbox" type="checkbox" id="stopwatch" name="stopwatch" @if ($bracelet->stopwatch == 1) checked @endif>
                <label for="stopwatch">Секундомер</label><br>
                <input class="checkbox" type="checkbox" id="women_calendar" name="women_calendar" @if ($bracelet->women_calendar == 1) checked @endif>
                <label for="women_calendar">Женский календарь</label><br>
                <input class="checkbox" type="checkbox" id="weather_forecast" name="weather_forecast" @if ($bracelet->weather_forecast == 1) checked @endif>
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
                      <option value="Li-Ion" @if ($bracelet->type_battery == 'Li-Ion') selected @endif>Li-Ion</option>
                      <option value="Li-Pol" @if ($bracelet->type_battery == 'Li-Pol') selected @endif>Li-Pol</option>
                  </select>
                  <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                </div>
              </div>
              <div class="col-4@md">
                <label class="form-label margin-bottom-xxxs" for="capacity_battery">Емкость (мАч)</label>
                <input class="form-control width-100%" type="number" name="capacity_battery" value="{{ $bracelet->capacity_battery }}" min="10" max="2000" step="1" value="">
              </div>
              <div class="col-4@md">
                <label class="form-label margin-bottom-xxxs" for="standby_time">Время работы в режиме ожидания (часов)</label>
                <input class="form-control width-100%" type="number" name="standby_time" value="{{ $bracelet->standby_time }}" min="3" max="2000" step="1" value="">
              </div>
            </div>
            
            <div class="grid gap-xxs margin-y-sm">
              <div class="col-4@md">
                <label class="form-label margin-bottom-xxxs" for="real_time">Реальное время работы (дней)</label>
                <input class="form-control width-100%" type="number" name="real_time" value="{{ $bracelet->real_time }}" min="1" max="1000" step="1" value="">
              </div>
              <div class="col-4@md">
                <label class="form-label margin-bottom-xxxs" for="full_charge_time">Время полной зарядки</label>
                <input class="form-control width-100%" type="number" name="full_charge_time" value="{{ $bracelet->full_charge_time }}" min="10" max="2000" step="1" value="">
              </div>
              <div class="col-4@md">
                <label class="form-label margin-bottom-xxxs" for="charger">Зарядное устройство</label>
                <input class="form-control width-100%" type="text" name="charger" value="{{ $bracelet->charger }}">
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
              
            </div>
          </div>
        </div>
      </section>

      <section id="tab1Panel3" class="padding-top-md js-tabs__panel">
        <p class="color-contrast-medium margin-bottom-sm">Все картинки статьи</p>

  <table class="tbl__table border-bottom border-2" aria-label="Table Example">
    <thead class="tbl__header border-bottom border-2">
      <tr class="tbl__row">
        <th class="tbl__cell text-left" scope="col"><span class="text-xs text-uppercase letter-spacing-lg font-semibold">#</span></th>
        <th class="tbl__cell text-left" scope="col"><span class="text-xs text-uppercase letter-spacing-lg font-semibold">Файл</span></th>
        <th class="tbl__cell text-left" scope="col"><span class="text-xs text-uppercase letter-spacing-lg font-semibold">Alt</span></th>
        <th class="tbl__cell text-left" scope="col"><span class="text-xs text-uppercase letter-spacing-lg font-semibold">Код для вставки</span></th>
        <th class="tbl__cell text-left" scope="col"><span class="text-xs text-uppercase letter-spacing-lg font-semibold">Удалить</span></th>
      </tr>
    </thead>
    <tbody class="tbl__body">
      @foreach ($media as $image)
      <tr class="tbl__row">
        <td>{{ $image->id }}</td>
        <td class="tbl__cell" role="cell">
          <img width="200px" src="{{ $image->getFullUrl('320') }}" alt=""><br>
          <strong>{{ $image->human_readable_size }}</strong>
         </td>
        <td class="tbl__cell  text-left" role="cell">
          <form method="POST" action="{{ route('bracelets.updimg') }}">
            @csrf
          <div class="margin-bottom-md">
            <input type="text" hidden value="{{ $image->id }}" name="imgid">
            <div class="input-group">
              <input class="form-control flex-grow" type="text" name="nameimg" id="nameimg" value="{{ $image->name }}">
              <button class="btn btn--success" type="submit">
                <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                  <g>
                    <path d="M8,3c1.179,0,2.311,0.423,3.205,1.17L8.883,6.492l6.211,0.539L14.555,0.82l-1.93,1.93 C11.353,1.632,9.71,1,8,1C4.567,1,1.664,3.454,1.097,6.834l1.973,0.331C3.474,4.752,5.548,3,8,3z"></path>
                    <path d="M8,13c-1.179,0-2.311-0.423-3.205-1.17l2.322-2.322L0.906,8.969l0.539,6.211l1.93-1.93 C4.647,14.368,6.29,15,8,15c3.433,0,6.336-2.454,6.903-5.834l-1.973-0.331C12.526,11.248,10.452,13,8,13z"></path>
                  </g>
                </svg>
              </button>
            </div>
          </div>
        </form>
        </td>
        <td class="tbl__cell" role="cell">
          <pre class="code-snippet margin-y-sm">
            <code>&lt;img src="{{ $image->getFullUrl() }}"<br> srcset="{{ $image->getFullUrl('320') }} 320w,<br> {{ $image->getFullUrl('640') }} 640w"<br> alt="{{ $image->name }}"&gt;</code>
          </pre>
        </td>
         <td class="tbl__cell" role="cell">
          <form method="POST" action="{{ route('bracelets.delimg') }}">
            @csrf
            <input type="text" hidden value="{{ $image->id }}" name="imgid">
            <button type="submit" class="btn btn--accent text-sm">&times;</button>
          </form>
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>
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