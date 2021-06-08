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
    <title>Профиль {{ $user->name }}</title>
</head>
<body>
    <div class="container max-width-xxs padding-y-lg">
      <section>
        <div class="container max-width-adaptive-sm">
          <div class="author author--featured">
            @if (Auth::user()->getFirstMediaUrl('avatars', 'thumb'))
            <span class="author__img-wrapper">
              <img src="{{ Auth::user()->getFirstMediaUrl('avatars', 'thumb') }}" alt="{{ $user->name }} - avatar">
            </span>
            @else
            <a title="Загрузить аватар" class="author__img-wrapper" href="{{ route('profile.edit') }}">
              <img src="/storage/theme/comments-placeholder.svg" alt="{{ $user->name }} - avatar">
            </a>
            @endif
          
            <div class="author__content text-component">
              <h2>{{ $user->name }}</h2>
              <p><span class="text-bold">Email:</span> {{ $user->email }}</p>
              @if ($user->about)
              <p>{{ $user->about }}</p>
              @endif
            </div>

            <div class="btns gap-xs">
              <a class="btns__btn btn--sm" href="{{ route('profile.edit') }}">
                  Редактировать профиль
                </a>
              <a class="btns__btn btn--sm" href="{{ route('profile.password') }}">
                  Изменить пароль 
              </a>
              <a class="btns__btn btn--sm" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </div>
        </div>
      </section>

        <section class="comments comments--no-profile-img margin-top-md">
          <div class="margin-bottom-md">
            <div class="flex gap-sm flex-column flex-row@md justify-between items-center@md">
              <div>
                <h3 class="text-md">Ваши комментарии</h3>
              </div>
            </div>
          </div>
        
          <ul class="margin-bottom-md">
        @foreach ($user->comments as $comment)
            <li class="comments__comment">
              <div class="comments__content margin-top-xxxs">
                <div class="text-component text-sm v-space-xs line-height-sm read-more js-read-more" data-characters="200" data-btn-class="comments__readmore-btn js-tab-focus">
                  <p>{{ $comment->comment }}</p>
                </div>
        
                <div class="margin-top-xs text-sm">
                  <div class="flex gap-xxs items-center">
          
                    <a href="{{$comment->commentable->getLink()}}#c{{ $comment->id }}" class="reset comments__label-btn js-tab-focus">Перейти к комментарию</a>
          
                    <span class="comments__inline-divider" aria-hidden="true"></span>
        
                    <time class="comments__time" aria-label="{{ $comment->created_at->diffForHumans() }}">{{ $comment->created_at->diffForHumans() }}</time>
                  </div>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </section>
    </div>
    
    <script src="{{ asset("js/scripts.js") }}"></script>
</body>
</html>