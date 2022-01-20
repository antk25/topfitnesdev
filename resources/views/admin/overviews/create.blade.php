@extends('admin.layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
@endpush

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('admin_overview_create') }}
</div>

<div class="form-template-v3" method="POST" action="{{ route('overviews.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
        <label class="form-label margin-y-xs" for="bracelet_id">Браслет</label>
        <div class="select">
          <select class="select__input form-control @error('bracelet_id') form-control--error @enderror" name="bracelet_id">
            <option value="">Выбрать браслет для обзора</option>
            @foreach ($bracelets as $k => $v)
              <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
          </select>

          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
        </div>
          @error('bracelet_id')
          <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>ошибка:</strong> {{ $message }}</p></div>
          @enderror
      </div>
</div>

<x-admin.seo-block-create :users="$users">

</x-admin.seo-block-create>

<div class="bg radius-md shadow-xs padding-md margin-bottom-md">

      @include('admin.layouts.parts.htmlcomponents')


    <x-admin.codemirror-editor :content="old('content')" name="content" id="content">
        <h4>Основной контент</h4>
        <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
            полный экран, ESC для выхода.</p>
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
              <button type="submit" class="btn btn--success">Сохранить статью</button>
            </div>
  </form>
@endsection

@push('js')
    <script src="{{ asset("js/admin/prism.min.js") }}"></script>
@endpush
