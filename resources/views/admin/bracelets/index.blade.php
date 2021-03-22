@extends('admin.layouts.base')

@section('content')
<div class="text-component">
  <h1 class="text-lg">Браслеты</h1>
  <p class="text-sm color-contrast-medium">This is the main dashboard content.</p>
  <div class="bg radius-md padding-md shadow-xs">
    <p class="color-contrast-medium margin-bottom-sm">Таблица браслетов</p>
  <a class="btn btn--success text-sm" href="{{ route('bracelets.create') }}">Добавить браслет</a>

@if (count($bracelets))
<div class="tbl text-sm">
<form action="" method="GET">
  <div class="grid gap-xxs margin-top-md">
    <div class="col-2@md">
      <div class="search-input search-input--icon-right">
        <input class="search-input__input form-control" type="search" name="filter[name]" id="search-input" placeholder="Поиск по названию..." aria-label="Search">
        <button class="search-input__btn">
          <svg class="icon" viewBox="0 0 24 24"><title>Submit</title><g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor" fill="none" stroke-miterlimit="10"><line x1="22" y1="22" x2="15.656" y2="15.656"></line><circle cx="10" cy="10" r="8"></circle></g></svg>
        </button>
      </div>
    </div>
  </div>
</form>

<table class="tbl__table border-bottom border-2" aria-label="Table Example">
    <thead class="tbl__header border-bottom border-2">
    <tr class="tbl__row">
        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">ID</span>
        </th>

        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Модель</span>
        </th>

        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Бренд</span>
        </th>
        
        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Популярный</span>
        </th>

        <th class="tbl__cell text-right" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Действия</span>
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

        <td class="tbl__cell" role="cell">{{ $bracelet->popular }}</td>

        <td class="tbl__cell" role="cell">
        <span class="inline-block text-sm bg-success bg-opacity-20% color-success-darker radius-full padding-y-xxxs padding-x-xs">
            {{ $bracelet->created_at->diffForHumans() }}
        </span>
        </td>

        <td class="tbl__cell text-right" role="cell">
         
          <div class="grid gap-sm">
            <div class="col-6@md">
              <a class="btn btn--primary text-sm" href="{{ route('bracelets.edit', ['bracelet' => $bracelet->id]) }}">
                Изменить
              </a>
            </div>
            
            <div class="col-6@md">
              <form method="POST" action="{{ route('bracelets.destroy', ['bracelet' => $bracelet->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--accent text-sm">Удалить</button>
              </form>
            </div>
            
          </div>
          
        </td>
    </tr>
@endforeach
    

    </tbody>
</table>
</div>
@else
<div class="alert alert--warning alert--is-visible padding-sm radius-md js-alert" role="alert">
<div class="flex items-center">
  <svg class="icon icon--sm alert__icon margin-right-sm" viewBox="0 0 24 24" aria-hidden="true">
    <path d="M12,0C5.383,0,0,5.383,0,12s5.383,12,12,12s12-5.383,12-12S18.617,0,12,0z M13.645,5L13,14h-2l-0.608-9 H13.645z M12,20c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C14,19.105,13.105,20,12,20z"></path>
  </svg>

  <p class="text-sm"><strong>Браслетов нет</strong></p>
</div>

<div class="flex margin-top-xxxs">
  <!-- 👇 spacer - occupy same space of alert__icon -->
  <svg class="icon icon--sm margin-right-sm" aria-hidden="true"></svg>

  <p class="text-sm opacity-70%">Вы еще не добавили ни одного браслета.</p>
</div>
</div>
@endif
<div class="margin-y-md">
  <a href="{{ route('bracelets.updategrades') }}">Обновить средний рейтинг браслетов</a>
</div>
    <div class="items-center justify-between padding-top-sm">
      {{ $bracelets->links() }}
    </div>
    </div>
  </div>

</div>
@endsection 