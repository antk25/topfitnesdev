@extends('admin.layouts.base')

@section('content')
<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('htmlcomponents') }}
  </div>

<div class="grid gap-sm">
  <!-- basic table -->
  <div class="bg radius-md padding-md shadow-xs col-12">
  <a class="btn btn--success text-sm" href="{{ route('htmlcomponents.create') }}">Добавить компонент</a>

@if (count($htmlcomponents))
<div class="tbl text-sm">

<table class="tbl__table border-bottom" aria-label="Таблица брендов">
    <thead class="tbl__header border-bottom">
        <tr class="tbl__row">
          <th class="tbl__cell text-left" scope="col">
            <span class="font-semibold">ID</span>
          </th>

          <th class="tbl__cell text-left" scope="col">
            <span class="font-semibold">Название</span>
          </th>

          <th class="tbl__cell text-right" scope="col">
            <span class="font-semibold">Действия</span>
          </th>
        </tr>
    </thead>


    <tbody class="tbl__body">
@foreach ($htmlcomponents as $htmlcomponent)
    <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $htmlcomponent->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $htmlcomponent->name }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell text-right" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('htmlcomponents.edit', ['htmlcomponent' => $htmlcomponent->id]) }}">
                Изменить
              </a>

              <form method="POST" action="{{ route('htmlcomponents.destroy', ['htmlcomponent' => $htmlcomponent->id]) }}">
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
      {{ $htmlcomponents->links() }}
    </div>
  </div>

@endsection