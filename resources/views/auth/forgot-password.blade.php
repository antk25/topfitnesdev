
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>

    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">

    <title>Восстановление пароля | Система управления TopFitnesBraslet</title>
</head>
<body class="bg-contrast-lower min-height-100vh flex flex-center padding-md">
    <div class="bg container max-width-xxs padding-lg radius-md shadow-sm">
      <form class="sign-up-form" method="POST" action="{{ route('password.request') }}">
        @csrf
        <div class="text-component text-center margin-bottom-md">
          <h1>{{ __('Reset Password') }}</h1>
          <p>Восстановите, используя форму ниже.</p>
        </div>


        @if (session('status'))
          <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
                </svg>

                <p class="text-sm">{{ session('status') }}</p>
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