@extends('layouts.auth-base')
@section('title')
     | {{ env('APP_NAME') }}
@endsection

<div class="bg container max-width-xxs padding-lg radius-md shadow-sm">

  {{-- Ошибки сброса --}}
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
  {{-- Конец ошибок сброса --}}

{{-- Сообщение об успешном сбросе пароля --}}
@if(session('success'))

<div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
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
{{-- Конец сообщения об успешном сбросе пароля --}}

      <form class="sign-up-form" method="POST" action="{{ route('reset-password') }}">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="text-component text-center margin-bottom-md">
          <h1>{{ __('Reset Password') }}</h1>
          <p>Сбросить пароль, используя форму ниже.</p>
        </div>

        <div class="margin-bottom-md">
            <label class="form-label margin-bottom-xxxs" for="password">Новый пароль</label>
            <input class="form-control width-100%" type="password" name="password" id="password" autocomplete="new-password">
            @error('password')
            <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
            @enderror
            <p class="text-xs color-contrast-medium margin-top-xxs">Минимальная длина 6 символов</p>
          </div>

          <div class="margin-bottom-md">
            <label class="form-label margin-bottom-xxxs" for="password-confirm">{{ __('Confirm Password') }}</label>
            <input class="form-control width-100%" type="password" name="password_confirmation" id="password-confirm" autocomplete="new-password">

          </div>

        <div class="margin-bottom-sm">
          <button class="btn btn--primary btn--md width-100%">{{ __('Reset Password') }}</button>
        </div>
      </form>
    </div>

    <script src="{{ asset("js/scripts.js") }}"></script>
</body>
</html>
