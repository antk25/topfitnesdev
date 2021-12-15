@extends('admin.layouts.base')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')

<div class="margin-bottom-md">
  <h1 class="text-lg">Новый бренд</h1>
</div>

{{-- Сообщение об успешности сохранения --}}
@if(session('success'))

<div class="alert alert--success alert--is-visible padding-sm radius-md js-alert margin-y-sm" role="alert">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
      </svg>

      <p class="text-sm"><strong>Успешно:</strong> {{ session('success') }}.</p>
    </div>

    <button class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
      <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
        <title>Close alert</title>
        <line x1="3" y1="3" x2="17" y2="17" />
        <line x1="17" y1="3" x2="3" y2="17" />
      </svg>
    </button>
  </div>
</div>
@endif
{{-- Конец сообщения об успешности сохранения --}}

<form class="form-template-v3" method="POST" action="{{ route('brands.store') }}">
    @csrf
    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="name">Название бренда</label>
          </div>

          <div class="col-8@md">
            <input class="form-control width-100% @error('name') form-control--error @enderror" type="text" name="name" id="name" value="{{ old('name') }}">
              @error('name')
              <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="slug">URI (SLUG)</label>
          </div>

          <div class="col-8@md">
            <input class="form-control width-100% @error('slug') form-control--error @enderror" type="text"  name="slug" id="slug" value="{{ old('slug') }}">
              @error('slug')
              <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="title">Title</label>
              <p class="text-xs color-contrast-medium margin-top-xxxxs">Опционально</p>
          </div>

          <div class="col-8@md">
            <input class="form-control width-100%" type="text" name="title" id="title" value="{{ old('title') }}">
          </div>
        </div>
      </div>

      <div>
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="about">Описание</label>
            <p class="text-xs color-contrast-medium margin-top-xxxxs">Опционально</p>
          </div>

          <div class="col-8@md">
            <textarea class="form-control width-100%" name="about" id="code">{{ old('about') }}</textarea>
          </div>
        </div>
      </div>
    </fieldset>
    </div>

    <div class="text-right">
      <button type="submit" class="btn btn--primary">Сохранить</button>
    </div>
  </form>
@endsection

@section('scripts')
@endsection
