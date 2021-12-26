
@extends('admin.layouts.base')

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
    {{ Breadcrumbs::render('admin_comment', $comment) }}
  </div>

      @if(session('success'))

        <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
              </svg>

              <p class="text-sm"><strong>Успешно:</strong> комментарий успешно отредактирован.</p>
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
        <form method="POST" action="{{ route('comments.update', ['comment' => $comment->id]) }}">
          @csrf
          @method('PUT')
          {{-- Скрытые служебные поля --}}
          <input type="text" hidden name="commentable_type" value="{{ $comment->commentable_type }}">
          <input type="text" hidden name="commentable_id" value="{{ $comment->commentable_id }}">

          <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
              <legend class="form-legend margin-bottom-md">Выбранный комментарий</legend>

              <!-- input text -->
              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="username">Имя</label>
                  </div>

                  <div class="col-6@lg">
                    <input class="form-control width-100%" type="text" name="username" id="username" value="{{ $comment->username }}">
                  </div>
                </div>
              </div>

              <!-- input email -->
              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="useremail">Email</label>
                  </div>

                  <div class="col-6@lg">
                    <input class="form-control width-100%" type="email" name="useremail" id="useremail" placeholder="email@myemail.com" value="{{ $comment->useremail }}">
                  </div>
                </div>
              </div>


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
                          <option value="{{ $k }}" @if (isset($commentuser->email) == $v)
                            selected
                          @endif>{{ $v }}</option>
                        @endforeach
                      </select>

                      <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                    </div>
                  </div>
                </div>
              </div>

              <!-- invalid data -->
              {{-- <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="input-invalid">Invalid</label>
                  </div>

                  <div class="col-6@lg">
                    <input class="form-control width-100%" type="text" name="input-invalid" id="input-invalid" aria-invalid="true" value="invalid data">
                    <div role="alert" class="bg-accent bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Error:</strong> this is an error message</p></div>
                  </div>
                </div>
              </div> --}}

              <!-- textarea -->
              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="comment">Текст комментария</label>
                  </div>

                  <div class="col-6@lg">
                    <textarea class="form-control width-100%" name="comment" id="comment">{{ $comment->comment }}</textarea>
                  </div>
                </div>
              </div>

              {{-- <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm" for="is_published">Опубликовано</label>
                  </div>
                  <div class="col-6@lg">
                    <div class="switch ">
                      <input class="switch__input" type="checkbox" name="is_published" id="is_published" value="1" @if ($comment->is_published)checked
                      @endif>
                      <label class="switch__label" for="is_published" aria-hidden="true">Опубликовано</label>
                      <div class="switch__marker" aria-hidden="true"></div>
                    </div>
                  </div>
                </div>
              </div> --}}

              <!-- date picker -->
              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="created_at">Выбрать дату и время<i class="sr-only">, формат dd/mm/yyyy 18:45:32</i></label>
                  </div>

                  <div class="col-6@lg date-input js-date-input">
                    <div class="date-input__wrapper">
                      <input type="text" class="form-control width-100% date-input__text js-date-input__text" placeholder="dd/mm/yyyy" autocomplete="off" id="created_at" name="created_at"  value="{{ $comment->created_at->format('d/m/Y H:m:s') }}">

                      <button class="reset date-input__trigger js-date-input__trigger js-tab-focus" aria-label="Select date using calendar widget" type="button">
                        <svg class="icon" aria-hidden="true" viewBox="0 0 20 20"><g fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><rect x="1" y="4" width="18" height="14" rx="1"/><line x1="5" y1="1" x2="5" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="1" y1="9" x2="19" y2="9"/></g></svg>
                      </button>
                    </div>

                    <div class="date-picker bg radius-md shadow-md js-date-picker" role="dialog" aria-labelledby="calendar-label-1">
                      <header class="date-picker__header">
                        <div class="date-picker__month">
                          <span class="date-picker__month-label js-date-picker__month-label" id="calendar-label-1"></span> <!-- this will contain month label + year -->

                          <nav>
                            <ul class="date-picker__month-nav js-date-picker__month-nav">
                              <li>
                                <button class="reset date-picker__month-nav-btn js-date-picker__month-nav-btn js-date-picker__month-nav-btn--prev js-tab-focus" type="button">
                                  <svg class="icon icon--xs" viewBox="0 0 16 16"><title>Предыдущий месяц</title><polyline points="11 14 5 8 11 2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2"/></svg>
                                </button>
                              </li>

                              <li>
                                <button class="reset date-picker__month-nav-btn js-date-picker__month-nav-btn js-date-picker__month-nav-btn--next js-tab-focus" type="button">
                                  <svg class="icon icon--xs" viewBox="0 0 16 16"><title>Следующий месяц</title><polyline points="5 2 11 8 5 14" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2"/></svg>
                                </button>
                              </li>
                            </ul>
                          </nav>
                        </div>

                        <ol class="date-picker__week">
                          <li><div class="date-picker__day">П<span class="sr-only">онедельник</span></div></li>
                          <li><div class="date-picker__day">В<span class="sr-only">торник</span></div></li>
                          <li><div class="date-picker__day">С<span class="sr-only">реда</span></div></li>
                          <li><div class="date-picker__day">Ч<span class="sr-only">етверг</span></div></li>
                          <li><div class="date-picker__day">П<span class="sr-only">ятница</span></div></li>
                          <li><div class="date-picker__day">С<span class="sr-only">уббота</span></div></li>
                          <li><div class="date-picker__day">В<span class="sr-only">оскресенье</span></div></li>
                        </ol>
                      </header>

                      <ol class="date-picker__dates js-date-picker__dates" aria-labelledby="calendar-label-1">
                        <!-- days will be created using js -->
                      </ol>
                    </div>
                  </div>
                </div>
              </div>

            </fieldset>

          </div>

          <div class="border-top border-contrast-lower padding-md text-right">
            <button type="submit" class="btn btn--primary btn--md">Обновить</button>
          </div>
        </form>
      </div>


      <div class="bg radius-md shadow-xs margin-top-md">
        <form method="POST" action="{{ route('comments.reply') }}">
          @csrf
          {{-- Скрытые служебные поля --}}
          <input type="text" hidden name="commentable_type" value="{{ $comment->commentable_type }}">
          <input type="text" hidden name="commentable_id" value="{{ $comment->commentable_id }}">
          <input type="text" hidden name="parent_id" value="{{ $comment->id }}">

          <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
              <legend class="form-legend margin-bottom-md">Добавить ответ на комментарий {{ $comment->id }}</legend>

              {{-- <!-- input text -->
              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="username">Имя</label>
                  </div>

                  <div class="col-6@lg">
                    <input class="form-control width-100%" type="text" name="username" id="username">
                  </div>
                </div>
              </div>

              <!-- input email -->
              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="useremail">Email</label>
                  </div>

                  <div class="col-6@lg">
                    <input class="form-control width-100%" type="email" name="useremail" id="useremail" placeholder="email@myemail.com">
                  </div>
                </div>
              </div> --}}


              <!-- input date -->
              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="created_at">Дата создания</label>
                  </div>

                  <div class="col-6@lg">
                    <input class="form-control width-100%" type="text" readonly name="created_at" id="created_at" value="{{ now()->format('d/m/Y H:m:s') }}">
                  </div>
                </div>
              </div>


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

              <!-- invalid data -->
              {{-- <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="input-invalid">Invalid</label>
                  </div>

                  <div class="col-6@lg">
                    <input class="form-control width-100%" type="text" name="input-invalid" id="input-invalid" aria-invalid="true" value="invalid data">
                    <div role="alert" class="bg-accent bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Error:</strong> this is an error message</p></div>
                  </div>
                </div>
              </div> --}}

              <!-- textarea -->
              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="comment">Текст ответа на комментарий</label>
                  </div>

                  <div class="col-6@lg">
                    <textarea class="form-control width-100%" name="comment" id="comment"></textarea>
                  </div>
                </div>
              </div>

            </fieldset>

          </div>

          <div class="border-top border-contrast-lower padding-md text-right">
            <button type="submit" class="btn btn--primary btn--md">Добавить ответ</button>
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