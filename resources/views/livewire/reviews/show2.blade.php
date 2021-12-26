<li class="comments__comment hash-link hash-link--visible" id="review-{{ $review->id }}">
    <div class="items-start border border-contrast-lower padding-sm radius-lg">
        <div class="comments__content margin-top-xxxs">
            <div class="text-sm v-space-xs line-height-sm">
                <div class="grid justify-between gap-xs flex-row-reverse@md comment-head">
                    <div class="col-content@md">
                        <div class="margin-bottom-xxxs">
                        <span class="color-contrast-medium margin-left-xs"><time class="comments__time" aria-label="{{ $review->created_at->diffForHumans() }}">{{ $review->created_at->diffForHumans() }}</time></span>
                        <span><a title="Постоянная ссылка на отзыв" class="hash-link__anchor text-bold text-decoration-none padding-x-xxs js-smooth-scroll" href="#review-{{ $review->id }}" aria-hidden="true">#</a></span>
                        </div>

                        @switch($review->rating_user)
                            @case(1)
                                    <div class="text-right">
                                        <span class="badge badge--error-light text-sm">Плохо 👍</span>
                                    </div>
                                @break

                            @case(2)
                                    <div class="text-right">
                                        <span class="badge badge--warning-light text-sm">Средне 👍</span>
                                    </div>
                                @break

                            @case(3)
                                    <div class="text-right">
                                        <span class="badge badge--success-light text-sm">Отлично 👍</span>
                                    </div>
                                @break

                            @default
                                    <div class="text-right">
                                        <span class="badge badge--outline text-sm">Нет оценки</span>
                                    </div>
                        @endswitch

                    </div>


                    <div class="col-content@md">
                    <div class="flex items-center">
                      <div class="comments__author-img">
                            <img alt="User Avatar" class="user-cell__img" src="{{ asset('img/theme/comments-placeholder.svg') }}">
                      </div>
                    <div>
                    <span class="color-contrast-high"><strong>{{ $review->name }}</strong></span>
                    @if($review->period_use)
                    <span class="text-sm block"><span class="color-contrast-low">Период использования:</span> {{ $review->period_use }}</span>
                    @endif
                        </div>
                    </div>
                    </div>


                </div>

                <div class="margin-y-sm text-component">
                {!! $review->review_text !!}
               </div>
            </div>
        </div>
    </div>
</li>
