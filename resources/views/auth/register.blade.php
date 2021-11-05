<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <title>Регистрация нового пользователя | Система управления TopFitnesBraslet</title>
</head>
<body class="bg-contrast-lower min-height-100vh flex flex-center padding-md">
    <div class="bg container max-width-xxs padding-lg radius-md shadow-sm">
      <form class="sign-up-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div class="text-component text-center margin-bottom-sm">
          <h2>Регистрация</h2>
          <p>У вас уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
        </div>

        <div class="margin-bottom-sm">
          <label class="form-label margin-bottom-xxxs" for="name">Имя</label>
          <input class="form-control width-100%" type="text" name="name" id="name">
          @error('name')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
        </div>

        <div class="margin-bottom-sm">
          <label class="form-label margin-bottom-xxxs" for="email">Email</label>
          <input class="form-control width-100%" type="email" name="email" id="email" placeholder="email@myemail.com">
          @error('email')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
        </div>

        <div class="margin-bottom-md">
          <label class="form-label margin-bottom-xxxs" for="password">Пароль</label>
          <input class="form-control width-100%" type="password" name="password" id="password">
          @error('password')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
          <p class="text-xs color-contrast-medium margin-top-xxs">Минимальная длина 6 символов</p>
        </div>

        <div class="margin-bottom-md">
          <label class="form-label margin-bottom-xxxs" for="password-confirm">Повторите пароль</label>
          <input class="form-control width-100%" type="password" name="password_confirmation" id="password-confirm" autocomplete="new-password">

        </div>


        <div class="margin-bottom-md">
          <label class="form-label margin-bottom-xxxs" for="password-confirm">Повторите пароль</label>
          <input class="form-control width-100%" type="password" name="password_confirmation" id="password-confirm" autocomplete="new-password">
        </div>

        <!-- input avatar -->
        <div class="margin-bottom-sm">
            <div class="file-upload inline-block">
            <label for="avatar" class="file-upload__label btn btn--primary">
              <span class="flex items-center">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="2"><path  stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path><path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path><path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path></g></svg>

                <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить аватар</span>
              </span>
            </label>

            <input type="file" class="file-upload__input" name="avatar" id="avatar">
          </div>
            @error('avatar')
            <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
            @enderror
          </div>


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