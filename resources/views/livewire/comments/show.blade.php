<li class="comments__comment">
      <div class="flex items-start">
  
        <div class="comments__content margin-top-xxxs">
          <div class="text-component text-sm v-space-xs line-height-sm">
            <p><a href="#0" class="comments__author-name" rel="author">{{ $comment->user->name }}</a></p>
            {{ $comment->comment }}
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
              @if($commentIdReply !== $comment->id)
              <button type="button" class="reset comments__label-btn js-tab-focus" wire:click.prevent="commentId({{ $comment->id }})">Ответить</button>
              @else
              <form wire:submit.prevent="replyStore({{ $comment->id }})">
                <fieldset>
                  <div class="margin-bottom-xs">
                    <label class="sr-only" for="commentNewContent">Ваш ответ на комментарий c id {{ $comment->id }}</label>
                    <textarea class="form-control width-100%" wire:model="comment"></textarea>
                  </div>
                </fieldset>
                <button class="btn btn--primary" type="submit">Написать</button>
              </form>
              @endif
              {{-- <div x-data="{ isOpen : ''}"> --}}
              {{-- <button @click="isOpen = 'reply-{{ $comment->id }}'" type="button" class="reset comments__label-btn js-tab-focus">Ответить</button> --}}
    
				                {{-- <div x-show="isOpen === 'reply-{{ $comment->id }}'"> --}}
                          
                            {{-- <form wire:submit.prevent="replyStore({{ $comment->id }})"> --}}
                                {{-- <fieldset> --}}
                                  {{-- <div class="margin-bottom-xs"> --}}
                                    {{-- <label class="sr-only" for="commentNewContent">Ваш ответ на комментарий c id {{ $comment->id }}</label> --}}
                                    {{-- <textarea class="form-control width-100%" wire:model="comment"></textarea> --}}
                                  {{-- </div> --}}
                                {{-- </fieldset> --}}
                                {{-- <button class="btn btn--primary" type="submit">Написать</button> --}}
                              {{-- </form> --}}
				 
				                {{-- </div> --}}
              {{-- </div> --}}
              <span class="comments__inline-divider" aria-hidden="true"></span>
  
              <time class="comments__time" aria-label="1 hour ago">{{ $comment->created_at->diffForHumans() }}</time>
            </div>
          </div>
        </div>
      </div>