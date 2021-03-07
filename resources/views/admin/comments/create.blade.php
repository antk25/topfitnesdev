
@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('comments.store') }}">
    @csrf
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Написать комментарий</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
      </div>
      
      
      <div class="margin-bottom-xs">
        <div class="select">
          <select class="select__input form-control" name="model_name">
              <option value="Post">Статья блога</option>
              <option value="Rating">Рейтинг браслетов</option>
          </select>
          
          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
      </div>
      
      <div class="margin-bottom-xs">
        <div class="select">
          <select class="select__input form-control" name="post_id">
            <option value="">Выбрать статью блога</option>
            @foreach ($posts as $k => $v)
              <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
          </select>
          
          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <div class="select">
          <select class="select__input form-control" name="rating_id">
            <option value="">Выбрать рейтинг браслетов</option>
            @foreach ($ratings as $k => $v)
              <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
          </select>
          
          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
      </div>
      
      <div class="margin-bottom-xs">
        <div class="select">
          <select class="select__input form-control" name="user_id">
            @foreach ($users as $k => $v)
              <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
          </select>
          
          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
      </div>
     
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="comment">Комментарий</label>
          </div>
          
          <div class="col-8@md">
            <textarea class="form-control width-100%" rows="5" name="comment" id="comment"></textarea>
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