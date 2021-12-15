@extends('admin.layouts.base')

@section('content')

<div class="margin-bottom-md">
  <h1 class="text-lg">Новая оценка</h1>
</div>

<form class="form-template-v3" method="POST" action="{{ route('grades.store') }}">
    @csrf
    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">
            <label class="form-label" for="name">Название оценки</label>
          </div>

          <div class="col-8@md">
            <input class="form-control width-100% @error('name') form-control--error @enderror" type="text" name="name" id="name" value="{{ old('name') }}">
              @error('name')
              <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
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
