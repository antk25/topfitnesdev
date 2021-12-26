@extends('admin.layouts.base')

@section('content')
<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('sellers') }}
  </div>


<div class="grid gap-sm">
  <!-- basic table -->
  <div class="bg radius-md padding-md shadow-xs col-12">
    <a class="btn btn--success text-sm margin-bottom-md" href="{{ route('sellers.create') }}">Создать</a>

@if (count($sellers))
<div class="tbl text-sm">

<table class="tbl__table border-bottom border-2" aria-label="Таблица продавцов">
    <thead class="tbl__header border-bottom">
          <tr class="tbl__row">
            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">ID</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Название</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Действия</span>
            </th>
          </tr>
        </thead>

    <tbody class="tbl__body">
@foreach ($sellers as $seller)
    <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $seller->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <p class="margin-bottom-xxxxs">{{ $seller->name }}</p>
            </div>
        </td>

        <td class="tbl__cell text-right" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('sellers.edit', ['seller' => $seller->id]) }}">
                Изменить
              </a>
            <button class="btn btn--accent btn--sm" aria-controls="dialog-{{ $loop->index }}">Удалить</button>

          </div>

        </td>
    </tr>
    <div id="dialog-{{ $loop->index }}" class="dialog js-dialog" data-animation="on">
      <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-{{ $loop->index }}" aria-describedby="dialog-description-{{ $loop->index }}">
        <div class="text-component">
          <h4 id="dialog-title-{{ $loop->index }}">Вы уверены, что хотите удалить продавца {{ $seller->name }}?</h4>
          <p id="dialog-description-{{ $loop->index }}">После подтверждения продавец будет удален <mark>безвозвратно</mark>!!!.</p>
        </div>

        <footer class="margin-top-md">
          <div class="flex justify-end gap-xs flex-wrap">
            <button class="btn btn--subtle js-dialog__close">Отмена</button>
            <form method="POST" action="{{ route('sellers.destroy', ['seller' => $seller->id]) }}">
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
  </div>

@endsection