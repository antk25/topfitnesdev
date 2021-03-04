@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
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
        <label class="form-label" for="content">Текст статьи</label>
            <textarea class="form-control width-100%" name="content" id="code">{{ $post->content }}</textarea>
      </div>
    </fieldset>

    <h2>Добавить еще картинки</h2>
            <div class="row" x-data="handler()">
              <div class="col">
  
                <table class="table table--expanded@xs position-relative z-index-1 width-100% js-table">
                  <thead class="table__header">
                    <tr class="table__row">
                      <th class="table__cell text-left" scope="col">#</th>
                      <th class="table__cell text-left" scope="col">Файл</th>
                      <th class="table__cell text-left" scope="col">Alt</th>
                      <th class="table__cell text-left" scope="col">Удалить</th>
                    </tr>
                  </thead>
                  <tbody class="table__body">
                    <template x-for="(field, index) in fields" :key="index">
                    <tr class="table__row">
                      <td x-text="index + 1"></td>
                      <td class="table__cell" role="cell">
                        

                          <input type="file" class="file-upload__input" name="files[]">
                        
                       </td>
                      <td class="table__cell  text-left" role="cell">
                        <input x-model="field.nameimg" class="form-control" type="text" name="nameimg[]">
                      </td>
                       <td class="table__cell" role="cell"><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                    </tr>
                   </template>
                  </tbody>
                  <tfoot>
                    <tr class="table__row">
                       <td colspan="4" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Добавить картинку</button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>

    <div class="text-right">
      <button type="submit" class="btn btn--primary">Отправить</button>
    </div>
  </form>

  <h2>Все картинки статьи</h2>

  <table class="table table--expanded@xs position-relative z-index-1 width-100% js-table">
    <thead class="table__header">
      <tr class="table__row">
        <th class="table__cell text-left" scope="col">#</th>
        <th class="table__cell text-left" scope="col">Файл</th>
        <th class="table__cell text-left" scope="col">Alt</th>
        <th class="table__cell text-left" scope="col">Код</th>
        <th class="table__cell text-left" scope="col">Удалить</th>
      </tr>
    </thead>
    <tbody class="table__body">
      @foreach ($media as $image)
      <tr class="table__row">
        <td>{{ $image->id }}</td>
        <td class="table__cell" role="cell">
          <img width="200px" src="{{ $image->getFullUrl('320') }}" alt=""><br>
          <strong>{{ $image->human_readable_size }}</strong>
         </td>
        <td class="table__cell  text-left" role="cell">
          <form method="POST" action="{{ route('posts.updimg') }}">
            @csrf
            <input class="form-control" type="text" value="{{ $image->name }}" name="nameimg">
            <input type="text" hidden value="{{ $image->id }}" name="imgid">
            <button type="submit" class="btn btn--secondary text-sm">
              <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                <g>
                  <path d="M8,3c1.179,0,2.311,0.423,3.205,1.17L8.883,6.492l6.211,0.539L14.555,0.82l-1.93,1.93 C11.353,1.632,9.71,1,8,1C4.567,1,1.664,3.454,1.097,6.834l1.973,0.331C3.474,4.752,5.548,3,8,3z"></path>
                  <path d="M8,13c-1.179,0-2.311-0.423-3.205-1.17l2.322-2.322L0.906,8.969l0.539,6.211l1.93-1.93 C4.647,14.368,6.29,15,8,15c3.433,0,6.336-2.454,6.903-5.834l-1.973-0.331C12.526,11.248,10.452,13,8,13z"></path>
                </g>
              </svg>
            </button>
          </form>
          
        </td>
        <td class="table__cell" role="cell">
          <pre class="code-snippet margin-y-sm">
            <code>&lt;img src="{{ $image->getFullUrl() }}"<br> srcset="{{ $image->getFullUrl('320') }} 320w,<br> {{ $image->getFullUrl('640') }} 640w"<br> alt="{{ $image->name }}"&gt;</code>
          </pre>
        </td>
         <td class="table__cell" role="cell">
          <form method="POST" action="{{ route('posts.delimg') }}">
            @csrf
            <input type="text" hidden value="{{ $image->id }}" name="imgid">
            <button type="submit" class="btn btn--secondary text-sm">&times;</button>
          </form>
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>

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

        @foreach ($media as $image)
        <img src="{{ $image->getFullUrl() }}" srcset="{{ $image->getFullUrl('320') }} 320w, {{ $image->getFullUrl('640') }} 640w" alt="">
        <pre class="code-snippet margin-y-sm">
          <code>&lt;img src="{{ $image->getFullUrl() }}"<br> srcset="{{ $image->getFullUrl('320') }} 320w,<br> {{ $image->getFullUrl('640') }} 640w"<br> alt="{{ $image->name }} {{ $image->human_readable_size }}"&gt;</code>
        </pre>
        {{-- <form method="POST" action="{{ route('posts.delimg', ['img' => $image]) }}">
          @csrf
          <button type="submit" class="btn btn--primary text-sm">Удалить</button>
        </form> --}}

        @endforeach

      </div>
    </div>
  </div>
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

  

      // var text = document.getElementById('p1').innerHTML;
      // text = text.replace("<","&lt;");
      // text = text.replace(">","&gt;");
      // text = text.replace("          ","");

      // document.getElementById('p1').innerHTML = text;

    </script>
@endsection