@extends('admin.layouts.base')

@section('content')

    <style>
        .CodeMirror {
            height: 1000px;
        }
    </style>


    <div class="container">

        <div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
            {{ Breadcrumbs::render('admin_post', $post) }}
        </div>

        <div class="tabs js-tabs">
            <ul class="flex flex-wrap gap-sm js-tabs__controls" aria-label="Tabs Interface">
                <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Статья</a></li>
                <li><a href="#tab1Panel2" class="tabs__control">Комментарии</a></li>
                <li><a href="#tab1Panel3" class="tabs__control">Ссылки</a></li>
            </ul>

            <div class="js-tabs__panels">
                <section id="tab1Panel1" class="is-visible js-tabs__panel padding-top-sm">

                    <form class="form-template-v3" method="POST"
                          action="{{ route('posts.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Сообщение об успешности сохранения --}}
                        @if(session('success'))

                            <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert"
                                 role="alert">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24"
                                             aria-hidden="true">
                                            <path
                                                d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
                                        </svg>

                                        <p class="text-sm"><strong>Успешно:</strong> {{ session('success') }}.</p>
                                    </div>

                                    <button
                                        class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
                                        <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                             stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            <title>Close alert</title>
                                            <line x1="3" y1="3" x2="17" y2="17"/>
                                            <line x1="17" y1="3" x2="3" y2="17"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                        {{-- Конец сообщения об успешности сохранения --}}

                        <div class="bg radius-md shadow-xs padding-md margin-bottom-md">


                            <div class="margin-bottom-xs">
                                <label class="form-label margin-y-xs" for="user_id">Автор</label>
                                <div class="select">
                                    <select
                                        class="select__input form-control @error('user_id') form-control--error @enderror"
                                        name="user_id">
                                        <option value="">Выбрать автора</option>
                                        @foreach ($users as $k => $v)
                                            <option value="{{ $k }}"
                                                    @if ($k == $post->user->id) selected @endif>{{ $v }}</option>
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
                                @error('user_id')
                                <div role="alert"
                                     class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                    <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                @enderror
                            </div>

                            <div class="grid gap-xxs margin-bottom-xs">
                                <div class="col-6@md">
                                    <label class="form-label margin-bottom-xxs" for="name">Название</label>
                                    <input class="form-control width-100% @error('name') form-control--error @enderror"
                                           type="text" name="name" id="name" value="{{ $post->name }}">
                                    @error('name')
                                    <div role="alert"
                                         class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                        <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                    @enderror
                                    <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название,
                                        menutitle</p>
                                </div>

                                <div class="col-6@md">
                                    <label class="form-label margin-bottom-xxs" for="slug">URI (SLUG)</label>
                                    <input class="form-control width-100%" type="text" name="slug" id="slug"
                                           value="{{ $post->slug }}">
                                </div>
                            </div>

                            <div class="margin-bottom-xs">
                                <label class="form-label margin-bottom-xxs" for="title">Title</label>
                                <input class="form-control width-100% @error('title') form-control--error @enderror"
                                       type="text" name="title" id="title" value="{{ $post->title }}">
                                @error('title')
                                <div role="alert"
                                     class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                    <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                @enderror
                            </div>

                            <div class="grid gap-xxs margin-bottom-xs">
                                <div class="col-6@md">
                                    <label class="form-label margin-bottom-xxs" for="subtitle">Subtitle (h1)</label>
                                    <input class="form-control width-100%" type="text" name="subtitle" id="subtitle"
                                           value="{{ $post->subtitle }}">
                                </div>
                                <div class="col-6@md">
                                    <div class="character-count js-character-count">
                                        <label class="form-label margin-bottom-xxs"
                                               for="textareaName">Description:</label>
                                        <textarea class="form-control width-100% js-character-count__input"
                                                  name="description" id="description"
                                                  maxlength="300">{{ $post->description }}</textarea>
                                        <div
                                            class="character-count__helper character-count__helper--dynamic text-sm margin-top-xxxs"
                                            aria-live="polite" aria-atomic="true">
                                            Осталось <span class="js-character-count__counter"></span> символов
                                        </div>
                                        <div
                                            class="character-count__helper character-count__helper--static text-sm margin-top-xxxs">
                                            Макс 300 символов
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                                    @include('admin.layouts.parts.htmlcomponents')

                                    <button class="btn btn--primary margin-y-sm" aria-controls="drawer-1">Галерея</button>


                            <x-admin.codemirror-editor :content="$post->content_raw" name="content" id="content">
                                <h4>Основной контент</h4>
                                <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
                                    полный экран, ESC для выхода.</p>
                            </x-admin.codemirror-editor>

                            <x-admin.codemirror-editor :content="$post->sources" name="sources" id="sources">
                                <h4>Источники</h4>
                                <p class="color-contrast-medium text-sm">Указать ссылки на сайты или научные статьи</p>

                            </x-admin.codemirror-editor>


                        </div>

                        <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                            <h4>Превью</h4>

                            <div class="grid gap-xs">

                                <div class="col-2@md">
                                    <div class="file-upload inline-block margin-y-sm">
                                        <label for="cover" class="file-upload__label btn btn--primary">
              <span class="flex items-center">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor"
                                                                            stroke-width="2">
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path>
                        <path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path>
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path></g>
                </svg>
                <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить первью</span>
              </span>
                                        </label>
                                        <input type="file" class="file-upload__input" name="cover" id="cover">
                                    </div>
                                </div>
                                <div class="col-3@md">
                                    <img src="{{ $post->getFirstMediaUrl('covers') }}" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                            {{-- Add images --}}
                            <section class="margin-bottom-md">
                                <div class="text-component margin-y-sm">
                                    <h4>Добавить изображения для статьи</h4>
                                    <p class="text-md color-contrast-medium">Выберите одно или несколько изображений в
                                        формате
                                        <mark>jpg</mark>
                                        . После публикации можно будет редактировать теги
                                        <mark>alt</mark>
                                        у каждой картинки.
                                    </p>
                                </div>

                                <div class="file-upload inline-block">
                                    <label for="files" class="file-upload__label btn btn--primary">
          <span class="flex items-center">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor"
                                                                        stroke-width="2"><path stroke-linecap="square"
                                                                                               stroke-linejoin="miter"
                                                                                               d="M2 16v6h20v-6"></path><path
                        stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path><path stroke-linecap="square"
                                                                                                stroke-linejoin="miter"
                                                                                                d="M18 8l-6-6-6 6"></path></g></svg>

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

                    <div class="margin-top-lg drawer js-drawer" id="drawer-1">
                        <div class="drawer__content bg-light inner-glow shadow-md" role="alertdialog"
                             aria-labelledby="drawer-title-1">
                            <div class="drawer__body padding-sm js-drawer__body">
                                @foreach ($media as $image)
                                    <div
                                        class="gap-xxs grid border border-contrast-low radius-md margin-bottom-sm padding-sm">
                                        <div class="col-4 text-center">
                                            <img class="block width-100%" src="{{ $image->getFullUrl('320') }}">
                                            <p class="color-contrast-medium">{{ $image->human_readable_size }}</p>
                                        </div>
                                        <div class="col-8 text-center">
                                            <form method="POST" action="{{ route('bracelets.updimg') }}">
                                                @csrf
                                                <input type="text" hidden value="{{ $image->id }}" name="imgid">
                                                <div class="input-group">
                                                    <div class="input-group__tag">alt</div>
                                                    <input class="form-control flex-grow width-100% text-xs" type="text"
                                                           name="nameimg" id="nameimg" value="{{ $image->name }}">

                                                    <button title="Обновить" class="btn btn--success" type="submit">
                                                        <svg class="icon menu-bar__icon" aria-hidden="true"
                                                             viewBox="0 0 16 16">
                                                            <g>
                                                                <path
                                                                    d="M8,3c1.179,0,2.311,0.423,3.205,1.17L8.883,6.492l6.211,0.539L14.555,0.82l-1.93,1.93 C11.353,1.632,9.71,1,8,1C4.567,1,1.664,3.454,1.097,6.834l1.973,0.331C3.474,4.752,5.548,3,8,3z"></path>
                                                                <path
                                                                    d="M8,13c-1.179,0-2.311-0.423-3.205-1.17l2.322-2.322L0.906,8.969l0.539,6.211l1.93-1.93 C4.647,14.368,6.29,15,8,15c3.433,0,6.336-2.454,6.903-5.834l-1.973-0.331C12.526,11.248,10.452,13,8,13z"></path>
                                                            </g>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </form>

                                            <pre><code class="language-html">&lt;img.{{ $loop->index }}&gt;</code></pre>
                                            <pre><code
                                                    class="language-html">&lt;box_img.{{ $loop->index }}&gt;</code></pre>
                                            <pre><code
                                                    class="language-html">&lt;box_img_half.{{ $loop->index }}&gt;</code></pre>

                                            <button type="submit" class="btn btn--accent text-sm margin-top-sm"
                                                    aria-controls="dialog-{{ $loop->index }}">Удалить картинку
                                            </button>

                                            <div id="dialog-{{ $loop->index }}" class="dialog js-dialog"
                                                 data-animation="on">
                                                <div class="dialog__content max-width-xxs" role="alertdialog"
                                                     aria-labelledby="dialog-title-{{ $loop->index }}"
                                                     aria-describedby="dialog-description-{{ $loop->index }}">
                                                    <div class="text-component">
                                                        <h4 id="dialog-title-{{ $loop->index }}">Вы уверены, что хотите
                                                            удалить картинку {{ $image->name }} c id={{ $image->id }}
                                                            ?</h4>
                                                        <p id="dialog-description-{{ $loop->index }}">После
                                                            подтверждения картинка будет удалена
                                                            <mark>безвозвратно</mark>
                                                            !!!.
                                                        </p>
                                                    </div>

                                                    <footer class="margin-top-md">
                                                        <div class="flex justify-end gap-xs flex-wrap">
                                                            <button class="btn btn--subtle js-dialog__close">Отмена
                                                            </button>
                                                            <form method="POST" action="{{ route('posts.delimg') }}">
                                                                @csrf
                                                                <input type="text" name="imgdelid" hidden
                                                                       value="{{ $image->id }}">
                                                                <button type="submit" class="btn btn--accent">Удалить
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </footer>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                @endforeach
                            </div>

                            <button
                                class="reset drawer__close-btn position-fixed top-0 right-0 z-index-fixed-element margin-xs js-drawer__close js-tab-focus">
                                <svg class="icon icon--xs" viewBox="0 0 16 16"><title>Close drawer panel</title>
                                    <g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                       stroke-linejoin="round" stroke-miterlimit="10">
                                        <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                                        <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                                    </g>
                                </svg>
                            </button>
                        </div>
                    </div>

                </section>

                <section id="tab1Panel2" class="js-tabs__panel padding-top-sm">

                    {{-- Таблица комментариев для текущей страницы. В функции foreach заменить модель для вызова комментов --}}

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
                                @forelse ($post->comments as $comment)
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
                                                <a class="btn btn--primary btn--sm"
                                                   href="{{ route('comments.edit', ['comment' => $comment->id]) }}">
                                                    Изменить
                                                </a>

                                                <form method="POST"
                                                      action="{{ route('comments.destroy', ['comment' => $comment->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn--accent btn--sm">Удалить
                                                    </button>
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


                <section id="tab1Panel3" class="js-tabs__panel padding-top-sm">
                    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                        @livewire('admin.create-links')
                    </div>
                </section>

            </div>

        </div>


        @endsection

        @push('js')
            <script src="{{ asset("js/admin/prism.min.js") }}"></script>
    @endpush
