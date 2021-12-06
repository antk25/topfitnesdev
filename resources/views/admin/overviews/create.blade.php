@extends('admin.layouts.base')

@section('content')

<div class="margin-bottom-md">
  <h1 class="text-lg">Создать обзор браслета</h1>
</div>

<form class="form-template-v3" method="POST" action="{{ route('overviews.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

      <div class="grid gap-xxs">

      <div class="col-6@md margin-bottom-xs">
        <label class="form-label margin-y-xs" for="user_id">Автор</label>
        <div class="select">
          <select class="select__input form-control" name="user_id">
            @foreach ($users as $k => $v)
              <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
          </select>

          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
      </div>

      <div class="col-6@md margin-bottom-xs">
        <label class="form-label margin-y-xs" for="bracelet_id">Браслет</label>
        <div class="select">
          <select class="select__input form-control" name="bracelet_id">
            <option value="">Выбрать браслет для обзора</option>
            @foreach ($bracelets as $k => $v)
              <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
          </select>

          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
      </div>
    </div>
    </div>

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="name">Название</label>
          <input class="form-control width-100%" type="text" name="name" id="name" value="{{ old('name') }}">
          <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название, menutitle</p>
        </div>

        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="slug">URI (SLUG)</label>
        <input class="form-control width-100%" type="text" name="slug" id="slug" value="{{ old('slug') }}">
        </div>
      </div>

      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="title">Title</label>
        <input class="form-control width-100%" type="text" name="title" id="title" value="{{ old('title') }}">
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="subtitle">Subtitle (h1)</label>
          <input class="form-control width-100%" type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}">
        </div>
        <div class="col-6@md">
          <div class="character-count js-character-count">
            <label class="form-label margin-bottom-xxs" for="textareaName">Description:</label>
            <textarea class="form-control width-100% js-character-count__input" name="description" id="description" maxlength="300">{{ old('description') }}</textarea>
            <div class="character-count__helper character-count__helper--dynamic text-sm margin-top-xxxs" aria-live="polite" aria-atomic="true">
              Осталось <span class="js-character-count__counter"></span> символов
            </div>
            <div class="character-count__helper character-count__helper--static text-sm margin-top-xxxs">Макс 300 символов</div>
          </div>
        </div>
      </div>
    </div>


    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

      @include('admin.layouts.parts.htmlcomponents')


      <section class="margin-y-sm">
        <div class="text-component padding-y-sm">
          <h4>Основной контент</h4>
          <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на полный экран, ESC для выхода.</p>
        </div>
      <div class="border radius-md padding-sm bg-gradient-3">
        <label class="form-label margin-bottom-xxs sr-only" for="text">Основной контент</label>
            <textarea rows="20" class="form-control width-100% text-sm text" spellcheck="false" name="content" id="content">{{ old('content') }}</textarea>
      </div>
    </section>

    </div>

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    {{-- Add images --}}
    <section class="margin-bottom-md">
      <div class="text-component margin-y-sm">
        <h4>Добавить изображения для обзора</h4>
        <p class="text-md color-contrast-medium">Выберите одно или несколько изображений в формате <mark>jpg</mark>. После публикации можно будет редактировать теги <mark>alt</mark> у каждой картинки.</p>
      </div>

      <div class="file-upload inline-block">
        <label for="files" class="file-upload__label btn btn--primary">
          <span class="flex items-center">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="2"><path  stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path><path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path><path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path></g></svg>

            <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить</span>
          </span>
        </label>

        <input type="file" class="file-upload__input" name="files[]" id="files" multiple>
      </div>
    </section>
{{-- End add images --}}
    </div>

            <div class="margin-y-md">
              <button type="submit" class="btn btn--success">Сохранить статью</button>
            </div>
  </form>
@endsection

@section('scripts')
@parent
<script src="{{ asset("js/admin/prism.min.js") }}"></script>
    <script src="{{ asset("js/admin/codemirror.min.js") }}"></script>
    <script src="{{ asset("js/admin/xml-fold.js") }}"></script>
    <script src="{{ asset("js/admin/closetag.js") }}"></script>
    <script src="{{ asset("js/admin/matchtags.js") }}"></script>
    <script src="{{ asset("js/admin/trailingspace.js") }}"></script>
    <script src="{{ asset("js/admin/xml.js") }}"></script>
    <script src="{{ asset("js/admin/fullscreen.js") }}"></script>
    <script>
      var myCodeMirror = CodeMirror.fromTextArea((content), {
        lineNumbers: true,
        tabSize: 2,
        mode: "text/html",
        autoCloseTags: true,
        lineWrapping: true,
        matchTags: {bothTags: true},
        extraKeys: {"Ctrl-J": "toMatchingTag"},
        showTrailingSpace: true,
        extraKeys: {
        "F11": function(cm) {
          cm.setOption("fullScreen", !cm.getOption("fullScreen"));
        },
        "Esc": function(cm) {
          if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
        }
      }
      });
    </script>
@endsection