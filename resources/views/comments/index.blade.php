<ul class="margin-bottom-lg">
    @foreach ($reviews as $review)
    <li class="comments__comment">
      <div class="comments__content margin-top-xxxs">
        <div class="Stars" style="--rating: {{ $review->rating_user }};" aria-label="Rating of this product is {{ $review->rating_user }} out of 5.">
        </div>
        <div class="text-component text-sm v-space-xs line-height-sm">
          <p><a href="#0" class="comments__author-name" rel="author">{{ $review->name }}</a> | Период владения: {{ $review->period_use }}</p>

          <p>{{ $review->review_text }}</p>


        </div>

        <div class="margin-top-xs text-sm">
          <div class="flex gap-xxs items-center">
            <button class="reset comments__vote-btn js-comments__vote-btn js-tab-focus" data-label="Like this comment along with 5 other people" aria-pressed="false">
              <span class="comments__vote-icon-wrapper">
                <svg class="icon block" viewBox="0 0 12 12" aria-hidden="true"><path d="M11.045,2.011a3.345,3.345,0,0,0-4.792,0c-.075.075-.15.225-.225.3-.075-.074-.15-.224-.225-.3a3.345,3.345,0,0,0-4.792,0,3.345,3.345,0,0,0,0,4.792l5.017,4.718L11.045,6.8A3.484,3.484,0,0,0,11.045,2.011Z"></path></svg>
              </span>

              <span class="margin-left-xxxs js-comments__vote-label" aria-hidden="true">5</span>
            </button>

            <span class="comments__inline-divider" aria-hidden="true"></span>

            <time class="comments__time" aria-label="1 hour ago">{{ $review->created_at->diffForHumans() }}</time>
          </div>
        </div>
      </div>
    </li>
    @endforeach
  </ul>