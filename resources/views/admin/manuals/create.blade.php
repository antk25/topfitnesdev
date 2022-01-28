@extends('admin.layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
@endpush

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('admin_manual_create') }}
</div>

<form class="form-template-v3" method="POST" action="{{ route('manuals.store') }}" enctype="multipart/form-data">
    @csrf

    <x-admin.seo-block-create :users="$users">

    </x-admin.seo-block-create>

      <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
      {{-- Add bracelets --}}
    <section class="margin-bottom-md">
      <div class="text-component">
        <h4>Добавить браслеты, которые упоминаются в мануале</h4>
      </div>
      <div class="js-repeater" data-repeater-input-name="allbracelets[n]">
        <div class="js-repeater__list">
          <div class="margin-y-md js-repeater__item">
              <div class="grid gap-xs">
                  <div class="col">
                      <div class="select margin-bottom-xxs">
                          <select class="select__input form-control" name="allbracelets[0]" id="allbracelets[0]"
                                  class="form-control">
                              <option value="">-- Выбрать браслет --</option>
                              @foreach ($bracelets as $k => $v)
                                  <option value="{{ $k }}">{{ $v }}</option>
                              @endforeach
                          </select>

                          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                      </div>
                  </div>
                  <div class="col-content">
                      <button class="btn btn--accent padding-x-xs col-content js-repeater__remove" type="button">
                          <svg class="icon" viewBox="0 0 20 20">
                              <title>Remove item</title>

                              <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                  <line x1="1" y1="5" x2="19" y2="5"/>
                                  <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5"/>
                                  <path d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8"/>
                              </g>
                          </svg>
                      </button>
                  </div>
              </div>
          </div>
        </div>
        <button class="btn btn--primary width-100% margin-top-xs js-repeater__add" type="button">+ Добавить браслет</button>
      </div>
    </section>
    {{-- End add bracelets --}}
      </div>


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
      <button type="submit" class="btn btn--success">Сохранить статью</button>
    </div>
  </form>
@endsection

@push('js')
    <script src="{{ asset("js/admin/prism.min.js") }}"></script>
@endpush
