@extends('admin.layouts.base')

@section('content')
<div class="text-component">
  <h1 class="text-lg">Комментарии</h1>
  <p class="text-sm color-contrast-medium">Все комментарии на сайте.</p>
  <div class="bg radius-md padding-md shadow-xs">
    <p class="color-contrast-medium margin-bottom-sm">Таблица комментариев</p>
    <a class="btn btn--success text-sm" href="{{ route('comments.create') }}">Добавить комментарий</a>
@if (count($comments))
<div class="tbl text-sm">
<form action="" method="GET">
  <div class="grid gap-xxs margin-top-md">
    <div class="col-2@md">
      <div class="search-input search-input--icon-right">
        <input class="search-input__input form-control" type="search" name="filter[name]" id="search-input" placeholder="Поиск по заголовку..." aria-label="Search">
        <button class="search-input__btn">
          <svg class="icon" viewBox="0 0 24 24"><title>Submit</title><g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor" fill="none" stroke-miterlimit="10"><line x1="22" y1="22" x2="15.656" y2="15.656"></line><circle cx="10" cy="10" r="8"></circle></g></svg>
        </button>
      </div>
    </div>
  </div>
</form>

<table class="tbl__table border-bottom border-2" aria-label="Table Example">
    <thead class="tbl__header border-bottom border-2">
    <tr class="tbl__row">
        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">ID</span>
        </th>

        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Пользователь</span>
        </th>

        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Модель</span>
        </th>
        
        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Текст</span>
        </th>
        
        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Дата</span>
        </th>

        <th class="tbl__cell text-right" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Действия</span>
        </th>
    </tr>
    </thead>
    
    <tbody class="tbl__body">
@foreach ($comments as $comment)
    <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $comment->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $comment->user->name }}
                <p class="color-contrast-medium">{{ $comment->user->email }}</p>
                </p>
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">
         @if ($comment->commentable_type == 'App\Models\Post') 
         Статья блога<br>
         
         <a href="/admin/posts/{{ $comment->commentable->id }}/edit">{{ $comment->commentable->name }}</a>
         
         @elseif ($comment->commentable_type == 'App\Models\Rating')
         Рейтинг браслетов<br>
         
         <a href="/admin/ratings/{{ $comment->commentable->id }}/edit">{{ $comment->commentable->name }}</a>

         @endif
        </td>


        <td class="tbl__cell" width="200px" role="cell">
          {{ Str::limit($comment->comment, 100) }}

        </td>
        

        <td class="tbl__cell" role="cell">
        <span class="inline-block text-sm bg-success bg-opacity-20% color-success-darker radius-full padding-y-xxxs padding-x-xs">
            {{ $comment->created_at->diffForHumans() }}
        </span>
        </td>

        <td class="tbl__cell text-right" role="cell">
         
          <div class="grid gap-sm">
            <div class="col-6@md">
              <a class="btn btn--primary text-sm" href="{{ route('comments.edit', ['comment' => $comment->id]) }}">
                Изменить
              </a>
            </div>
            
            <div class="col-6@md">
              <form method="POST" action="{{ route('comments.destroy', ['comment' => $comment->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--accent text-sm">Удалить</button>
              </form>
            </div>
            
          </div>
          
        </td>
    </tr>
@endforeach
    

    </tbody>
</table>
</div>
@else
<div class="alert alert--warning alert--is-visible padding-sm radius-md js-alert" role="alert">
<div class="flex items-center">
  <svg class="icon icon--sm alert__icon margin-right-sm" viewBox="0 0 24 24" aria-hidden="true">
    <path d="M12,0C5.383,0,0,5.383,0,12s5.383,12,12,12s12-5.383,12-12S18.617,0,12,0z M13.645,5L13,14h-2l-0.608-9 H13.645z M12,20c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C14,19.105,13.105,20,12,20z"></path>
  </svg>

  <p class="text-sm"><strong>Комментариев нет</strong></p>
</div>

<div class="flex margin-top-xxxs">
  <!-- 👇 spacer - occupy same space of alert__icon -->
  <svg class="icon icon--sm margin-right-sm" aria-hidden="true"></svg>

  <p class="text-sm opacity-70%">На сайте нет комментариев</p>
</div>
</div>
@endif
  
  
    <div class="items-center justify-between padding-top-sm">
      {{ $comments->links() }}
    </div>
  </div>

</div>
@endsection 