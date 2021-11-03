@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
  <h1 class="text-lg">Бренды</h1>
</div>

<div class="grid gap-sm">
  <!-- basic table -->
  <div class="bg radius-md padding-md shadow-xs col-12">
  <a class="btn btn--success text-sm" href="{{ route('brands.create') }}">Добавить бренд</a>

@if (count($brands))
<div class="tbl text-sm">

<table class="tbl__table border-bottom" aria-label="Таблица брендов">
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
@foreach ($brands as $brand)
    <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $brand->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $brand->name }}</p>
                <p class="color-contrast-medium">{{ $brand->slug }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell text-right" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('brands.edit', ['brand' => $brand->id]) }}">
                Изменить
              </a>

              <form method="brand" action="{{ route('brands.destroy', ['brand' => $brand->id]) }}">
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
      {{ $brands->links() }}
    </div>
  </div>

@endsection