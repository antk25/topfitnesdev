@extends('admin.layouts.base')

@section('content')
<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
  {{ Breadcrumbs::render('brands') }}
  </div>

<div class="grid gap-sm">
  <div class="bg radius-md padding-md shadow-xs col-12">
    <div class="margin-bottom-sm">
      <h5>Импорт данных</h5>
    </div>

    <form action="{{ route('brands.import') }}" method="POST" enctype="multipart/form-data">
     @csrf
     <div class="file-upload inline-block">
      <label for="importFile" class="file-upload__label btn btn--primary">
        <span class="flex items-center">
          <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="2"><path  stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path><path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path><path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path></g></svg>

          <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить</span>
        </span>
      </label>

      <input type="file" class="file-upload__input" name="importFile" id="importFile">
    </div>
     <button class="btn" type="submit">Импортировать</button>
    </form>
    @if ($lastfile)
    <div>
      <p>Последние импортированные:</p>
      <a href="/{{ $lastfile }}">Скачать последний импорт</a>
    </div>
    @endif


    @if (isset($errors) && $errors->any())
      @foreach ($errors->all() as $error)

        {{ $error }}

      @endforeach
    @endif


    @if (session()->has('failures'))
     <table>
       <tr>
         <th>Row</th>
         <th>Attribute</th>
         <th>Errors</th>
         <th>Value</th>
       </tr>

       @foreach (session()->get('failures') as $validation)

       <tr>
         <td>{{ $validation->row() }}</td>
         <td>{{ $validation->attribute() }}</td>
         <td>
           <ul>
             @foreach ($validation->errors() as $e)
                 <li>{{ $e }}</li>
             @endforeach
           </ul>
         </td>
         <td>
           {{ $validation->values()[$validation->attribute()] }}
         </td>
       </tr>

       @endforeach
    </table>
    @endif
  </div>
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

              <form method="POST" action="{{ route('brands.destroy', ['brand' => $brand->id]) }}">
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