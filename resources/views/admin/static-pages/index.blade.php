@extends('admin.layouts.base')

@section('content')
<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('admin_static_pages') }}
  </div>
<div class="bg radius-md padding-md shadow-xs col-12">
  <a class="btn btn--success text-sm" href="{{ route('static-pages.create') }}">Добавить</a>
@if (count($staticPages))
<div class="tbl text-sm">

<table class="tbl__table border-bottom" aria-label="Таблица страниц">
    <thead class="tbl__header border-bottom">
        <tr class="tbl__row">
          <th class="tbl__cell text-left" scope="col">
            <span class="font-semibold">ID</span>
          </th>

          <th class="tbl__cell text-left" scope="col">
            <span class="font-semibold">Название/slug/logo</span>
          </th>

          <th class="tbl__cell text-right" scope="col">
            <span class="font-semibold">Действия</span>
          </th>
        </tr>
    </thead>


    <tbody class="tbl__body">
@foreach ($staticPages as $item)
    <tr class="tbl__row @if (! $item->published) font-italic @endif">
        <td class="tbl__cell" role="cell">
            {{ $item->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
              @if ($item->getFirstMediaUrl('covers'))
                <figure class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                <img class="block width-100% height-100% object-cover" src="{{ $item->getFirstMediaUrl('covers') }}">
                </figure>
              @endif
                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $item->name }}</p>
                <p class="color-contrast-medium">{{ $item->slug }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('static-pages.edit', ['static_page' => $item]) }}">
                Изменить
              </a>

              <button class="btn btn--accent btn--sm" aria-controls="dialog-{{ $loop->index }}">Удалить</button>

          </div>

        </td>
    </tr>

    <div id="dialog-{{ $loop->index }}" class="dialog js-dialog" data-animation="on">
      <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-{{ $loop->index }}" aria-describedby="dialog-description-{{ $loop->index }}">
        <div class="text-component">
          <h4 id="dialog-title-{{ $loop->index }}">Вы уверены, что хотите удалить статью {{ $item->name }}?</h4>
          <p id="dialog-description-{{ $loop->index }}">После подтверждения статья будет удалена <mark>безвозвратно</mark>!!!.</p>
        </div>

        <footer class="margin-top-md">
          <div class="flex justify-end gap-xs flex-wrap">
            <button class="btn btn--subtle js-dialog__close">Отмена</button>
            <form method="manual" action="{{ route('static-pages.destroy', ['static_page' => $item]) }}">
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
