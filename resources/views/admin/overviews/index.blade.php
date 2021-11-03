@extends('admin.layouts.base')

@section('content')

<div class="margin-bottom-md">
  <h1 class="text-lg">Обзоры товаров</h1>
</div>

<div class="grid gap-sm">
  <!-- basic table -->
  <div class="bg radius-md padding-md shadow-xs col-12">
    <a class="btn btn--success text-sm margin-bottom-md" href="{{ route('overviews.create') }}">Создать</a>

    @if (count($overviews))

    <div class="tbl text-sm">
      <table class="tbl__table border-bottom" aria-label="Таблица обзоров">
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
          @foreach ($overviews as $overview)
        <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $overview->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $overview->name }}</p>
                <p class="color-contrast-medium">{{ $overview->slug }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">{{ $overview->published }}</td>

        <td class="tbl__cell" role="cell">{{ $overview->created_at->diffForHumans() }}</td>


        <td class="tbl__cell" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('overviews.edit', ['overview' => $overview->id]) }}">
                Изменить
              </a>


              <button class="btn btn--accent btn--sm" aria-controls="dialog-{{ $loop->index }}">Удалить</button>

          </div>

        </td>
    </tr>
    <div id="dialog-{{ $loop->index }}" class="dialog js-dialog" data-animation="on">
      <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-{{ $loop->index }}" aria-describedby="dialog-description-{{ $loop->index }}">
        <div class="text-component">
          <h4 id="dialog-title-{{ $loop->index }}">Вы уверены, что хотите удалить обзор {{ $overview->name }}?</h4>
          <p id="dialog-description-{{ $loop->index }}">После подтверждения обзор будет удален <mark>безвозвратно</mark>!!!.</p>
        </div>

        <footer class="margin-top-md">
          <div class="flex justify-end gap-xs flex-wrap">
            <button class="btn btn--subtle js-dialog__close">Отмена</button>
            <form method="POST" action="{{ route('overviews.destroy', ['overview' => $overview->id]) }}">
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
    {{ $overviews->links() }}
  </div>
</div>

@endsection