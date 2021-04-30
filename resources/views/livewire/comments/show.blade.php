<li class="comments__comment hash-link hash-link--visible" id="c{{ $comment->id }}">
      <div class="flex items-start border border-contrast-lower padding-sm radius-lg">
  
        <div class="comments__content margin-top-xxxs">
          <div class="text-component text-sm v-space-xs line-height-md">
            

<div class="flex items-center margin-bottom-sm">
<span class="comments__author-img">
      <img class="user-cell__img" src="/storage/theme/comments-placeholder.svg">
</span>

<span class="color-contrast-high"><strong>@if($comment->user_id) {{ $comment->user->name }} @else Anonim @endif</strong></span>

<span class="color-contrast-medium margin-left-xs"><time class="comments__time" aria-label="{{ $comment->created_at->diffForHumans() }}">{{ $comment->created_at->diffForHumans() }}</time></span>

<span><a title="Постоянная ссылка на комментарий" class="hash-link__anchor text-bold text-decoration-none padding-x-xxs js-smooth-scroll" href="#c{{ $comment->id }}" aria-hidden="true">#</a></span>

</div>

<p>
            {{ $comment->comment }}
</p>
          </div>
  
          <div class="margin-top-xs text-sm">
            <div class="flex gap-xxs items-center">
              
              @if($commentIdReply !== $comment->id)
              <button type="button" class="reset comments__label-btn js-tab-focus" wire:click.prevent="commentId({{ $comment->id }})">Ответить</button>
              @else
              <form wire:submit.prevent="replyStore({{ $comment->id }})">
                <fieldset>
                  <div class="margin-bottom-xs">
                    <label class="sr-only" for="commentNewContent">Ваш ответ на комментарий c id {{ $comment->id }}</label>
                    <textarea class="form-control width-100%" wire:model.lazy="comment"></textarea>
                  </div>
                </fieldset>
                <button class="btn btn--primary" type="submit">Написать</button>
                <button class="btn btn--secondary" wire:click.prevent="resetInputFields">Отмена</button>
              </form>
              @endif
              
            </div>
          </div>
        </div>
      </div>