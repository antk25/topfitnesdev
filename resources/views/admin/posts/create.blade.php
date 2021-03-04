@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Создать статью для блога</h2>
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
            <textarea class="form-control width-100%" name="content" id="code"></textarea>
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
        autoCloseTags: true,
        lineWrapping: true
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