<div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    <h4>Превью</h4>

    <div class="grid gap-xs">

        <div class="col-2@md">
            <div class="file-upload inline-block margin-y-sm">
                <label for="cover" class="file-upload__label btn btn--primary">
              <span class="flex items-center">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor"
                                                                            stroke-width="2">
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path>
                        <path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path>
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path></g>
                </svg>
                <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить первью</span>
              </span>
                </label>
                <input type="file" class="file-upload__input" name="cover" id="cover">
            </div>
        </div>
        <div class="col-3@md">
            <img src="{{ $currentCover }}" alt="{{ $alt }}">
        </div>
    </div>
</div>
