@foreach ($reviews as $review)
<a name="review-{{ $review->id }}"></a>
<div class="bg-contrast-lower radius-md padding-md text-center flex@md flex-column@md margin-y-md">

    <div class="rating rating--read-only js-rating js-rating--read-only margin-bottom-sm">
      <p class="sr-only">Оценка <span class="rating__value js-rating__value">{{ $review->rating_user }}</span> из 5</p>

      <div class="rating__control rating__control--is-hidden js-rating__control">
        <svg width="24" height="24" viewBox="0 0 24 24"><polygon points="12 1.489 15.09 7.751 22 8.755 17 13.629 18.18 20.511 12 17.261 5.82 20.511 7 13.629 2 8.755 8.91 7.751 12 1.489" fill="currentColor"/></svg>
      </div>
    </div>

    <blockquote class="line-height-md margin-bottom-md">{{ $review->review_text }}</blockquote>

    <footer class="flex flex-column items-center margin-top-auto@md">
        <cite class="text-sm">
          <strong>{{ $review->name }}</strong> (<time class="color-contrast-medium" aria-label="{{ $review->created_at->diffForHumans() }}">{{ $review->created_at->diffForHumans() }}</time>)
          @if ($review->period_use != '')
          <span class="block color-contrast-medium margin-top-xxxxs">Период владения: {{ $review->period_use }}</span>
          @endif
        </cite>
      </footer>

  </div>
  @endforeach