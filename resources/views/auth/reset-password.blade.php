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
        
      <form class="sign-up-form" method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div class="text-component text-center margin-bottom-md">
          <h1>{{ __('Reset Password') }}</h1>
          <p>Восстановите, используя форму ниже.</p>
        </div>
      
        <div class="margin-bottom-sm">
          <label class="form-label margin-bottom-xxxs" for="email">{{ __('E-Mail Address') }}</label>
          <input class="form-control width-100%" type="email" name="email" id="email" value="{{ request()->get('email') ?? old('email') }}" required autocomplete="email" autofocus>
          @error('email')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
        </div>

        <div class="margin-bottom-md">
            <label class="form-label margin-bottom-xxxs" for="password">Пароль</label> 
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