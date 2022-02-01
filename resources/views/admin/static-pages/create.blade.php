@extends('admin.layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
@endpush

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('admin_static_page_create') }}
</div>

<form class="form-template-v3" method="POST" action="{{ route('static-pages.store') }}" enctype="multipart/form-data">
    @csrf

    <x-admin.seo-block-create>

    </x-admin.seo-block-create>

      <div class="bg radius-md shadow-xs padding-md margin-y-md">
        @include('admin.layouts.parts.htmlcomponents')
          <x-admin.codemirror-editor :content="old('content')" name="content" id="content">
              <h4>Основной контент</h4>
              <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
                  полный экран, ESC для выхода.</p>
          </x-admin.codemirror-editor>
    </div>

    <x-admin.add-images currentCover="placeholder">

    </x-admin.add-images>

    <div class="margin-y-md">
      <button type="submit" class="btn btn--success">Сохранить страницу</button>
    </div>
  </form>
@endsection

@push('js')
    <script src="{{ asset("js/admin/prism.min.js") }}"></script>
@endpush
