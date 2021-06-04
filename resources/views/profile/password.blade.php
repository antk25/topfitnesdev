<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <script>
      if ('CSS' in window && CSS.supports('color', 'var(--color-var)')) {
        document.write('<link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">');
      } else {
        document.write('<link rel="stylesheet" href="{{ asset('css/admin/style-fallback.css') }}">');
      }
    </script>
    <noscript>
      <link rel="stylesheet" href="{{ asset('css/admin/style-fallback.css') }}">
    </noscript>
    <title>Document</title>
</head>
<body>
    <div class="container max-width-xxs padding-y-lg">
        
      <form class="sign-up-form" method="POST" action="{{ route('user-password.update') }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div class="text-component text-center margin-bottom-md">
          <h1>Сменить пароль</h1>
        </div>

        @if (session('status') == "password-updated")
        <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
                </svg>

                <p class="text-sm">Пароль успешно обновлен!</p>
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
      
        <div class="margin-bottom-sm">
          <label class="form-label margin-bottom-xxxs" for="current_password">{{ __('Current Password') }}</label>
          <input class="form-control width-100%" type="password" name="current_password" id="current_password" required @error('current_password', 'updatePassword') aria-invalid="true" @enderror autocomplete="current_password" autofocus>
          @error('current_password', 'updatePassword')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
        </div>

        <div class="margin-bottom-md">
            <label class="form-label margin-bottom-xxxs" for="password">Новый пароль</label> 
            <input class="form-control width-100%" type="password" name="password" id="password" @error('password', 'updatePassword') aria-invalid="true" @enderror autocomplete="new-password">
            @error('password', 'updatePassword')
            <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
            @enderror
            <p class="text-xs color-contrast-medium margin-top-xxs">Минимальная длина 6 символов</p>
          </div>

          <div class="margin-bottom-md">
            <label class="form-label margin-bottom-xxxs" for="password-confirm">Повторите новый пароль</label> 
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