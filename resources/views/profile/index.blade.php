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
        <div class="grid">
            <div class="col-8">
                <p>Ваше имя: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                
                <h3>Ваши комментарии</h3>

                @foreach ($user->comments as $comment)
                <div class="margin-y-sm border-sm border-bottom">
                  <div class="color-contrast-medium">Дата: {{ $comment->created_at->diffForHumans() }}</div>
                  <div class="color-contrast-medium">Текст комментария:</div>
                 <p>{{ $comment->comment }}</p>
                 
                 <a href="{{$comment->commentable->getLink()}}#c{{ $comment->id }}">Перейти к комментарию</a>

                </div>
                @endforeach

            </div>
            <div class="col-4">
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </div>
        </div>
    </div>
    
    <script src="{{ asset("js/scripts.js") }}"></script>
</body>
</html>