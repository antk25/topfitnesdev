@extends('admin.layouts.base')

@section('content')

<div class="margin-bottom-md">
  <h1 class="text-lg">Статьи</h1>
</div>

<div class="grid gap-sm">
  <!-- basic table -->
  <div class="bg radius-md padding-md shadow-xs col-12">
    <a class="btn btn--success text-sm margin-bottom-md" href="{{ route('posts.create') }}">Создать</a>

    @if (count($posts))

    <div class="tbl text-sm">
      <table class="tbl__table border-bottom" aria-label="Таблица статей">
        <thead class="tbl__header border-bottom">
          <tr class="tbl__row">
            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">ID</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Название/slug</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Опубликован</span>
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
          @foreach ($posts as $post)
        <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $post->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
              @if ($post->getFirstMediaUrl('images'))
                <figure class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                <img class="block width-100% height-100% object-cover" src="{{ $post->getFirstMediaUrl('images') }}">
                </figure>
              @endif
                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $post->name }}</p>
                <p class="color-contrast-medium">{{ $post->slug }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">{{ $post->published }}</td>

        <td class="tbl__cell" role="cell">{{ $post->created_at->diffForHumans() }}</td>


        <td class="tbl__cell" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('posts.edit', ['post' => $post->id]) }}">
                Изменить
              </a>


              <button class="btn btn--accent btn--sm" aria-controls="dialog-{{ $loop->index }}">Удалить</button>

          </div>

        </td>
    </tr>
    <div id="dialog-{{ $loop->index }}" class="dialog js-dialog" data-animation="on">
      <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-{{ $loop->index }}" aria-describedby="dialog-description-{{ $loop->index }}">
        <div class="text-component">
          <h4 id="dialog-title-{{ $loop->index }}">Вы уверены, что хотите удалить статью {{ $post->name }}?</h4>
          <p id="dialog-description-{{ $loop->index }}">После подтверждения статья будет удалена <mark>безвозвратно</mark>!!!.</p>
        </div>

        <footer class="margin-top-md">
          <div class="flex justify-end gap-xs flex-wrap">
            <button class="btn btn--subtle js-dialog__close">Отмена</button>
            <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn--accent">Удалить</button>
            </form>
          </div>
        </footer>
      </div>
    </div>
@endforeach

        </tbody>
      </table>
    </div>
    @endif
  </div>


  <div class="items-center justify-between padding-top-sm">
    {{ $posts->links() }}
  </div>
</div>

@endsection