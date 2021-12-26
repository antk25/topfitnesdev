@extends('admin.layouts.base')

@section('styles')
    @parent
    @livewireStyles
@endsection
@section('content')

<div class="container">

  <div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
    {{ Breadcrumbs::render('admin_rating', $rating) }}
  </div>

  <div class="tabs js-tabs">
    <ul class="flex flex-wrap gap-sm js-tabs__controls margin-bottom-sm" aria-label="Tabs Interface">
      <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Рейтинг</a></li>
      <li><a href="#tab1Panel2" class="tabs__control">Комментарии</a></li>
      <li><a href="#tab1Panel3" class="tabs__control">Картинки</a></li>
    </ul>

    <div class="js-tabs__panels">
      <section id="tab1Panel1" class="is-visible js-tabs__panel">

    <form class="form-template-v3" method="POST" action="{{ route('ratings.update', ['rating' => $rating->id]) }}" enctype="multipart/form-data">
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

{{--    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">--}}
{{--      <div class="margin-bottom-xs">--}}
{{--          <label class="form-label margin-y-xs" for="user_id">Автор</label>--}}
{{--        <div class="select">--}}
{{--          <select class="select__input form-control @error('user_id') form-control--error @enderror" name="user_id">--}}
{{--            <option value="">Выбрать автора</option>--}}
{{--            @foreach ($users as $k => $v)--}}
{{--              <option value="{{ $k }}" @if ($rating->user->id == $k) selected @endif>{{ $v }}</option>--}}
{{--            @endforeach--}}
{{--          </select>--}}

{{--          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--      </div>--}}

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

      <div class="margin-bottom-xs">
        <label class="form-label margin-y-xs" for="user_id">Автор</label>
        <div class="select">
          <select class="select__input form-control @error('user_id') form-control--error @enderror" name="user_id">
              <option value="">Выбрать автора</option>
            @foreach ($users as $k => $v)
              <option value="{{ $k }}" @if ($k == $rating->user->id) selected @endif>{{ $v }}</option>
            @endforeach
          </select>

          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
          @error('user_id')
          <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>ошибка:</strong> {{ $message }}</p></div>
          @enderror
      </div>

        <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="name">Название рейтинга</label>
          <input class="form-control width-100% @error('name') form-control--error @enderror" type="text" name="name" id="name" value="{{ $rating->name }}">
            @error('name')
            <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
            @enderror
          <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название, menutitle</p>
        </div>

        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="slug">URI (SLUG)</label>
          <div class="input-group">
            <input class="form-control flex-grow" type="text" name="slug" id="slug" value="{{ $rating->slug }}">
            <a href="/{{ $rating->slug }}" target="_blank" class="btn btn--primary">Открыть</a>
          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="title">Title</label>
        <input class="form-control width-100% @error('title') form-control--error @enderror" type="text" name="title" id="title" value="{{ $rating->title }}">
          @error('title')
          <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="subtitle">Subtitle (h1)</label>
          <input class="form-control width-100%" type="text" name="subtitle" id="subtitle" value="{{ $rating->subtitle }}">
        </div>
        <div class="col-6@md">
          <div class="character-count js-character-count">
            <label class="form-label margin-bottom-xxs" for="textareaName">Description:</label>
            <textarea class="form-control width-100% js-character-count__input" name="description" id="description" maxlength="300">{{ $rating->description }}</textarea>
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
          <textarea class="form-control width-100% text-sm text" spellcheck="false" name="text" id="text">{{ $rating->text }}</textarea>
        </div>
      </section>
    </div>


     <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    {{-- Add bracelets --}}
      <div class="text-component">
        <h4>Добавить браслеты для рейтинга</h4>
      </div>
      <div class="js-repeater" data-repeater-input-name="allbracelets[n]">
        <div class="js-repeater__list">
          {{-- Используем функцию forelse, чтобы при отсутствии связей вывести пустую форму --}}
          @forelse ($rating->bracelets as $item)
          <div class="grid grid-col-8 gap-sm margin-y-md border radius-md padding-sm js-repeater__item">
            <div class="col-2@md">
              <div class="select margin-bottom-xxs">
                <select class="select__input form-control" name="allbracelets[{{ $loop->index }}][bracelets]" id="allbracelets[0][bracelets]"
                        class="form-control">
                    <option value="">-- Выбрать браслет --</option>
                    @foreach ($bracelets as $k => $v)
                              <option value="{{ $k }}" @if ($item->id == $k)
                                selected
                                @endif >{{ $v }}</option>
                            @endforeach
                </select>

                  <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                </div>

            </div>
            <div class="col-3@md">
              <input class="form-control width-100%" type="text" name="allbracelets[{{ $loop->index }}][head_rating]" id="allbracelets[][head_rating]" value="{{ $item->pivot->head_rating }}" placeholder="Заголовок H2 для рейтинга">
            </div>

            <div class="col-3@md">
                <label class="form-label margin-bottom-xxs" for="allbracelets[{{ $loop->index }}][position_rating]">Позиция:</label>
                <input class="form-control" type="number" name="allbracelets[{{ $loop->index }}][position_rating]" id="allbracelets[0][position_rating]" min="0" max="20" step="1" value="{{ $item->pivot->position }}">
            </div>

            <div class="col-8@md">
            <textarea class="form-control width-100%" rows="10" name="allbracelets[{{ $loop->index }}][text_rating]" id="allbracelets[][text_rating]" placeholder="Описание браслета для рейтинга (только если нужно уникальное)">{!! $item->pivot->text_rating !!}</textarea>

            <button class="btn width-100% btn--subtle margin-y-sm col-content js-repeater__remove btn--accent" type="button">
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
          {{-- Пустая форма при отсутствии связей --}}
          @empty
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
          @endforelse
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

      <button class="btn btn--primary" type="submit">Сохранить</button>

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
            @forelse ($rating->comments as $comment)
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

    <section id="tab1Panel2" class="js-tabs__panel">

<div class="text-component margin-bottom-md text-center">
          <h2>Картинки</h2>
    </div>

  <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
  <div class="tbl">
    <table class="tbl__table text-unit-em text-sm border-bottom border-2" aria-label="Картинки">
      <thead class="tbl__header border-bottom border-2">
        <tr class="tbl__row">
          <th class="tbl__cell text-left" scope="col">
            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Картинка</span>
          </th>

          <th class="tbl__cell text-left" scope="col">
            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Код и Alt</span>
          </th>

          <th class="tbl__cell text-left" scope="col">
            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Удалить</span>
          </th>
        </tr>
      </thead>

      <tbody class="tbl__body">
        @foreach ($media as $image)
        <tr class="tbl__row">
          <td class="tbl__cell" role="cell">
            <div class="items-center">
              <figure class="width-lg height-lg overflow-hidden margin-right-xs">
                <img class="block width-100% height-100% object-cover" src="{{ $image->getFullUrl('thumb') }}">
              </figure>

              <div class="line-height-xs">
                <p class="color-contrast-medium">{{ $image->human_readable_size }}</p>
              </div>
            </div>
          </td>

          <td class="tbl__cell" role="cell">
            <pre><code class="language-html">
              &lt;img src="{{ $image->getFullUrl() }}"
              srcset="{{ $image->getFullUrl('320') }} 320w,
              {{ $image->getFullUrl('640') }} 640w"
              alt="{{ $image->name }}"&gt;
              </code>
            </pre>


            <form method="POST" action="{{ route('bracelets.updimg') }}">
              @csrf
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
          </form>
          </td>

          <td class="tbl__cell" role="cell">

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
  </div>
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
