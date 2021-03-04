@extends('admin.layouts.base')

@section('content')
<div class="text-component">
  <h1 class="text-lg">Статьи</h1>
  <p class="text-sm color-contrast-medium">Все статьи блога.</p>
  <div class="bg radius-md padding-md shadow-xs">
    <p class="color-contrast-medium margin-bottom-sm">Таблица статей</p>
    <a class="btn btn--success text-sm" href="{{ route('posts.create') }}">Добавить статью</a>
@if (count($posts))
<div class="tbl text-sm">
<table class="tbl__table border-bottom border-2" aria-label="Table Example">
    <thead class="tbl__header border-bottom border-2">
    <tr class="tbl__row">
        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">ID</span>
        </th>

        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Название</span>
        </th>

        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Slug</span>
        </th>
        
        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Опубликован</span>
        </th>

        <th class="tbl__cell text-right" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Действия</span>
        </th>
    </tr>
    </thead>
    
    <tbody class="tbl__body">
@foreach ($posts as $post)
    <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $post->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <figure class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                <img class="block width-100% height-100% object-cover" src="{{ $post->getFirstMediaUrl('images') }}" alt="Author picture">
                </figure>

                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $post->name }}</p>
                <p class="color-contrast-medium">{{ $post->slug }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">{{ $post->slug }}</td>

        <td class="tbl__cell" role="cell">
        <span class="inline-block text-sm bg-success bg-opacity-20% color-success-darker radius-full padding-y-xxxs padding-x-xs">
            {{ $post->created_at->diffForHumans() }}
        </span>
        </td>

        <td class="tbl__cell text-right" role="cell">
         
          <div class="grid gap-sm">
            <div class="col-6@md">
              <a class="btn btn--primary text-sm" href="{{ route('posts.edit', ['post' => $post->id]) }}">
                Изменить
              </a>
            </div>
            
            <div class="col-6@md">
              <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
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

  <p class="text-sm"><strong>Статей нет</strong></p>
</div>

<div class="flex margin-top-xxxs">
  <!-- 👇 spacer - occupy same space of alert__icon -->
  <svg class="icon icon--sm margin-right-sm" aria-hidden="true"></svg>

  <p class="text-sm opacity-70%">Вы еще не добавили ни одной статьи.</p>
</div>
</div>
@endif
  
  
    <div class="items-center justify-between padding-top-sm">
      {{ $posts->links() }}
    </div>
  </div>

</div>
@endsection 