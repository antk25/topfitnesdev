
@extends('admin.layouts.base')

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('admin_comment_create') }}
</div>

  @if(session('success'))

    <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
          </svg>

          <p class="text-sm"><strong>Успешно:</strong> комментарий успешно создан.</p>
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

<div class="bg radius-md shadow-xs">
  <form method="POST" action="{{ route('comments.store') }}">
    @csrf

    <div class="padding-md">
      <fieldset class="margin-bottom-md">
        {{-- select model --}}
        {{-- <div class="margin-bottom-sm">
          <div class="grid gap-xxs">
            <div class="col-3@lg">
              <label class="inline-block text-sm padding-top-xs@lg" for="model_name">Выбрать модель</label>
            </div>

            <div class="col-6@lg">
              <div class="select">
                <select class="select__input form-control" name="model_name">
                    <option value="Post">Статья блога</option>
                    <option value="Rating">Рейтинг браслетов</option>
                </select>

                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
              </div>
            </div>
          </div>
        </div> --}}


        {{-- select article --}}
        <div class="margin-bottom-sm">
          <div class="grid gap-xxs">
            <div class="col-3@lg">
              <label class="inline-block text-sm padding-top-xs@lg" for="item_id">Что комментируем</label>
            </div>

            <div class="col-6@lg">
              <div class="select">
                <select class="select__input form-control" name="item_id">
                  <option value="">Выбрать страницу</option>
                  <optgroup label="Статьи блога">
                  @foreach ($posts as $item)
                    <option value="{{ $item->id }},{{ get_class($item) }}">{{ $item->name }}</option>
                  @endforeach
                  </optgroup>

                  <optgroup label="Рейтинги">
                  @foreach ($ratings as $item)
                    <option value="{{ $item->id }},{{ get_class($item) }}">{{ $item->name }}</option>
                  @endforeach
                  </optgroup>
                </select>

                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
              </div>
            </div>
          </div>
        </div>

      </fieldset>
      <!-- basic form controls -->
      <fieldset class="margin-bottom-md">

        <div class="margin-bottom-sm">
          <div class="grid gap-xxs">
            <div class="col-3@lg">
              <label class="inline-block text-sm padding-top-xs@lg" for="input-name">Выбрать зарегистрированного пользователя</label>
            </div>

            <div class="col-6@lg">
              <div class="select">
                <select class="select__input form-control" name="user_id">
                  <option value="">Выбрать пользователя</option>
                  @foreach ($users as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                  @endforeach
                </select>

                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
              </div>
            </div>
          </div>
        </div>


        <div class="margin-bottom-sm">
          <div class="grid gap-xxs">
            <div class="col-3@lg">
              <label class="inline-block text-sm padding-top-xs@lg" for="input-name">Или написать от анонимного</label>
            </div>

            <div class="col-6@lg">
              <div class="choice-accordion  js-choice-accordion" data-animation="on">

            <div class="choice-accordion__item">
              <!-- fallback -->
              <div class="choice-accordion__fallback js-choice-accordion__fallback">
                <input type="checkbox" id="choice-accordion-check-1">
                <label for="choice-accordion-check-1">Ввести данные пользователя</label>
              </div>

              <!-- control -->
              <div class="choice-accordion__btn padding-sm js-choice-accordion__btn" aria-hidden="true">
                <div class="choice-accordion__input choice-accordion__input--checkbox">
                  <svg class="icon" viewBox="0 0 16 16">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 8l4 4 8-8" /></svg>
                </div>

                <p class="color-contrast-higher user-select-none">Ввести данные пользователя</p>
              </div>

              <!-- panel -->
              <div class="choice-accordion__panel js-choice-accordion__panel">
                <div class="bg grid gap-xxs padding-md">
                  <div class="col-6@lg">
                    <input class="form-control width-100%" type="text" name="username" id="username" placeholder="Имя">
                  </div>

                  <div class="col-6@lg">
                    <input class="form-control width-100%" type="email" name="useremail" id="useremail" placeholder="email@myemail.com">
                  </div>
                </div>

              </div>

            </div>

          </div>
            </div>
          </div>
        </div>

      </fieldset>

      <fieldset class="margin-bottom-md">

        <!-- textarea -->
        <div class="margin-bottom-sm">
          <div class="grid gap-xxs">
            <div class="col-3@lg">
              <label class="inline-block text-sm padding-top-xs@lg" for="comment">Текст комментария</label>
            </div>

            <div class="col-6@lg">
              <textarea class="form-control width-100%" name="comment" id="comment"></textarea>
            </div>
          </div>
        </div>

        <!-- input date -->
        <div class="margin-bottom-sm">
          <div class="grid gap-xxs">
            <div class="col-3@lg">
              <label class="inline-block text-sm padding-top-xs@lg" for="created_at">Дата создания</label>
            </div>

            <div class="col-6@lg">
              <input class="form-control width-100%" type="text" readonly name="created_at" id="created_at" value="{{ now()->format('Y-m-d H:m:s') }}">
            </div>
          </div>
        </div>

      </fieldset>

    </div>

    <div class="border-top border-contrast-lower padding-md text-right">
      <button type="submit" class="btn btn--primary btn--md">Сохранить</button>
    </div>
  </form>
</div>














































@endsection

@section('scripts')
@parent
<script src="{{ asset("js/admin/codemirror.js") }}"></script>
    <script src="{{ asset("js/admin/closetag.js") }}"></script>
    <script src="{{ asset("js/admin/htmlmixed.js") }}"></script>
    <script src="{{ asset("js/admin/css.js") }}"></script>
    <script src="{{ asset("js/admin/javascript.js") }}"></script>
    <script src="{{ asset("js/admin/xml.js") }}"></script>
    <script src="{{ asset("js/admin/xml-fold.js") }}"></script>
    <script>
      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        mode: 'text/html',
        autoCloseTags: true
      });
    </script>
@endsection