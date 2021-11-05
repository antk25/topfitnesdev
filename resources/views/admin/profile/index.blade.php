
@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
  <h1 class="text-lg">Настройки профиля</h1>
</div>


<div class="bg radius-md shadow-xs">
  <div class="padding-md">
    <div class="author ">
      <a href="#0" class="author__img-wrapper">
        @if (Auth::user()->getFirstMediaUrl('avatars', 'thumb'))
        <img src="{{ Auth::user()->getFirstMediaUrl('avatars', 'thumb') }}" alt="{{ $user->name }} - avatar">
        @else
        <img src="/storage/theme/comments-placeholder.svg">
        @endif
      </a>

      <div class="author__content text-component text-space-y-xxs">
        <h4>{{ $user->name }}</h4>
        @if ($user->about)
              <p class="color-contrast-medium">{{ $user->about }}</p>
        @endif
        <p class="text-sm"><a href="{{ route('admin.profile.edit') }}">Редактировать профиль</a> <a href="{{ route('admin.profile.password') }}">Изменить пароль</a></p>
        <a class="btns__btn btn--sm" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
      </div>
    </div>
  </div>

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

@endsection