@extends('admin.layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
@endpush

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
    {{ Breadcrumbs::render('admin_htmlcomponent', $htmlcomponent) }}
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

<form class="form-template-v3" method="POST" action="{{ route('htmlcomponents.update', ['htmlcomponent' => $htmlcomponent->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="name">Название</label>
          <input class="form-control width-100%" type="text" name="name" id="name" value="{{ $htmlcomponent->name }}">
          <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название, menutitle</p>
        </div>

        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="about">Описание</label>
          <textarea class="form-control width-100%" name="about" id="about">{{ $htmlcomponent->about }}</textarea>
          <p class="text-xs color-contrast-medium margin-top-xxxxs">Опционально</p>
        </div>
      </div>

      <x-admin.codemirror-editor :content="$htmlcomponent->code" name="code" id="code">
          <h4>Код компонента</h4>
          <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
              полный экран, ESC для выхода.</p>
      </x-admin.codemirror-editor>

    </fieldset>

    </div>

    <div class="text-right">
      <button type="submit" class="btn btn--primary">Сохранить</button>
    </div>
  </form>
@endsection
