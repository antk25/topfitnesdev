@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('comparisons.store') }}" enctype="multipart/form-data">
    @csrf
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Создать сравнение 2-х браслетов</h2>
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

      <h2>Браслеты</h2>

      <div class="row" x-data="handler2()">
        <div class="col">

          <table class="table table--expanded@xs position-relative z-index-1 width-100% js-table">
            <thead class="table__header">
              <tr class="table__row">
                <th class="table__cell text-left" scope="col">#</th>
                <th class="table__cell text-left" scope="col">Оценка</th>
                <th class="table__cell text-right" scope="col">Значение</th>
                <th class="table__cell text-right" scope="col">Позиция</th>
                <th class="table__cell text-right" scope="col">Удалить</th>
              </tr>
            </thead>
            <tbody class="table__body">
              <template x-for="(field, index) in fields" :key="index">
              <tr class="table__row">
                <td x-text="index + 1"></td>
                <td class="table__cell" role="cell">
                  <div class="select">
                    <select class="select__input form-control" name="bracelets[]"  x-model="field.bracelets">
                      @foreach ($bracelets as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                      @endforeach
                    </select>

                    <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                  </div>
                </td>
                
                 <td class="table__cell" role="cell"><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
              </tr>
             </template>
            </tbody>
            <tfoot>
              <tr class="table__row">
                 <td colspan="4" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Добавить браслет</button></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
  
      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="name">Название</label>
          <input class="form-control width-100%" type="text" name="name" id="name">
          <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название, menutitle</p>
        </div>

        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="slug">URI (SLUG)</label>
        <input class="form-control width-100%" type="text" name="slug" id="slug">
        </div>
      </div>
  
      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="title">Title</label>
        <input class="form-control width-100%" type="text" name="title" id="title">
      </div>
  
      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="subtitle">Subtitle (h1)</label>
          <input class="form-control width-100%" type="text" name="subtitle" id="subtitle">
        </div>
        <div class="col-6@md">
          <div class="character-count js-character-count">
            <label class="form-label margin-bottom-xxs" for="textareaName">Description:</label>
            <textarea class="form-control width-100% js-character-count__input" name="description" id="description" maxlength="300"></textarea>
            <div class="character-count__helper character-count__helper--dynamic text-sm margin-top-xxxs" aria-live="polite" aria-atomic="true">
              Осталось <span class="js-character-count__counter"></span> символов
            </div>
            <div class="character-count__helper character-count__helper--static text-sm margin-top-xxxs">Макс 300 символов</div>
          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="content">Текст статьи</label>
        <div class="margin-y-sm">Код</div>
              <div id="editor"></div>
              <div class="margin-y-sm">Textarea</div>
            <textarea class="form-control width-100% text-sm" spellcheck="false" name="content" id="content"></textarea>
      </div>
    </fieldset>

    <section class="bg bg-white padding-sm">
      <p class="color-contrast-medium margin-bottom-sm">Добавить картинки</p>
              <div class="row" x-data="handler()">
                <table class="tbl__table border-bottom border-2" aria-label="Table Example">
                    <thead class="tbl__header border-bottom border-2">
                      <tr class="tbl__row">
                        <th class="tbl__cell text-left" scope="col">
                          <span class="text-xs text-uppercase letter-spacing-lg font-semibold">#</span>
                          </th>
  
                          <th class="tbl__cell text-left" scope="col">
                          <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Файл</span>
                          </th>
  
                          <th class="tbl__cell text-left" scope="col">
                          <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Alt</span>
                          </th>
  
                          <th class="tbl__cell" scope="col">
                          <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Удалить</span>
                          </th>
                      </tr>
                    </thead>
                    <tbody class="tbl__body">
                      <template x-for="(field, index) in fields" :key="index">
                      <tr class="tbl__row">
                        <td x-text="index + 1"></td>
                        <td class="tbl__cell" role="cell">
  
  
                            <input type="file" class="file-upload__input" name="files[]">
  
                         </td>
                        <td class="tbl__cell" role="cell">
                          <input x-model="field.nameimg" class="form-control" type="text" name="nameimg[]">
                        </td>
                         <td class="tbl__cell" role="cell"><button type="button" class="btn btn--accent text-sm" @click="removeField(index)">&times;</button></td>
                      </tr>
                     </template>
                    </tbody>
                    <tfoot>
                      <tr class="tbl__cell">
                         <td colspan="4" class="text-left"><button type="button" class="btn btn--success text-sm" @click="addNewField()">+ Добавить картинку</button></td>
                      </tr>
                    </tfoot>
                  </table>
              </div>
            </section>
  
            <div class="margin-y-md">
              <button type="submit" class="btn btn--success">Обновить статью</button>
            </div>
  </form>
@endsection

@section('scripts')
@parent
<script src="{{ asset("js/admin/alpine.min.js") }}"></script>
    <script src="{{ asset("js/admin/ace.js") }}"></script>
    <script
			  src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
			  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
			  crossorigin="anonymous"></script>
    <script>

     var textarea = $('#content');

   var editor = ace.edit("editor");
   editor.setTheme("ace/theme/twilight");
   editor.getSession().setMode("ace/mode/html");

   editor.getSession().on('change', function () {
       textarea.val(editor.getSession().getValue());
   });

   textarea.val(editor.getSession().getValue());

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


  function handler2() {
      return {
        fields: [],
        addNewField() {
            this.fields.push({
                bracelets: ''
            });
          },
          removeField(index) {
            this.fields.splice(index, 1);
          }
        }
  }
    </script>    
@endsection