@extends('admin.layouts.base')

@section('content')

<div class="container">
  <form class="form-template-v3" method="POST" action="{{ route('ratings.store') }}">
    @csrf
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Новый рейтинг</h2>
        <p>Создание страниц рейтингов.</p>
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="name">Название рейтинга</label>
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
        <label class="form-label margin-bottom-xxs" for="text">Основной контент</label>
            <textarea class="form-control width-100%" name="text" id="code"></textarea>
      </div>
            
    </fieldset>

    <div class="row" x-data="handler()">
      <div class="col">

        <table class="table table--expanded@xs position-relative z-index-1 width-100% js-table">
          <thead class="table__header">
            <tr class="table__row">
              <th class="table__cell text-left" scope="col">#</th>
              <th class="table__cell text-left" scope="col">Браслет</th>
              <th class="table__cell text-right" scope="col">Позиция</th>
              <th class="table__cell text-right" scope="col">Текст</th>
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
              <td class="table__cell  text-left" role="cell">
                <input x-model="field.position" class="form-control" type="number" name="position[]" min="0" max="20" step="1">
              </td>
              <td class="table__cell" role="cell">
                <textarea class="form-control width-100%" name="text_rating[]" id="code"></textarea>
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

    <div class="text-right">
      <button type="submit" class="btn btn--primary">Отправить</button>
    </div>
  </form>


</div>

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
        autoCloseTags: true
      });

  function handler() {
    return {
      fields: [],
      addNewField() {
          this.fields.push({
              bracelets: '',
              position: '',
              text_rating: ''
           });
        },
        removeField(index) {
           this.fields.splice(index, 1);
         }
      }
 }

    </script>
@endsection