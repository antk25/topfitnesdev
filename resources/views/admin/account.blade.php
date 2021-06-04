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
        <div class="user-cell ">
            <div class="user-cell__body">
              @if (Auth::user()->avatar)
              <figure aria-hidden="true">
                <img class="user-cell__img" src="{{ Auth::user()->avatar }}">
              </figure>
              @else
              <figure aria-hidden="true">
                <img class="user-cell__img" src="/storage/theme/comments-placeholder.svg">
              </figure>
              @endif
              <div class="user-cell__content text-component line-height-sm v-space-xxs">
                <p><a href="#0" class="color-contrast-high"><strong>{{ Auth::user()->name }}</strong></a></p>
                <p class="color-contrast-medium">Lorem ipsum dolor sit</p>
              </div>
            </div>
          
            <div class="user-cell__cta">
              <a href="{{ route('logout.user') }}" class='btn btn--subtle' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
            </div>
            <form id="logout-form" action="{{ route('logout.user') }}" method="POST">
              @csrf
          </form>
          </div>
    </div>

    <script src="{{ asset("js/scripts.js") }}"></script>
</body>
</html>