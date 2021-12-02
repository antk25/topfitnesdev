@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
  <h1 class="text-lg">Характеристики - значения</h1>
</div>


<div class="grid gap-sm">

  <div class="bg radius-md padding-md shadow-xs col-12">
    <div class="margin-bottom-sm">
      <h5>Импорт данных</h5>
    </div>


    {{-- @livewire('import') --}}

    <form action="{{ route('specs.import') }}" method="POST" enctype="multipart/form-data">
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
    <a class="btn btn--success text-sm margin-bottom-md" href="{{ route('specs.create') }}">Создать</a>

@if (count($specs))
<div class="tbl text-sm">

<table class="tbl__table border-bottom border-2" aria-label="Таблица характеристик">
    <thead class="tbl__header border-bottom">
          <tr class="tbl__row">
            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">ID</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Название</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Значения</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Действия</span>
            </th>
          </tr>
        </thead>

    <tbody class="tbl__body">
@foreach ($specs as $spec)
    <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $spec->id }}
        </td>

        <td class="tbl__cell" role="cell">
              {{ $spec->name }}
        </td>

        <td class="tbl__cell" role="cell">
              @foreach ($spec->value as $key => $value)
                @if(! $loop->last) {{ $key }}, @else {{ $key }} @endif
              @endforeach
        </td>

        <td class="tbl__cell text-right" role="cell">

          <div class="flex flex-wrap gap-xs">
              <a class="btn btn--primary btn--sm" href="{{ route('specs.edit', ['spec' => $spec->id]) }}">
                Изменить
              </a>
            <button class="btn btn--accent btn--sm" aria-controls="dialog-{{ $loop->index }}">Удалить</button>

          </div>

        </td>
    </tr>
    <div id="dialog-{{ $loop->index }}" class="dialog js-dialog" data-animation="on">
      <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-{{ $loop->index }}" aria-describedby="dialog-description-{{ $loop->index }}">
        <div class="text-component">
          <h4 id="dialog-title-{{ $loop->index }}">Вы уверены, что хотите удалить продавца {{ $spec->name }}?</h4>
          <p id="dialog-description-{{ $loop->index }}">После подтверждения продавец будет удален <mark>безвозвратно</mark>!!!.</p>
        </div>

        <footer class="margin-top-md">
          <div class="flex justify-end gap-xs flex-wrap">
            <button class="btn btn--subtle js-dialog__close">Отмена</button>
            <form method="POST" action="{{ route('specs.destroy', ['spec' => $spec->id]) }}">
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