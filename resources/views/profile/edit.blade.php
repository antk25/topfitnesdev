
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
        <form class="login-form" method="POST" action="{{ route('user-profile-information.update') }}">
            @csrf
            @method('PUT')
            <div class="text-component text-center margin-bottom-sm">
              <h1>Редактирование профиля</h1>
              <p>Измените данные и нажмите обновить профиль.</p>
            </div>

            <div class="margin-bottom-sm">
                <label class="form-label margin-bottom-xxxs" for="name">{{ __('Name') }}</label>
                <input class="form-control width-100%" type="name" name="name" id="name" value="{{ old('name') ?? auth()->user()->name }}">
                @error('name')
                <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                @enderror
              </div>

            <div class="margin-bottom-sm">
              <label class="form-label margin-bottom-xxxs" for="email">{{ __('Email') }}</label>
              <input class="form-control width-100%" type="email" name="email" id="email" value="{{ old('email') ?? auth()->user()->email }}">
              @error('email')
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