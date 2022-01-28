@extends('admin.layouts.base')

@section('content')
<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
{{ Breadcrumbs::render('admin_ratings') }}
</div>

<div class="grid gap-sm">
  <!-- basic table -->
  <div class="bg radius-md padding-md shadow-xs col-12">
    <a class="btn btn--success text-sm margin-bottom-md" href="{{ route('ratings.create') }}">Создать</a>

    @if (count($ratings))

    <div class="tbl text-sm">
      <table class="tbl__table border-bottom" aria-label="Таблица фитнес-браслетов">
        <thead class="tbl__header border-bottom">
          <tr class="tbl__row">
            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">ID</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Название/slug</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Опубликован</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Дата</span>
            </th>

            <th class="tbl__cell text-left" scope="col">
              <span class="font-semibold">Действия</span>
            </th>
          </tr>
        </thead>

        <tbody class="tbl__body">
          @foreach ($ratings as $rating)
        <tr class="tbl__row @if (! $rating->published) font-italic @endif {{ $rating->trashed() ? 'color-contrast-lower' : '' }}">
        <td class="tbl__cell" role="cell">
            {{ $rating->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
              @if ($rating->getFirstMediaUrl('covers'))
                <figure class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                <img class="block width-100% height-100% object-cover" src="{{ $rating->getFirstMediaUrl('covers') }}">
                </figure>
              @endif
                <div class="line-height-xs">
                <p class="margin-bottom-xxxxs">{{ $rating->name }}</p>
                <p class="color-contrast-medium">{{ $rating->slug }}</p>
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">
          @if ($rating->published)
         <span class="color-success text-bold">да</span>
         @else
         <span class="color-contrast-low">нет</span>
        @endif
      </td>

        <td class="tbl__cell" role="cell">{{ $rating->created_at->diffForHumans() }}</td>


        <td class="tbl__cell" role="cell">

          <div class="flex flex-wrap gap-xs">
            @if (! $rating->trashed())
              <a class="btn btn--primary btn--sm" href="{{ route('ratings.edit', ['rating' => $rating->id]) }}">
                Изменить
              </a>

              <form method="POST" action="{{ route('ratings.destroy', ['rating' => $rating->id]) }}">
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
              <a class="btn btn--primary btn--sm" href="{{ route('ratings.restore', ['rating' => $rating->id]) }}">
                Восстановить
              </a>

              <button class="btn btn--accent btn--sm" aria-controls="dialog-{{ $loop->index }}">
               Уничтожить
              </button>


              @endif

              @if ($rating->published)

              <a class="btn btn--primary btn--sm" href="{{ route('ratings.publish', ['rating' => $rating->id]) }}">
               Черновик
              </a>

              @else

              <a class="btn btn--primary btn--sm" href="{{ route('ratings.publish', ['rating' => $rating->id]) }}">
                Опубликовать
              </a>

              @endif
          </div>

        </td>
    </tr>
    <div id="dialog-{{ $loop->index }}" class="dialog js-dialog" data-animation="on">
      <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-{{ $loop->index }}" aria-describedby="dialog-description-{{ $loop->index }}">
        <div class="text-component">
          <h4 id="dialog-title-{{ $loop->index }}">Вы уверены, что хотите удалить статью {{ $rating->name }}?</h4>
          <p id="dialog-description-{{ $loop->index }}">После подтверждения статья будет удалена <mark>безвозвратно</mark>!!!.</p>
        </div>

        <footer class="margin-top-md">
          <div class="flex justify-end gap-xs flex-wrap">
            <button class="btn btn--subtle js-dialog__close">Отмена</button>
            <form method="rating" action="{{ route('ratings.destroy', ['rating' => $rating->id]) }}">
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
    {{ $ratings->links() }}
  </div>
</div>

@endsection
