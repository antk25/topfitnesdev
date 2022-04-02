
<div class="border-contrast-lower border radius-lg padding-sm text-center flex@md flex-column@md margin-bottom-sm">

    <div class="margin-bottom-sm">
    @switch($review->rating_user)
        @case(1)
        <div class="text-center">
            <span class="badge badge--error-light text-sm">Плохо 👍</span>
        </div>
        @break

        @case(2)
        <div class="text-center">
            <span class="badge badge--warning-light text-sm">Средне 👍</span>
        </div>
        @break

        @case(3)
        <div class="text-center">
            <span class="badge badge--success-light text-sm">Отлично 👍</span>
        </div>
        @break

        @default
        <div class="text-center">
            <span class="badge badge--outline text-sm">Нет оценки</span>
        </div>
    @endswitch
    </div>

    <blockquote class="line-height-md margin-bottom-md">{!! Str::words($review->review_text, 30) !!}</blockquote>

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
