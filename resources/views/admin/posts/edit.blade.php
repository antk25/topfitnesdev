@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}">
    @csrf
    @method('PUT')
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Изменить статью {{ $post->name }}</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
      </div>
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="name">Название</label>
          </div>
          
          <div class="col-8@md">
            <input class="form-control width-100%" type="text" name="name" id="name" value="{{ $post->name }}">
          </div>
        </div>
      </div>
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="slug">URI (SLUG)</label>
          </div>
          
          <div class="col-8@md">
            <input class="form-control width-100%" type="text" name="slug" id="slug" value="{{ $post->slug }}">
          </div>
        </div>
      </div>
  
      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="title">Title</label>
          </div>
          
          <div class="col-8@md">
            <input class="form-control width-100%" type="text" name="title" id="title" value="{{ $post->title }}">
          </div>
        </div>
      </div>
  
      <div>
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="content">Описание</label>
            <p class="text-xs color-contrast-medium margin-top-xxxxs">Опционально</p>
          </div>
          
          <div class="col-8@md">
            <textarea class="form-control width-100%" name="content" id="code">{{ $post->content }}</textarea>
          </div>
        </div>
      </div>
    </fieldset>
  
    <div class="text-right">
      <button type="submit" class="btn btn--primary">Отправить</button>
    </div>
  </form>


  <button class="btn btn--primary" aria-controls="drawer-2">Toggle Drawer Panel</button>

<div class="drawer js-drawer" id="drawer-2">
  <div class="drawer__content bg shadow-md flex flex-column" role="alertdialog" aria-labelledby="drawer-title-2">
    <header class="flex items-center justify-between flex-shrink-0 border-bottom border-contrast-lower padding-x-sm padding-y-xs">
      <h1 id="drawer-title-2" class="text-md text-truncate">Drawer title</h1>

      <button class="reset drawer__close-btn js-drawer__close js-tab-focus">
        <svg class="icon icon--xs" viewBox="0 0 16 16"><title>Close drawer panel</title><g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"><line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line><line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line></g></svg>
      </button>
    </header>

    <div class="drawer__body padding-sm js-drawer__body">
      <div class="text-component">
        

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla molestiae laudantium quis et, veniam, eveniet aperiam facere dolorem iusto reiciendis veritatis dolorum nisi? Eligendi inventore nam nihil, rem dolores nulla autem repellat sunt iure omnis ullam nisi voluptatem id expedita beatae, officiis accusantium consequatur, ea dignissimos enim consequuntur odio cumque.</p>

        {{ $media }}

        

      <pre class="code-snippet">
        <code id='p1'>
          {{ $media }}
        </code>
      </pre>

      </div>
    </div>
  </div>
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

      var text = document.getElementById('p1').innerHTML;
      text = text.replace("<","&lt;");
      text = text.replace(">","&gt;");
      text = text.replace("          ","");

      document.getElementById('p1').innerHTML = text;

    </script>    
@endsection