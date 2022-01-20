@extends('admin.layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
@endpush

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('admin_post_create') }}
</div>

<form class="form-template-v3" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf


        <x-admin.seo-block-create :users="$users">

        </x-admin.seo-block-create>

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
      @include('admin.layouts.parts.htmlcomponents')


        <x-admin.codemirror-editor :content="old('content')" name="content" id="content">
            <h4>Основной контент</h4>
            <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
                полный экран, ESC для выхода.</p>
        </x-admin.codemirror-editor>

        <x-admin.codemirror-editor :content="old('sources')" name="sources" id="sources">
            <h4>Источники</h4>
            <p class="color-contrast-medium text-sm">Указать ссылки на сайты или научные статьи</p>
        </x-admin.codemirror-editor>

    </div>

    <x-admin.add-cover currentCover="{{ asset('img/theme/img-placeholder.svg') }}" alt="Превью">

    </x-admin.add-cover>

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    {{-- Add images --}}
    <section class="margin-bottom-md">
      <div class="text-component margin-y-sm">
        <h4>Добавить изображения для обзора</h4>
        <p class="text-md color-contrast-medium">Выберите одно или несколько изображений в формате <mark>jpg</mark>. После публикации можно будет редактировать теги <mark>alt</mark> у каждой картинки.</p>
      </div>

      <div class="file-upload inline-block">
        <label for="files" class="file-upload__label btn btn--primary">
          <span class="flex items-center">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="2"><path  stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path><path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path><path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path></g></svg>

            <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить</span>
          </span>
        </label>

        <input type="file" class="file-upload__input" name="files[]" id="files" multiple>
      </div>
    </section>
{{-- End add images --}}
    </div>

            <div class="margin-y-md">
              <button type="submit" class="btn btn--success">Обновить статью</button>
            </div>
  </form>
@endsection

@push('js')
    <script src="{{ asset("js/admin/prism.min.js") }}"></script>
@endpush
