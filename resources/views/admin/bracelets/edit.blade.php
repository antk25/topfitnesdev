@extends('admin.layouts.base')

@section('content')

<div class="container max-width-md">
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
    
        <div class="text-right">
          <button type="submit" class="btn btn--primary">Отправить</button>
        </div>
      </form>
</div>
@endsection

@section('scripts')
@parent
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
    </script>
@endsection