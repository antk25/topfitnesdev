<div>
    <label class="form-label margin-bottom-xxxs" for="select-this">Модель:</label>

    <div class="select">
        <select class="select__input btn btn--subtle" wire:model="selectedModel" name="select-this" id="selectedModel">
                <option value="">Выбрать модель</option>
                @foreach($model as $k => $v)
                <option value="{{ $v }}">{{ $k }}</option>
            @endforeach
        </select>

        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
    </div>

    @if(!is_null($selectedModel))
    <label class="form-label margin-bottom-xxxs" for="select-this">Страница:</label>

    <div class="select">
        <select class="select__input btn btn--subtle" wire:model="selectedLink" name="select-this" id="selectedLinks">
            <option value="">Выбрать страницу</option>
            @foreach($links as $item)
               <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>

        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
    </div>
    @endif

    @if(!is_null($selectedLink))
       <div class="padding-sm bg-contrast-lower margin-y-sm">
          &lt;a href="{{ $category }}/{{ $link->slug }}"&gt;{{ $link->name }}&lt;a&gt;
       </div>

        <div class="padding-sm bg-contrast-lower margin-y-sm">
            &lt;a href="{{ $category }}/{{ $link->slug }}"&gt;{{ $link->name }}&lt;a&gt;
            &lt;img src="{{ $link->getFirstMediaUrl('covers') }} {{ $link->getFirstMediaUrl('bracelet') }}"&gt;
        </div>

    @endif

</div>
