@extends('admin.layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
@endpush

@section('content')

<div class="container">
    <div class="flex justify-between bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
        <div>
            {{ Breadcrumbs::render('admin_manual', $manual) }}
        </div>
        <div>
            <a target="_blank" title="Откроется в новом окне" class="text-sm block font-bold text-decoration-none"
               href="{{ route('pub.manuals.show', ['manual' => $manual]) }}">Посмотреть 👉</a>
        </div>
    </div>
  <div class="tabs js-tabs">
    <ul class="flex flex-wrap gap-sm js-tabs__controls margin-bottom-sm" aria-label="Tabs Interface">
      <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Мануал</a></li>
      <li><a href="#tab1Panel2" class="tabs__control">Комментарии</a></li>
      <li><a href="#tab1Panel3" class="tabs__control">Ссылки</a></li>
    </ul>

    <div class="js-tabs__panels">
      <section id="tab1Panel1" class="is-visible js-tabs__panel">

<form class="form-template-v3" method="POST" action="{{ route('manuals.update', ['manual' => $manual->id]) }}" enctype="multipart/form-data">
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

    <x-admin.seo-block :model="$manual" :users="$users">

    </x-admin.seo-block>

      <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
      {{-- Add bracelets --}}
    <section class="margin-bottom-md">
      <div class="text-component">
        <h4>Добавить браслеты, которые упоминаются в мануале</h4>
      </div>

        <div class="alert alert--warning alert--is-visible padding-sm radius-md js-alert margin-top-sm" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12,0C5.383,0,0,5.383,0,12s5.383,12,12,12s12-5.383,12-12S18.617,0,12,0z M13.645,5L13,14h-2l-0.608-9 H13.645z M12,20c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C14,19.105,13.105,20,12,20z"></path>
                    </svg>

                    <p class="text-sm"><strong>Внимание:</strong> это необязательное поле. В мануале могут вообще не упоминаться браслеты.
                        Это поле нужно для перелинковки. В карточке браслета появится ссылка на этот мануал.
                    </p>
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

      <div class="js-repeater" data-repeater-input-name="allbracelets[n]">
        <div class="js-repeater__list">
          {{-- Используем функцию forelse, чтобы при отсутствии связей вывести пустую форму --}}
          @forelse ($manual->bracelets as $item)
          <div class="margin-y-md js-repeater__item">
              <div class="grid gap-xs">
                  <div class="col">

                  <div class="select margin-bottom-xxs">
                <select class="select__input form-control" name="allbracelets[{{ $loop->index }}]" id="allbracelets[0]"
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

                  <div class="col-content">
                      <button class="btn btn--subtle btn--accent padding-x-xs col-content js-repeater__remove" type="button">
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

          @empty

          <div class="margin-y-md js-repeater__item">
              <div class="grid gap-xs">
                  <div class="col">
                      <div class="select margin-bottom-xxs">
                          <select class="select__input form-control" name="allbracelets[0]" id="allbracelets[0]"
                                  class="form-control">
                              <option value="">-- Выбрать браслет --</option>
                              @foreach ($bracelets as $k => $v)
                                  <option value="{{ $k }}">{{ $v }}</option>
                              @endforeach
                          </select>

                          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                      </div>
                  </div>
                  <div class="col-content">
                      <button class="btn btn--subtle padding-x-xs col-content js-repeater__remove" type="button">
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

          @endforelse
        </div>
        <button class="btn btn--primary width-100% margin-top-xs js-repeater__add" type="button">+ Добавить браслет</button>
      </div>
    </section>
    {{-- End add bracelets --}}
      </div>

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

        @include('admin.layouts.parts.htmlcomponents')

        <button class="btn btn--primary margin-y-sm" aria-controls="drawer-1">Галерея</button>


        <x-admin.codemirror-editor :content="$manual->content_raw" name="content" id="content">
            <h4>Основной контент</h4>
            <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
                полный экран, ESC для выхода.</p>
        </x-admin.codemirror-editor>

    </div>

    <x-admin.add-cover :currentCover="$manual->getFirstMediaUrl('covers','320')" alt="Превью">

    </x-admin.add-cover>

    {{-- Add images --}}
    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
      <div class="text-component margin-y-sm">
        <h4 id="section-13">Добавить изображения</h4>
        <p class="text-md color-contrast-medium">Выберите одно или несколько изображений в формате <mark>jpg</mark>. После сохранения изменений можно будет редактировать теги <mark>alt</mark> у каждой картинки.</p>
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
    </div>
{{-- End add images --}}

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
              <x-admin.comments-table-row :comments="$manual->comments">
              </x-admin.comments-table-row>
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
    @push('js')
        <script src="{{ asset("js/admin/prism.min.js") }}"></script>
    @endpush
