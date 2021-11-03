@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
  <h1 class="text-lg">Браслеты</h1>
</div>

<div class="grid gap-sm">
  <!-- basic table -->
  <div class="bg radius-md padding-md shadow-xs col-12">
    <a class="btn btn--success text-sm margin-bottom-md" href="{{ route('bracelets.create') }}">Создать</a>
    <a class="btn btn--success text-sm margin-bottom-md" href="{{ route('bracelets.updategrades') }}">Обновить средний рейтинг</a>


    @if (count($bracelets))

    <div class="tbl text-sm">
      <table class="tbl__table border-bottom" aria-label="Таблица фитнес-браслетов">
        <thead class="tbl__header border-bottom">
          <tr class="tbl__row">
            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">ID</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Модель</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Опубликован</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">В подборе</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Действия</span>
            </th>
          </tr>
        </thead>

        <tbody class="tbl__body">
          @foreach ($bracelets as $bracelet)
        <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $bracelet->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <figure class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                <img class="block width-100% height-100% object-cover" src="{{ $bracelet->getFirstMediaUrl('bracelet') }}">
                </figure>

                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $bracelet->name }}</p>
                <p class="color-contrast-medium">{{ $bracelet->brands }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">{{ $bracelet->published }}</td>

        <td class="tbl__cell" role="cell">{{ $bracelet->selection }}</td>


        <td class="tbl__cell" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('bracelets.edit', ['bracelet' => $bracelet->id]) }}">
                Изменить
              </a>


              <button class="btn btn--accent btn--sm" aria-controls="dialog-{{ $loop->index }}">Удалить</button>

          </div>

        </td>
    </tr>
    <div id="dialog-{{ $loop->index }}" class="dialog js-dialog" data-animation="on">
      <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-{{ $loop->index }}" aria-describedby="dialog-description-{{ $loop->index }}">
        <div class="text-component">
          <h4 id="dialog-title-{{ $loop->index }}">Вы уверены, что хотите удалить браслет {{ $bracelet->name }}?</h4>
          <p id="dialog-description-{{ $loop->index }}">После подтверждения браслет будет удален <mark>безвозвратно</mark>!!!.</p>
        </div>

        <footer class="margin-top-md">
          <div class="flex justify-end gap-xs flex-wrap">
            <button class="btn btn--subtle js-dialog__close">Отмена</button>
            <form method="POST" action="{{ route('bracelets.destroy', ['bracelet' => $bracelet->id]) }}">
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
    {{ $bracelets->links() }}
  </div>
</div>

@endsection