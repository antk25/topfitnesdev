@extends('admin.layouts.base')

@section('content')
<div class="text-component">
  <h1 class="text-lg">Оценки</h1>
  <div class="bg radius-md padding-md shadow-xs">
    <p class="color-contrast-medium margin-bottom-sm">Таблица оценок</p>
  @if (count($grades))
<div class="tbl text-sm">

<table class="tbl__table border-bottom border-2" aria-label="Table Example">
    <thead class="tbl__header border-bottom border-2">
    <tr class="tbl__row">
        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">ID</span>
        </th>

        <th class="tbl__cell text-left" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Оценка</span>
        </th>

        <th class="tbl__cell text-right" scope="col">
        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Действия</span>
        </th>
    </tr>
    </thead>

    <tbody class="tbl__body">
@foreach ($grades as $grade)
    <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $grade->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $grade->name }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell text-right" role="cell">

          <div class="grid gap-sm">
            <div class="col-6@md">
              <a class="btn btn--primary text-sm" href="{{ route('grades.edit', ['grade' => $grade->id]) }}">
                Изменить
              </a>
            </div>

            <div class="col-6@md">

              <button class="btn btn--accent text-sm" aria-controls="dialog-{{ $loop->index }}">Удалить</button>


            </div>

          </div>

        </td>
    </tr>
    <div id="dialog-{{ $loop->index }}" class="dialog js-dialog" data-animation="on">
      <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-{{ $loop->index }}" aria-describedby="dialog-description-{{ $loop->index }}">
        <div class="text-component">
          <h4 id="dialog-title-{{ $loop->index }}">Вы уверены, что хотите удалить оценку {{ $grade->name }}?</h4>
          <p id="dialog-description-{{ $loop->index }}">После подтверждения оценка будет удалена <mark>безвозвратно</mark>!!!.</p>
        </div>

        <footer class="margin-top-md">
          <div class="flex justify-end gap-xs flex-wrap">
            <button class="btn btn--subtle js-dialog__close">Отмена</button>
            <form method="POST" action="{{ route('grades.destroy', ['grade' => $grade->id]) }}">
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
@else
<div class="alert alert--warning alert--is-visible padding-sm radius-md js-alert" role="alert">
<div class="flex items-center">
  <svg class="icon icon--sm alert__icon margin-right-sm" viewBox="0 0 24 24" aria-hidden="true">
    <path d="M12,0C5.383,0,0,5.383,0,12s5.383,12,12,12s12-5.383,12-12S18.617,0,12,0z M13.645,5L13,14h-2l-0.608-9 H13.645z M12,20c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C14,19.105,13.105,20,12,20z"></path>
  </svg>

  <p class="text-sm"><strong>Оценок нет</strong></p>
</div>

<div class="flex margin-top-xxxs">
  <!-- 👇 spacer - occupy same space of alert__icon -->
  <svg class="icon icon--sm margin-right-sm" aria-hidden="true"></svg>

  <p class="text-sm opacity-70%">Вы еще не добавили ни одного рейтинга.</p>
</div>
</div>
@endif

  </div>

</div>
@endsection