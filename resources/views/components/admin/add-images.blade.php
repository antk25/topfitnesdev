<div class="bg radius-md shadow-xs padding-md margin-bottom-md">
<div class="flex gap-sm">
  @if (isset($currentCover))
  <div class="border-contrast-lower border-right">
          <h4>Превью</h4>
          <div class="file-upload inline-block margin-y-sm">
              <label for="cover" class="file-upload__label btn btn--primary">
                  <span class="flex items-center">
                      <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                          <g fill="none" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path>
                              <path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path>
                              <path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path>
                          </g>
                      </svg>
                      <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить</span>
                  </span>
              </label>
              <input type="file" class="file-upload__input" name="cover" id="cover">
          </div>
        @if ($currentCover == 'placeholder')

          <img src="{{ asset('img/theme/img-placeholder.svg') }}" alt="" class="block width-50%">

          @else

          {{ $currentCover }}

        @endif

  </div>
      @endif
  <div>
    {{-- Add images --}}
      <h4>Изображения</h4>
      <div class="file-upload margin-y-sm">
        <label for="files" class="file-upload__label btn btn--primary">
            <span class="flex items-center">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                    <g fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path>
                        <path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path>
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path>
                    </g>
                </svg>

                <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить</span>
            </span>
        </label>

        <input type="file" class="file-upload__input" name="files[]" id="files" multiple>
    </div>
    <div class="text-component">
      <p class="text-md color-contrast-medium">Выберите одно или несколько изображений в
          формате <mark>jpg</mark>. После публикации можно будет редактировать теги <mark>alt</mark> у каждой картинки.
      </p>
  </div>


  {{-- End add images --}}
  </div>
</div>
</div>