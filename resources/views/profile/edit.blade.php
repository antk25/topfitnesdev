@extends('layouts.auth-base')
@section('title')
   Обновить профиль пользователя {{ $user->name }} | {{ env('APP_NAME') }}
@endsection

    <div class="bg container max-width-xxs padding-lg radius-md shadow-sm">

       {{-- Ошибки обновления --}}
@if ($errors->any())

<div class="alert alert--error alert--is-visible padding-sm radius-md js-alert" role="alert">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12,0C5.383,0,0,5.383,0,12s5.383,12,12,12s12-5.383,12-12S18.617,0,12,0z M13.645,5L13,14h-2l-0.608-9 H13.645z M12,20c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C14,19.105,13.105,20,12,20z"></path>
      </svg>
          <ul>
      @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
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
{{-- Конец ошибок обновления --}}

        <form class="login-form" method="POST" action="{{ route('update-user-profile') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="text-component text-center margin-bottom-sm">
              <h1>Редактирование профиля</h1>
              <p>Измените данные и нажмите обновить профиль.</p>
            </div>

            <div class="margin-bottom-sm">
                <label class="form-label margin-bottom-xxxs" for="name">{{ __('Name') }}</label>
                <input class="form-control width-100%" type="name" name="name" id="name" value="{{ old('name') ?? $user->name }}">
                @error('name')
                <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                @enderror
              </div>

            <div class="margin-bottom-sm">
              <label class="form-label margin-bottom-xxxs" for="email">{{ __('Email') }}</label>
              <input class="form-control width-100%" type="email" name="email" id="email" value="{{ old('email') ?? $user->email }}">
              @error('email')
              <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
            </div>

            <div class="margin-bottom-sm">
              <label for="avatar" class="form-label margin-bottom-xxxs">Загрузить аватар</label>
              <input id="avatar" type="file" class="form-control width-100%" name="avatar">
              @error('avatar')
              <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
            </div>

            <div class="margin-bottom-sm">
                <label class="form-label margin-bottom-xxxs" for="about">О себе</label>
                <textarea class="form-control width-100%" name="about" id="about">{{ old('about') ?? $user->about }}</textarea>
                @error('about')
                <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                @enderror
            </div>


            <div class="margin-bottom-sm">
              <button class="btn btn--primary btn--md width-100%">Обновить профиль</button>
            </div>
          </form>
          <div class="margin-bottom-sm">
            <a href="{{ route('profile.password') }}" class="btn btn--accent btn--md width-100%">Изменить пароль</a>
          </div>
    </div>

    <script src="{{ asset("js/scripts.js") }}"></script>
</body>
</html>