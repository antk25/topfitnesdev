<div class="bg radius-md shadow-xs padding-md margin-bottom-md">

    <legend class="form-legend">SEO</legend>

    <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
            <label class="form-label margin-bottom-xxs text-bold" for="user_id">Автор</label>
            <div class="select">
                <select
                    class="select__input form-control @error('user_id') form-control--error @enderror"
                    name="user_id">
                    <option value="">Выбрать автора</option>
                    @foreach ($users as $k => $v)
                        <option value="{{ $k }}" @if($k == old('user_id')) selected @endif>{{ $v }}</option>
                    @endforeach
                </select>

                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                    <g stroke-width="1" stroke="currentColor">
                        <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-miterlimit="10"
                                  points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                    </g>
                </svg>
            </div>
            @error('user_id')
            <div role="alert"
                 class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                <p><strong>ошибка:</strong> {{ $message }}</p></div>
            @enderror
        </div>
        <div class="col-6@md">
            <label class="form-label margin-bottom-xxs text-bold" for="slug">URI (SLUG)</label>
            <input class="form-control width-100%" type="text" name="slug" id="slug"
                   value="{{ old('slug') }}">
        </div>
    </div>

    <div class="margin-bottom-xs">
        <label class="form-label margin-bottom-xxs" for="title">Title</label>
        <input class="form-control width-100% @error('title') form-control--error @enderror"
               type="text" name="title" id="title" value="{{ old('title') }}">
        @error('title')
        <div role="alert"
             class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
            <p><strong>ошибка:</strong> {{ $message }}</p></div>
        @enderror
    </div>

    <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
            <label class="form-label margin-bottom-xxs" for="name">Название</label>
            <input class="form-control width-100% @error('name') form-control--error @enderror"
                   type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
            <div role="alert"
                 class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                <p><strong>ошибка:</strong> {{ $message }}</p></div>
            @enderror
            <p class="text-xs color-contrast-medium margin-top-xxs">Короткое название,
                menutitle</p>
        </div>

        <div class="col-6@md">
            <label class="form-label margin-bottom-xxs" for="subtitle">Subtitle (h1)</label>
            <input class="form-control width-100%" type="text" name="subtitle" id="subtitle"
                   value="{{ old('subtitle') }}">
        </div>
    </div>


    <div class="margin-bottom-xs">
        <div class="character-count js-character-count">
            <label class="form-label margin-bottom-xxs"
                   for="description">Description:</label>
            <textarea class="form-control width-100% js-character-count__input"
                      name="description" id="description" rows="5"
                      maxlength="500">{{ old('description') }}</textarea>
            <div
                class="character-count__helper character-count__helper--dynamic text-sm margin-top-xxxs"
                aria-live="polite" aria-atomic="true">
                Осталось <span class="js-character-count__counter"></span> символов
            </div>
            <div
                class="character-count__helper character-count__helper--static text-sm margin-top-xxxs">
                Макс 500 символов
            </div>
        </div>
    </div>
</div>
