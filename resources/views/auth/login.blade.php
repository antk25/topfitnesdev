@extends('layouts.auth-base')
@section('title')
   Войти | {{ env('APP_NAME') }}
@endsection

    <div class="bg container max-width-xxs padding-lg radius-md shadow-sm">

       {{-- Ошибки входа --}}
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
{{-- Конец ошибок входа --}}

        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            @method('POST')
            <div class="text-component text-center margin-bottom-sm">
              <h1>Вход</h1>
            </div>

            <div class="margin-bottom-sm">
              <label class="form-label margin-bottom-xxxs" for="email">Email</label>
              <input class="form-control width-100%" type="email" name="email" id="email" placeholder="email@myemail.com" @if (old('email')) value="{{ old('email') }}" @endif>
              @error('email')
              <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
            </div>

            <div class="margin-bottom-sm">
              <div class="flex justify-between margin-bottom-xxxs">
                <label class="form-label" for="password">Пароль</label>
                    <span class="text-sm"><a href="{{ route('forgot-form') }}">Забыли пароль?</a></span>
              </div>
              <input class="form-control width-100%" type="password" name="password" id="password">
              @error('password')
              <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
            </div>

            <div class="margin-bottom-md">
              <input class="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">{{ __('Remember Me') }}</label>
            </div>

            <div class="margin-bottom-sm">
              <button class="btn btn--primary btn--md width-100%">Войти</button>
            </div>

            <div class="text-center">
              <p class="text-sm">У вас еще нет аккаунта? <a href="{{ route('register') }}">Регистрация</a></p>
            </div>
          </form>
    </div>


