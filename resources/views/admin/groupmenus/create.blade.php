@extends('admin.layouts.base')

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{-- {{ Breadcrumbs::render('admin_brand_create') }} --}}
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

<form class="form-template-v3" method="POST" action="{{ route('groupmenus.store') }}">
    @csrf
    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="name">Название группы</label>
          </div>

          <div class="col-8@md">
            <input class="form-control width-100% @error('name') form-control--error @enderror" type="text" name="name" id="name" value="{{ old('name') }}">
              @error('name')
                <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
          </div>
        </div>
      </div>


      <div class="margin-bottom-xs">
        <div class="character-count js-character-count">
            <label class="form-label margin-bottom-xxs"
                   for="about">Описание (для того, чтобы понять где):</label>
            <textarea class="form-control width-100% js-character-count__input"
                      name="about" id="about" rows="5"
                      maxlength="500">{{ old('about') }}</textarea>
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

      <label class="form-label margin-bottom-xxs text-bold" for="place">Место</label>
            <div class="select">
                <select
                    class="select__input form-control @error('place') form-control--error @enderror"
                    name="place">
                    <option value="">Выбрать место</option>
                        <option value="header">Header</option>
                        <option value="footer">Footer</option>
                </select>

                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g stroke-width="1" stroke="currentColor">
                        <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-miterlimit="10"
                                  points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                    </g>
                </svg>
            </div>
            @error('place')
            <div role="alert"
                 class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                <p><strong>ошибка:</strong> {{ $message }}</p></div>
            @enderror
    </fieldset>
    </div>

    <div class="text-right">
      <button type="submit" class="btn btn--primary">Сохранить</button>
    </div>
  </form>
@endsection

@section('scripts')
@endsection
