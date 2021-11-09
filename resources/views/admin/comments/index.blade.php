@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
  <h1 class="text-lg">Комментарии</h1>
</div>

<div class="grid gap-sm">
  <!-- basic table -->
  <div class="bg radius-md padding-md shadow-xs col-12">
  <a class="btn btn--success text-sm" href="{{ route('comments.create') }}">Добавить комментарий</a>


@if (count($comments))
<div class="tbl text-sm">

<table class="tbl__table border-bottom" aria-label="Таблица комментариев">
    <thead class="tbl__header border-bottom">
          <tr class="tbl__row">
            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">ID</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Пользователь</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Страница</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Ответ (id)</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Текст</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Дата</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Действия</span>
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
                  @if ($comment->user_id)
                    {{ $comment->user->name }}<br>
                    <span class="text-sm color-contrast-medium">(id: {{ $comment->user->id }})</span>
                  @else
                    {{ $comment->username }}
                  @endif
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

        <td class="tbl__cell" role="cell">
          @if ($comment->parent_id)
            {{ $comment->parent_id }}
          @else
            --
          @endif
        </td>


        <td class="tbl__cell" width="200px" role="cell">
          {{ Str::limit($comment->comment, 100) }}

        </td>


        <td class="tbl__cell" role="cell">
            {{ $comment->created_at }}
        </td>

        <td class="tbl__cell text-right" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('comments.edit', ['comment' => $comment->id]) }}">
                Изменить
              </a>

              <form method="POST" action="{{ route('comments.destroy', ['comment' => $comment->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--accent btn--sm">Удалить</button>
              </form>

          </div>

        </td>
    </tr>
@endforeach


    </tbody>
</table>
</div>

@endif
  </div>


    <div class="items-center justify-between padding-top-sm">
      {{ $comments->links() }}
    </div>
</div>

@endsection