<li class="comments__comment hash-link hash-link--visible">
    <div class="flex items-start border border-contrast-lower padding-sm radius-lg">

        <div class="comments__content margin-top-xxxs">
            <div class="text-component text-sm v-space-xs line-height-md">
                <div class="flex items-center margin-bottom-sm">
            <span class="comments__author-img">
                  <img alt="User avatar" class="user-cell__img" src="{{ asset('/img/theme/comments-placeholder.svg') }}">
            </span>

                    <span class="color-contrast-high"><strong>@if($comment->user_id) {{ $comment->user->name }} @else {{ $comment->username }} @endif</strong></span>

                    <span class="color-contrast-medium margin-left-xs"><time class="comments__time"
                                                                             aria-label="{{ $comment->created_at->diffForHumans() }}">{{ $comment->created_at->diffForHumans() }}</time></span>

                </div>
                <div class="text-component">
                    {!! Str::words($comment->comment, 20) !!}
                </div>
                <div class="margin-top-sm color-contrast-medium">
                   Перейти:
                   <a class="link-fx-3" href="{{ $comment->commentable->getLink() }}#c{{ $comment->id }}">
                    <span>{{ $comment->commentable->name }}</span>
                    <svg class="icon" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><line x1="9" y1="6" x2="3.5" y2="11.5"/><line x1="3.5" y1="0.5" x2="9" y2="6"/></svg>
                  </a>
                </div>
            </div>
        </div>
    </div>

</li>