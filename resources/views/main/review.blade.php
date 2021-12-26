
<div class="bg-contrast-lower radius-md padding-md text-center flex@md flex-column@md col-4@md">

    <div class="rating rating--read-only js-rating js-rating--read-only margin-bottom-sm">
      <p class="sr-only">Оценка <span class="rating__value js-rating__value">{{ $review->rating_user }}</span> из 5</p>

      <div class="rating__control rating__control--is-hidden js-rating__control">
        <svg width="24" height="24" viewBox="0 0 24 24"><polygon points="12 1.489 15.09 7.751 22 8.755 17 13.629 18.18 20.511 12 17.261 5.82 20.511 7 13.629 2 8.755 8.91 7.751 12 1.489" fill="currentColor"/></svg>
      </div>
    </div>

    <blockquote class="line-height-md margin-bottom-md">{{ $review->review_text }}</blockquote>

    <footer class="flex flex-column items-center margin-top-auto@md">
        <cite class="text-sm">
          <strong>{{ $review->name }}</strong> <time aria-label="{{ $review->created_at->diffForHumans() }}">{{ $review->created_at->diffForHumans() }}</time>
          @if ($review->period_use != '')
          <span class="block color-contrast-medium margin-top-xxxxs">Период владения: {{ $review->period_use }}</span>
          @endif
        </cite>
      </footer>
      <div class="text-component margin-y-sm">
        <a title="Перейти к отзыву" class="link-fx-3 color-contrast-higher" href="katalog/{{ $review->reviewable->slug }}#review-{{ $review->id }}">
            <span>{{ $review->reviewable->name }}</span>
            <svg class="icon" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><line x1="9" y1="6" x2="3.5" y2="11.5"/><line x1="3.5" y1="0.5" x2="9" y2="6"/></svg>
          </a>
        </div>

  </div>