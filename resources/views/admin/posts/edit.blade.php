@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Изменить статью "{{ $post->name }}"</h2>
      </div>
      <div class="margin-bottom-xs">
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
      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="name">Название</label>
          <input class="form-control width-100%" type="text" name="name" id="name" value="{{ $post->name }}">
          <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название, menutitle</p>
        </div>

        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="slug">URI (SLUG)</label>
        <input class="form-control width-100%" type="text" name="slug" id="slug" value="{{ $post->slug }}">
        <p class="text-xs color-contrast-medium margin-top-xxs">При редактировании статьи отключен</p>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="title">Title</label>
        <input class="form-control width-100%" type="text" name="title" id="title" value="{{ $post->title }}">
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="subtitle">Subtitle (h1)</label>
          <input class="form-control width-100%" type="text" name="subtitle" id="subtitle" value="{{ $post->subtitle }}">
        </div>
        <div class="col-6@md">
          <div class="character-count js-character-count">
            <label class="form-label margin-bottom-xxs" for="textareaName">Description:</label>
            <textarea class="form-control width-100% js-character-count__input" name="description" id="description" maxlength="300">{{ $post->description }}</textarea>
            <div class="character-count__helper character-count__helper--dynamic text-sm margin-top-xxxs" aria-live="polite" aria-atomic="true">
              Осталось <span class="js-character-count__counter"></span> символов
            </div>
            <div class="character-count__helper character-count__helper--static text-sm margin-top-xxxs">Макс 300 символов</div>
          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="content">Текст статьи</label>
        <div class="margin-y-sm">Textarea</div>
        <textarea class="form-control width-100% text-sm" spellcheck="false" name="content" id="content">{{ $post->content }}</textarea>
      </div>
    </fieldset>
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
    <div class="margin-y-md">
      <button type="submit" class="btn btn--success">Обновить статью</button>
    </div>
  </form>

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
          <form method="POST" action="{{ route('posts.updimg') }}">
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
          <form method="POST" action="{{ route('posts.delimg') }}">
            @csrf
            <input type="text" hidden value="{{ $image->id }}" name="imgid">
            <button type="submit" class="btn btn--accent text-sm">&times;</button>
          </form>
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection

@section('scripts')
@parent
<script src="{{ asset("js/admin/alpine.min.js") }}"></script>
<script src="{{ asset("js/admin/ace.js") }}"></script>
    <script
			  src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
			  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
			  crossorigin="anonymous"></script>

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


  function handler() {
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