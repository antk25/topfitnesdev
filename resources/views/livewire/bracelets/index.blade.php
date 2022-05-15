<div class="radius-md grid margin-bottom-sm shadow-sm padding-sm">
  <div class="col-4 col-2@md padding-right-sm">
    <div class="border radius-md padding-xxxs">
      <img src="{{ $bracelet->getFirstMediaUrl('bracelets', 'thumb') }}" alt="{{ $bracelet->name }}">
    </div>
      <div class="text-center padding-top-sm">
      <span class="prod-card-v2__badge" title="Наша оценка" role="text">
            <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.765 9.397a.676.676 0 00-.538-.453l-6.64-1.015-2.976-6.34c-.222-.474-.999-.474-1.222 0L8.413 7.93l-6.64 1.015a.674.674 0 00-.381 1.139l4.824 4.945-1.14 6.99a.673.673 0 00.992.699L12 19.439l5.931 3.278a.672.672 0 00.993-.699l-1.14-6.99 4.824-4.945a.675.675 0 00.157-.686z" fill="#ffc107"/>
                <path d="M5.574 15.362l-1.267 7.767a.751.751 0 001.103.777L12 20.264l6.59 3.643a.748.748 0 001.103-.778l-1.267-7.767 5.36-5.494a.75.75 0 00-.423-1.265l-7.378-1.127L12.678.432c-.247-.526-1.11-.526-1.357 0L8.015 7.476.637 8.603a.75.75 0 00-.424 1.265zm3.063-6.464a.75.75 0 00.565-.422L12 2.515l2.798 5.96a.747.747 0 00.565.422l6.331.967-4.605 4.72a.75.75 0 00-.204.645l1.08 6.617-5.602-3.096a.755.755 0 00-.726 0l-5.602 3.096 1.08-6.617a.75.75 0 00-.204-.645l-4.605-4.72z"/>
            </svg>&nbsp;
            <span class="text-bold">{{ round($bracelet->average_grade, 1) }}</span> <i class="sr-only">product</i>
        </span>
      </div>
  </div>
<div class="col-7">
  <p class="text-md text-bold">
      <a class="text-decoration-none" href="{{ route('pub.bracelets.show', ["bracelet" => $bracelet]) }}">
          {{ $bracelet->name }}
      </a>
  </p>

  <div class="text-sm margin-top-sm text-left">
      <span class="color-contrast-medium">Дисплей:</span> {{ $bracelet->disp_diag }}&#8243;, {{ $bracelet->disp_resolution }}, {{ $bracelet->disp_tech }}<br>
      <span class="color-contrast-medium">Поддержка NFC:</span> @if ($bracelet->nfc != '') Да @else Нет @endif<br>
      <span class="color-contrast-medium">Пульсоксиметр:</span> @if ($bracelet->oxy_permanent != '') Да @else Нет @endif<br>
      <span class="color-contrast-medium">Измерение давления:</span> @if ($bracelet->ad_permanent != '') Да @else Нет @endif<br>
      <div class="display@xs">
      <span class="color-contrast-medium">Совместимость:</span> @if ($bracelet->compatibility != null)
      @foreach ($bracelet->compatibility as $item)
         {{ $item }},
      @endforeach
      @endif<br>
      <span class="color-contrast-medium">Постоянное измерение пульса:</span> @if ($bracelet->heart_rate != '') Да @else Нет @endif
      </div>

  </div>
  </div>
<div class="col-3@md border-left padding-left-sm text-sm">

    @if ($bracelet->sellers->count())
    <div class="text-center text-bold hide@sm">Цены:</div>
      @foreach ($bracelet->sellers as $seller)
      <div class="flex justify-between border-bottom">
{{--        <div class="text-sm padding-y-xxxxs">--}}
{{--          @if ($seller->marketplace)--}}
{{--            {{ $seller->marketplace }}--}}
{{--          @else--}}
{{--            {{ $seller->name }}--}}
{{--          @endif--}}
{{--        </div>--}}
      <div class="text-md padding-y-xxxxs">
        @if ($seller->pivot->old_price != '')
          <a class="text-bold text-decoration-none color-error-light" href="{{ $seller->pivot->link }}">
              <span>{{ $seller->pivot->price }}</span> &#8381;
          </a>
          <del class="text-sm">
            {{ $seller->pivot->old_price }} &#8381;
          </del>
        @else
          <a class="text-bold text-decoration-none color-error-light" href="{{ $seller->pivot->link }}">
              <span>{{ $seller->pivot->price }}</span> &#8381;
          </a>
        @endif
      </div>
      </div>
      @endforeach
    @endif

</div>
</div>
