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

<form class="form-template-v3" method="POST" action="{{ route('overviews.store') }}" enctype="multipart/form-data">
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

    <x-admin.add-images currentCover="placeholder">

    </x-admin.add-images>

      <div class="margin-y-md">
        <button type="submit" class="btn btn--success">Сохранить статью</button>
      </div>
  </form>
@endsection

@push('js')
    <script src="{{ asset("js/admin/prism.min.js") }}"></script>
@endpush
