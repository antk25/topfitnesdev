<div>
  @if ($edit == 1)
    <form class="form-template-v3" method="POST" action="{{ route('ratings.update', ['rating' => $rating->id]) }}">
    @csrf
    @method('PUT')
  @else
    <form action="{{ route('ratings.store') }}" method="POST">
   @csrf
  @endif
        <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="name">Название рейтинга</label>
          <input class="form-control width-100%" type="text" name="name" id="name" wire:model="name">
          <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название, menutitle</p>
        </div>

        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="slug">URI (SLUG)</label>
        <input class="form-control width-100%" type="text" name="slug" id="slug" wire:model="slug">
        </div>
      </div>

      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="title">Title</label>
        <input class="form-control width-100%" type="text" name="title" id="title" wire:model="title">
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxs" for="subtitle">Subtitle (h1)</label>
          <input class="form-control width-100%" type="text" name="subtitle" id="subtitle" wire:model="subtitle">
        </div>
        <div class="col-6@md">
          <div class="character-count js-character-count">
            <label class="form-label margin-bottom-xxs" for="textareaName">Description:</label>
            <textarea class="form-control width-100% js-character-count__input" name="description" id="description" maxlength="300" wire:model="description"></textarea>
            <div class="character-count__helper character-count__helper--dynamic text-sm margin-top-xxxs" aria-live="polite" aria-atomic="true">
              Осталось <span class="js-character-count__counter"></span> символов
            </div>
            <div class="character-count__helper character-count__helper--static text-sm margin-top-xxxs">Макс 300 символов</div>
          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="text">Основной контент</label>
            <textarea rows="20" class="form-control width-100%" name="text" wire:model="text"></textarea>
      </div>

        <div class="card">
            <div class="card-header">
                Браслеты
            </div>

            <div class="card-body">
                @foreach ($ratingBracelets as $index => $ratingBracelet)
<div class="grid gap-xxs margin-y-md">
  <div class="col-3@md">
  <div class="select margin-bottom-xxs">
  <select class="select__input form-control" name="ratingBracelets[{{$index}}][bracelet_id]"
          wire:model="ratingBracelets.{{$index}}.bracelet_id"
          class="form-control">
      <option value="">-- Выбрать браслет --</option>
      @foreach ($allBracelets as $bracelet)
          <option value="{{ $bracelet->id }}">
              {{ $bracelet->name }} (Р{{ number_format($bracelet->price, 2) }})
          </option>
      @endforeach
  </select>
    
    <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
  </div>

  <div class="number-input number-input--v2  js-number-input">
    <input class="form-control js-number-input__value " type="number" name="ratingBracelets[{{$index}}][position]" wire:model="ratingBracelets.{{$index}}.position" id="qty-input-2" min="1" max="20" step="1" value="1">
    
    <button class="reset number-input__btn number-input__btn--plus js-number-input__btn" aria-label="Increase Number" type="button">
      <svg class="icon" viewBox="0 0 12 12" aria-hidden="true"><path d="M11,5H7V1A1,1,0,0,0,5,1V5H1A1,1,0,0,0,1,7H5v4a1,1,0,0,0,2,0V7h4a1,1,0,0,0,0-2Z" /></svg>
    </button>
  
    <button class="reset number-input__btn number-input__btn--minus js-number-input__btn" aria-label="Decrease Number" type="button">
      <svg class="icon" viewBox="0 0 12 12" aria-hidden="true"><path d="M11,7H1A1,1,0,0,1,1,5H11a1,1,0,0,1,0,2Z"/></svg>
    </button>
  </div>
  </div>
  
  <div class="col-7@md">
  <textarea class="form-control width-100%" name="ratingBracelets[{{$index}}][text_rating]" wire:model="ratingBracelets.{{$index}}.text_rating" placeholder="Описание выбранного браслета для текущего рейтинга - вставлять с тегами"></textarea>
  </div>

  <div class="col-2@md">
    <button class="btn btn--accent" wire:click.prevent="removeBracelet({{$index}})">Удалить</button>
  </div>
  
  </div>
@endforeach

<button class="btn btn--sm btn--success" wire:click.prevent="addBracelet">+ Добавить браслет</button>
            </div>
        </div>
        <div class="margin-y-lg">
          @if ($edit == 1)
            <button class="btn btn--primary" aria-controls="dialog-1">Обновить</button>

              <div id="dialog-1" class="dialog js-dialog" data-animation="on">
                <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-1" aria-describedby="dialog-description-1">
                  <div class="text-component">
                    <h4 id="dialog-title-1">Вы уверены, что хотите применить изменения?</h4>
                    <p id="dialog-description-1">Описания и позиции всех браслетов, которые были удалены из списка будут стерты!.</p>
                  </div>

                  <footer class="margin-top-md">
                    <div class="flex justify-end gap-xs flex-wrap">
                      <button class="btn btn--subtle js-dialog__close">Отмена</button>
                      <button class="btn btn--accent" type="submit">Применить</button>
                    </div>
                  </footer>
                </div>
              </div>
          @else
            <button class="btn btn--primary" type="submit">Сохранить</button>
          @endif
        </div>
    </form>


</div>
