@extends('admin.layouts.base')

@section('content')

<div class="margin-bottom-md">
  <h1 class="text-lg">Создать новый рейтинг браслетов</h1>
</div>

<div class="bg radius-md shadow-xs padding-md margin-bottom-md">

  <form action="{{ route('ratings.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid gap-xxs margin-bottom-xs">
    <div class="col-6@md">
      <label class="form-label margin-bottom-xxs" for="name">Название рейтинга</label>
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
  <section>
    <div class="text-component padding-y-sm">
      <h4>Основной контент (в начале статьи)</h4>
      <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на полный экран, ESC для выхода.</p>
    </div>
    <div class="border radius-md padding-sm bg-gradient-3">
      <label class="form-label margin-bottom-xxs sr-only" for="text">Основной контент</label>
      <textarea class="form-control width-100% text-sm text" spellcheck="false" name="text" id="text">{{ old('text') }}</textarea>
    </div>
  </section>
</div>


 <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
{{-- Add bracelets --}}
  <div class="text-component">
        <h4>Добавить браслеты которые входят в рейтинг</h4>
      </div>
      <div class="js-repeater" data-repeater-input-name="allbracelets[n]">
        <div class="js-repeater__list">
          <div class="grid grid-col-8 gap-x-sm margin-y-md border radius-md padding-sm js-repeater__item">
            <div class="col-2@md">
              <div class="select margin-bottom-xxs">
                <select class="select__input form-control" name="allbracelets[0][bracelets]" id="allbracelets[0][bracelets]"
                        class="form-control">
                    <option value="">-- Выбрать браслет --</option>
                    @foreach ($bracelets as $k => $v)
                              <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                </select>

                  <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                </div>
            </div>
            <div class="col-3@md">
              <input class="form-control width-100%" type="text" name="allbracelets[0][head_rating]" id="allbracelets[][head_rating]" placeholder="Заголовок H2 для рейтинга">
            </div>
            <div class="col-3@md">
              <label class="form-label margin-bottom-xxs" for="allbracelets[0][position_rating]">Позиция:</label>
                <input class="form-control" type="number" name="allbracelets[0][position_rating]" id="allbracelets[0][position_rating]" min="0" max="20" step="1" value="1">

            </div>

            <div class="col-8@md">
              <textarea class="form-control width-100%" name="allbracelets[0][text_rating]" id="allbracelets[][text_rating]" cols="33" rows="5" placeholder="Описание браслета для выбранного рейтинга"></textarea>


              <button class="btn width-100% margin-y-sm btn--subtle padding-x-xs col-content js-repeater__remove btn--accent" type="button">
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
        <button class="btn btn--primary width-100% margin-top-xs js-repeater__add" type="button">+ Добавить браслет</button>
      </div>
{{-- End add bracelets --}}
 </div>


<div class="bg radius-md shadow-xs padding-md margin-bottom-md">

{{-- Add images --}}
  <div class="text-component margin-y-sm">
    <h4>Добавить изображения браслета</h4>
    <p class="text-md color-contrast-medium">Выберите одно или несколько изображений в формате <mark>jpg</mark>. После публикации рейтинга можно будет редактировать теги <mark>alt</mark> у каждой картинки.</p>
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
{{-- End add images --}}
</div>

  <button class="btn btn--success" type="submit">Сохранить</button>

</form>

@endsection

@section('scripts')
@parent
<script src="{{ asset("js/admin/alpine.min.js") }}"></script>

<script src="{{ asset("js/admin/codemirror.min.js") }}"></script>
    <script src="{{ asset("js/admin/xml-fold.js") }}"></script>
    <script src="{{ asset("js/admin/closetag.js") }}"></script>
    <script src="{{ asset("js/admin/matchtags.js") }}"></script>
    <script src="{{ asset("js/admin/trailingspace.js") }}"></script>
    <script src="{{ asset("js/admin/xml.js") }}"></script>
    <script src="{{ asset("js/admin/fullscreen.js") }}"></script>
    <script>
      var myCodeMirror = CodeMirror.fromTextArea((text), {
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