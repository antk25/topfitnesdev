@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('sellers.store') }}">
    @csrf
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Добавить продавца</h2>
            <p>Управление продавцами и партнерскими программами для браслетов.</p>
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxxs" for="marketplace">Выбрать, если маркетплейс</label>

          <div class="select">
            <select class="select__input btn btn--subtle" name="marketplace" id="marketplace">
                <option value="">Выбрать маркетплейс</option>
                <option value="aliexpress">Aliexpress</option>
                <option value="ozon">Ozone</option>
            </select>

            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
          </div>
        </div>
        <div class="col-4@md">
          <label class="form-label margin-bottom-xxs" for="name">Название продавца</label>
          <input class="form-control width-100%" type="text" name="name" id="name">
          <p class="text-xs color-contrast-medium margin-top-xxs">Название магазина (если маркетплейс, то можно просто продавец 1, продавец 2. Выводится только, если это не маркетплейс)</p>
        </div>

          <div class="col-4@md">
            <label class="form-label margin-bottom-xxs" for="about">Описание:</label>
            <p class="text-xs color-contrast-medium margin-top-xxxxs">Опционально</p>

            <textarea class="form-control width-100%" name="about" id="about"></textarea>

          </div>
      </div>
    </fieldset>

    <div class="text-right">
      <button type="submit" class="btn btn--primary">Отправить</button>
    </div>
  </form>
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