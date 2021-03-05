
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
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
      <form class="sign-up-form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="text-component text-center margin-bottom-md">
          <h1>{{ __('Reset Password') }}</h1>
          <p>Восстановите, используя форму ниже.</p>
        </div>
      
        <div class="margin-bottom-sm">
          <label class="form-label margin-bottom-xxxs" for="email">{{ __('E-Mail Address') }}</label>
          <input class="form-control width-100%" type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" autofocus required>
          @error('email')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
        </div>

        <div class="margin-bottom-sm">
          <button class="btn btn--primary btn--md width-100%">{{ __('Send Password Reset Link') }}</button>
        </div>
      </form>
    </div>
    
    <script src="{{ asset("js/scripts.js") }}"></script>
</body>
</html>