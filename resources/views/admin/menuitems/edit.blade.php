@extends('admin.layouts.base')

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
    {{-- {{ Breadcrumbs::render('admin_brand', $menuitem) }} --}}
  </div>

{{-- Сообщение об успешности сохранения --}}
@if(session('success'))

<div class="alert alert--success alert--is-visible padding-sm radius-md js-alert margin-y-sm" role="alert">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
      </svg>

      <p class="text-sm"><strong>Успешно:</strong> {{ session('success') }}.</p>
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
@endif
{{-- Конец сообщения об успешности сохранения --}}

<form class="form-template-v3" method="POST" action="{{ route('menuitems.update', ['menuitem' => $menuitem->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="name">Название пункта меню</label>
          </div>

          <div class="col-8@md">
            <input class="form-control width-100% @error('name') form-control--error @enderror" type="text" name="name" id="name" value="{{ $menuitem->name }}">
              @error('name')
                <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="link">Ссылка</label>
          </div>

          <div class="col-8@md">
            <input class="form-control width-100% @error('link') form-control--error @enderror" type="text"  name="link" id="link" value="{{ $menuitem->link }}">
              @error('link')
              <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="title">Позиция</label>
          </div>

          <div class="col-8@md">
            <input class="form-control width-100%" type="number" name="position" id="position" value="{{ $menuitem->position }}">
          </div>
        </div>
      </div>

      <label class="form-label margin-bottom-xxs text-bold" for="group_menu_id">Группа</label>
            <div class="select">
                <select
                    class="select__input form-control @error('group_menu_id') form-control--error @enderror"
                    name="group_menu_id">
                    <option value="">Выбрать группу</option>
                    @foreach ($groupmenus as $k => $v)
                        <option value="{{ $k }}" @if($k == $menuitem->group_menu_id) selected @endif>{{ $v }}</option>
                    @endforeach
                </select>

                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g stroke-width="1" stroke="currentColor">
                        <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-miterlimit="10"
                                  points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                    </g>
                </svg>
            </div>
            @error('group_menu_id')
            <div role="alert"
                 class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                <p><strong>ошибка:</strong> {{ $message }}</p></div>
            @enderror


            <div class="margin-bottom-xs">
              <div class="character-count js-character-count">
                  <label class="form-label margin-bottom-xxs"
                         for="about">Описание (для некоторых пунктов):</label>
                  <textarea class="form-control width-100% js-character-count__input"
                            name="about" id="about" rows="5"
                            maxlength="500">{{ $menuitem->about }}</textarea>
                  <div
                      class="character-count__helper character-count__helper--dynamic text-sm margin-top-xxxs"
                      aria-live="polite" aria-atomic="true">
                      Осталось <span class="js-character-count__counter"></span> символов
                  </div>
                  <div
                      class="character-count__helper character-count__helper--static text-sm margin-top-xxxs">
                      Макс 500 символов
                  </div>
              </div>
          </div>

    </fieldset>
    </div>

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
        <h4>Изображение</h4>
        <div class="file-upload margin-y-sm">
            <label for="image" class="file-upload__label btn btn--primary">
                <span class="flex items-center">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <g fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path>
                            <path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path>
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path>
                        </g>
                    </svg>
                    <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить</span>
                </span>
            </label>
            <input type="file" class="file-upload__input" name="image" id="image">
        </div>
      @if ($menuitem->getFirstMediaUrl('menu', 'thumb'))
        <div class="width-50%">
          <img src="{{ $menuitem->getFirstMediaUrl('menu', 'thumb') }}" alt="">

        </div>
        @else

      @endif
    </div>

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
      @livewire('admin.create-links')
    </div>

    <div class="text-right">
      <button type="submit" class="btn btn--primary">Сохранить</button>
    </div>
  </form>
@endsection

@section('scripts')
@endsection
