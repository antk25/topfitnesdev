
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
      <form class="sign-up-form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="text-component text-center margin-bottom-sm">
          <h1>Регистрация</h1>
          <p>Зарегистрироваться на сайте<br>
          У вас уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
        </div>
                  
        <div class="margin-bottom-sm">
          <label class="form-label margin-bottom-xxxs" for="name">Имя</label>
          <input class="form-control width-100%" type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name">
          @error('name')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
        </div>
      
        <div class="margin-bottom-sm">
          <label class="form-label margin-bottom-xxxs" for="email">Email</label>
          <input class="form-control width-100%" type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email">
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
          <label class="form-label margin-bottom-xxxs" for="password-confirm">Повторите пароль</label> 
          <input class="form-control width-100%" type="password" name="password_confirmation" id="password-confirm" autocomplete="new-password">
         
        </div>
      
        {{-- <div class="margin-bottom-md">
          <input class="checkbox" type="checkbox" id="check-newsletter">
          <label for="check-newsletter">Send me updates about {productName}</label>
        </div> --}}
      
        <div class="margin-bottom-sm">
          <button class="btn btn--primary btn--md width-100%">Зарегистрироваться</button>
        </div>
      
        <div class="text-center">
          <p class="text-xs color-contrast-medium">Регистрируясь вы принимаете <a href="#0">Пользовательскте соглашение</a> и <a href="#0">Политику конфиденциальности</a>.</p>
        </div>
      </form>
    </div>
    
    <script src="{{ asset("js/scripts.js") }}"></script>
</body>
</html>