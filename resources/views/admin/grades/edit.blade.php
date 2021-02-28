@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('grades.update', ['grade' => $grade->id]) }}">
    @csrf
    @method('PUT')
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Изменить оценку {{ $grade->name }}</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
      </div>
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-2@md">
            <label class="form-label" for="name">Название оценки</label>
          </div>
          
          <div class="col-10@md">
            <input class="form-control width-100%" type="text" name="name" id="name" value="{{ $grade->name }}">
          </div>
        </div>
      </div>
 
      <div>
        <div class="grid gap-xxs items-center@md">
          <div class="col-2@md">
            <label class="form-label" for="about">Описание</label>
            <p class="text-xs color-contrast-medium margin-top-xxxxs">Опционально</p>
          </div>
          
          <div class="col-10@md">
            <textarea class="form-control width-100%" name="about" id="code">{{ $grade->about }}</textarea>
          </div>
        </div>
      </div>
    </fieldset>
  
    <div class="text-right">
      <button type="submit" class="btn btn--primary">Отправить</button>
    </div>
  </form>
@endsection

l
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