@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('menuitems.update', ['menuitem' => $menuitem->id]) }}">
    @csrf
    @method('PUT')
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Изменить пункт меню {{ $menuitem->name }}</h2>
      </div>

      <label class="form-label margin-y-xs" for="post_id">Ссылка</label>
        <div class="select">
          <select class="select__input form-control" name="post_id">
            @foreach ($posts as $k => $v)
              <option value="{{ $k }}" @if ($menupostslug->id == $k) selected @endif>{{ $v }}</option>
            @endforeach
          </select>
          
          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-2@md">
            <label class="form-label" for="name">Название пункта</label>
          </div>
          
          <div class="col-10@md">
            <input class="form-control width-100%" type="text" name="name" id="name" value="{{ $menuitem->name }}">
          </div>
        </div>
      </div>
 
      <div class="margin-bottom-xs">
        <label class="form-label margin-y-xs" for="group_menu_id">Группа</label>
        <div class="select">
          <select class="select__input form-control" name="group_menu_id">
            @foreach ($groupmenus as $k => $v)
              <option value="{{ $k }}" @if ($groupmenusid->id == $k) selected @endif>{{ $v }}</option>
            @endforeach
          </select>
          
          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
</div>

      <label class="form-label margin-y-xs" for="place">Расположение</label>
      <div class="select">
        <select class="select__input form-control" name="place">
            <option value="header" @if ($menuitem->place == 'header') selected @endif>В шапке</option>
            <option value="footer" @if ($menuitem->place == 'footer') selected @endif>В футере</option>
        </select>
        
        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
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