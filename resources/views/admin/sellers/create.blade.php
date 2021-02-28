@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('sellers.store') }}">
    @csrf
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Добавить продавца</h2>
            <p>Управление продавцами и партнерскими программами для браслетов.</p>
      </div>
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="name">Название продавца</label>
          </div>
          
          <div class="col-8@md">
            <input class="form-control width-100%" type="text" name="name" id="name" required>
          </div>
        </div>
      </div>
  
      <div>
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="about">Описание</label>
            <p class="text-xs color-contrast-medium margin-top-xxxxs">Опционально</p>
          </div>
          
          <div class="col-8@md">
            <textarea class="form-control width-100%" name="about" id="code"></textarea>
          </div>
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