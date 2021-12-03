@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
  <h1 class="text-lg">Статьи-сравнения</h1>
</div>
<div class="bg radius-md padding-md shadow-xs col-12">
  <a class="btn btn--success text-sm" href="{{ route('comparisons.create') }}">Добавить статью</a>
@if (count($comparisons))
<div class="tbl text-sm">

<table class="tbl__table border-bottom" aria-label="Таблица сравнений">
    <thead class="tbl__header border-bottom">
        <tr class="tbl__row">
          <th class="tbl__cell text-left" scope="col">
            <span class="font-semibold">ID</span>
          </th>

          <th class="tbl__cell text-left" scope="col">
            <span class="font-semibold">Название/slug/logo</span>
          </th>

          <th class="tbl__cell text-left" scope="col">
            <span class="font-semibold">Сравниваемые браслеты</span>
          </th>

          <th class="tbl__cell text-right" scope="col">
            <span class="font-semibold">Действия</span>
          </th>
        </tr>
    </thead>


    <tbody class="tbl__body">
@foreach ($comparisons as $item)
    <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $item->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $item->name }}</p>
                <p class="color-contrast-medium">{{ $item->slug }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">
          @foreach ($item->bracelets as $bracelet)
           {{ $bracelet->name }}
           @if (! $loop->last) <br>VS<br> @endif
          @endforeach
        </td>

        <td class="tbl__cell text-right" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('comparisons.edit', ['comparison' => $item->id]) }}">
                Изменить
              </a>

              <form method="POST" action="{{ route('comparisons.destroy', ['comparison' => $item->id]) }}">
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
      {{ $comparisons->links() }}
    </div>
  </div>
@endsection