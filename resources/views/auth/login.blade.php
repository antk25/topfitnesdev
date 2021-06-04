
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
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="text-component text-center margin-bottom-sm">
              <h1>Вход</h1>
              <p>Введите свой email и пароль</p>
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
                @if (Route::has('password.request'))
                <span class="text-sm"><a href="{{ route('password.request') }}">Забыли пароль?</a></span>
                @endif
              </div>

              <input class="form-control width-100%" type="password" name="password" id="password">
              @error('password')
              <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror
            </div>
            
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

              <label class="form-check-label" for="remember">
                  {{ __('Remember Me') }}
              </label>
            </div>

            <div class="margin-bottom-sm">
              <button class="btn btn--primary btn--md width-100%">Войти</button>
            </div>

            <div class="text-center">
              <p class="text-sm">У вас еще нет аккаунта? <a href="{{ route('register') }}">Регистрация</a></p>
            </div>
          </form>
    </div>

    <script src="{{ asset("js/scripts.js") }}"></script>
</body>
</html>