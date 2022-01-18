@extends('admin.layouts.base')

@section('content')


<div class="container">

  <div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
    {{ Breadcrumbs::render('admin_overview', $overview) }}
  </div>

  <div class="tabs js-tabs">
    <ul class="flex flex-wrap gap-sm js-tabs__controls margin-bottom-sm" aria-label="Tabs Interface">
      <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Статья</a></li>
      <li><a href="#tab1Panel2" class="tabs__control">Комментарии</a></li>
      <li><a href="#tab1Panel3" class="tabs__control">Ссылки</a></li>
    </ul>

    <div class="js-tabs__panels">
      <section id="tab1Panel1" class="is-visible js-tabs__panel">

<form class="form-template-v3" method="POST" action="{{ route('overviews.update', ['overview' => $overview->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')


{{-- Сообщение об успешности сохранения --}}
@if(session('success'))

<div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
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

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
        <label class="form-label margin-y-xs" for="bracelet_id">Браслет</label>
        <div class="select">
            <select class="select__input form-control @error('bracelet_id') form-control--error @enderror" name="bracelet_id">
                <option value="">Выбрать браслет для обзора</option>
                @foreach ($bracelets as $k => $v)
                    <option value="{{ $k }}" @if ($overview->bracelet->id == $k) selected @endif>{{ $v }}</option>
                @endforeach
            </select>

            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
        @error('bracelet_id')
        <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>ошибка:</strong> {{ $message }}</p></div>
        @enderror
    </div>

    <x-admin.seo-block :model="$overview" :users="$users">

    </x-admin.seo-block>


    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

      @include('admin.layouts.parts.htmlcomponents')


      <section class="margin-y-sm">
        <div class="text-component padding-y-sm">
          <h4>Основной контент</h4>
          <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на полный экран, ESC для выхода.</p>
        </div>
      <div class="border radius-md padding-sm bg-gradient-3">
        <label class="form-label margin-bottom-xxs sr-only" for="text">Основной контент</label>
            <textarea rows="20" class="form-control width-100% text-sm text" spellcheck="false" name="content" id="content">{{ $overview->content }}</textarea>
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
        <button type="submit" class="btn btn--success">Сохранить</button>
      </div>
</form>

</section>

<section id="tab1Panel2" class="js-tabs__panel">

  {{-- Таблица комментариев для текущей страницы. В функции foreach заменить модель для вызова комментов --}}
      <div class="text-component margin-bottom-md text-center">
            <h2>Комментарии</h2>
      </div>

      <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

      <div class="tbl text-sm">

        <table class="tbl__table border-bottom" aria-label="Таблица комментариев">
            <thead class="tbl__header border-bottom">
                  <tr class="tbl__row">
                    <th class="tbl__cell text-left" scope="col">
                      <span class="font-semibold">ID</span>
                    </th>

                    <th class="tbl__cell text-left" scope="col">
                      <span class="font-semibold">Пользователь</span>
                    </th>

                    <th class="tbl__cell text-left" scope="col">
                      <span class="font-semibold">Ответ (id)</span>
                    </th>

                    <th class="tbl__cell text-left" scope="col">
                      <span class="font-semibold">Текст</span>
                    </th>

                    <th class="tbl__cell text-left" scope="col">
                      <span class="font-semibold">Дата</span>
                    </th>

                    <th class="tbl__cell text-left" scope="col">
                      <span class="font-semibold">Действия</span>
                    </th>
                  </tr>
                </thead>

            <tbody class="tbl__body">
            @forelse ($overview->comments as $comment)
            <tr class="tbl__row">
                <td class="tbl__cell" role="cell">
                    {{ $comment->id }}
                </td>

                <td class="tbl__cell" role="cell">
                    <div class="flex items-center">
                        <div class="line-height-xs">
                          @if ($comment->user_id)
                            {{ $comment->user->name }}<br>
                            <span class="text-sm color-contrast-medium">(id: {{ $comment->user->id }})</span>
                          @else
                            {{ $comment->username }}
                          @endif
                        </div>
                    </div>
                </td>

                <td class="tbl__cell" role="cell">
                  @if ($comment->parent_id)
                    {{ $comment->parent_id }}
                  @else
                    --
                  @endif
                </td>


                <td class="tbl__cell" width="200px" role="cell">
                  {{ Str::limit($comment->comment, 100) }}

                </td>


                <td class="tbl__cell" role="cell">
                    {{ $comment->created_at }}
                </td>

                <td class="tbl__cell text-right" role="cell">

                  <div class="flex flex-wrap gap-xs">
                      <a class="btn btn--primary btn--sm" href="{{ route('comments.edit', ['comment' => $comment->id]) }}">
                        Изменить
                      </a>

                      <form method="POST" action="{{ route('comments.destroy', ['comment' => $comment->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn--accent btn--sm">Удалить</button>
                      </form>

                  </div>

                </td>
            </tr>
            @empty
            <tr>
              <td class="tbl__cell text-center text-md" colspan="6">Нет комментариев</td>
            </tr>

        @endforelse


            </tbody>
        </table>
        </div>

      </div>

      {{-- Конец таблицы комментариев --}}

</section>

<section id="tab1Panel3" class="js-tabs__panel">
    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
        @livewire('admin.create-links')
    </div>
</section>

    </div>

  </div>

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
