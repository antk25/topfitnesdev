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
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="subtitle">Название рейтинга (h1)</label>
          </div>
          
          <div class="col-8@md">
            <input class="form-control width-100%" type="text" name="subtitle" id="subtitle" required>
          </div>
        </div>
      </div>
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="slug">URI (SLUG)</label>
          </div>
          
          <div class="col-8@md">
            <input class="form-control width-100%" type="text" name="slug" id="slug" required>
          </div>
        </div>
      </div>
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="title">Title</label>
          </div>
          
          <div class="col-8@md">
            <input class="form-control width-100%" type="text" name="title" id="title">
          </div>
        </div>
      </div>
  
      <div>
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="text">Основной контент</label>
          </div>
          
          <div class="col-8@md">
            <textarea class="form-control width-100%" name="text" id="code"></textarea>
          </div>
        </div>
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