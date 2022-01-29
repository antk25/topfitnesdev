@extends('admin.layouts.base')

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
{{ Breadcrumbs::render('admin_bracelets') }}
</div>

<div class="grid gap-sm">
  <div class="bg radius-md padding-md shadow-xs col-12">
    <div class="margin-bottom-sm">
      <h5>Импорт данных</h5>
    </div>


    {{-- @livewire('import') --}}

    <form action="{{ route('bracelets.import') }}" method="POST" enctype="multipart/form-data">
     @csrf
     <div class="flex gap-xxs">
     <div class="file-upload">
      <label for="importFile" class="file-upload__label btn btn--primary">
        <span class="flex items-center">
          <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="2"><path  stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path><path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path><path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path></g></svg>

          <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить</span>
        </span>
      </label>

      <input type="file" class="file-upload__input" name="importFile" id="importFile">
      👉
    </div>
     <button class="btn btn--success" type="submit">Импортировать</button>
     </div>
    </form>

    <div class="margin-y-sm">
      <a href="{{ route('bracelets.export') }}" type="button" class="btn btn--subtle">Экспорт &#128640;</a>
    </div>

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
    <a class="btn btn--success text-sm margin-bottom-md" href="{{ route('bracelets.create') }}">Создать</a>
    <a class="btn btn--success text-sm margin-bottom-md" href="{{ route('bracelets.updategrades') }}">Обновить средний рейтинг</a>

    @if (count($bracelets))

    <form action="">
      <div class="flex gap-xxs">
        <div>
          <ul class="flex gap-xs text-sm margin-top-xxs">
            <li>
             <input class="checkbox" type="checkbox" name="selection" value="1" id="selection" @if (request('selection') == 1)
           checked
          @endif>
             <label for="selection">Участвует в подборе</label>
            </li>
            <li>
             <input class="checkbox" type="checkbox" name="published" value="1" id="published" @if (request('published') == 1)
           checked
          @endif>
             <label for="published">Опубликован</label>
            </li>

         </ul>
        </div>

        <div>

          <input class="form-control" type="text" name="name" id="name" @if (request('name'))
            value="{{ request('name') }}" @endif placeholder="Поиск по названию">
        </div>

        <div>
          <button class="btn btn--primary btn--sm" type="submit">Применить фильтр</button>
        </div>

      </div>

    </form>

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
        <tr class="tbl__row {{ $bracelet->trashed() ? 'color-contrast-lower' : '' }}">
        <td class="tbl__cell" role="cell">
            {{ $bracelet->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <figure class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                <img class="block width-100% height-100% object-cover" src="{{ $bracelet->getFirstMediaUrl('thumb') }}">
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
            @if (! $bracelet->trashed())
              <a class="btn btn--primary btn--sm" href="{{ route('bracelets.edit', ['bracelet' => $bracelet->id]) }}">
                Изменить
              </a>

              <form method="POST" action="{{ route('bracelets.destroy', ['bracelet' => $bracelet->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--accent"><svg class="icon" viewBox="0 0 20 20">
                  <title>Remove item</title>

                  <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <line x1="1" y1="5" x2="19" y2="5"></line>
                    <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5"></path>
                    <path d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8"></path>
                  </g>
                </svg></button>
              </form>
              @else
              <a class="btn btn--primary btn--sm" href="{{ route('bracelets.restore', ['bracelet' => $bracelet->id]) }}">
                Восстановить
              </a>

              <button class="btn btn--accent btn--sm" aria-controls="dialog-{{ $loop->index }}">
               Уничтожить
              </button>


              @endif
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
