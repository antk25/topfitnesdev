<div>
<div class="margin-y-sm text-component">
  <h2>Комментарии</h2>
</div>
<section class="comments">
  <div class="margin-bottom-lg">
    <div class="flex gap-sm flex-column flex-row@md justify-between items-center@md">
        <h2 class="text-md">Комментарии</h2>
    
      <form aria-label="Choose sorting option">
        <div class="flex flex-wrap gap-sm text-sm">
          <div class="position-relative">
            <input class="comments__sorting-label" type="radio" name="sortComments" wire:click="sort1" id="sortCommentsPopular" checked>
            <label for="sortCommentsPopular">Popular</label>
          </div>
      
          <div class="position-relative">
            <input class="comments__sorting-label" type="radio" name="sortComments" id="sortCommentsNewest">
            <label for="sortCommentsNewest">Newest</label>
          </div>
        </div>
      </form>
    </div>
  </div>
  <ul class="margin-bottom-lg">
    @foreach ($comments as $comment)
    @include('livewire.comments.show', ['comment' => $comment])
    @if($comment->replies->count() > 0)
      <ul class="margin-left-sm">
        @include('livewire.comments.index', ['reply' => $comment->replies])
      </ul>
    @endif
</li>

  @endforeach
  </ul>
  @if (session()->has('message'))
<div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
      </svg>

      <p class="text-sm">{{ session('message') }}.</p>
    </div>
  
    <button class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
      <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
        <title>Close alert</title>
        <line x1="3" y1="3" x2="17" y2="17" />
        <line x1="17" y1="3" x2="3" y2="17" />
      </svg>
    </button>
  </div>
</div>


  @endif

  @if($commentIdReply == '')
<form wire:submit.prevent="store()">
    <fieldset>
      <legend class="form-legend">Написать комментарий</legend>
      <div class="margin-bottom-xs">
        <label class="sr-only" for="commentNewContent">Ваш комментарий</label>
        <textarea class="form-control width-100%" wire:model.lazy="comment"></textarea>
      </div>
    </fieldset>
    @if($user == null)
     

<button class="btn btn--primary" aria-controls="modal-form">Show form</button>

<div class="modal modal--animate-scale flex flex-center bg-contrast-higher bg-opacity-90% padding-md js-modal" id="modal-form">
  <div class="modal__content width-100% max-width-xs max-height-100% overflow-auto padding-md bg radius-md shadow-md" role="alertdialog" aria-labelledby="modal-form-title" aria-describedby="modal-form-description">
    <div class="text-component margin-bottom-md">
      <h3 id="modal-form-title">Join our Newsletter</h3>
      <p id="modal-form-description">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Suscipit asperiores molestiae ex.</p>
    </div>

    <form class="margin-bottom-sm">
      <div class="flex flex-column flex-row@xs gap-xxxs">
        <input aria-label="Email" class="form-control flex-grow" type="email" placeholder="Email">
        <button class="btn btn--primary">Subscribe</button>
      </div>
    </form>

    <div class="text-component">
      <p class="text-xs color-contrast-medium">Lorem ipsum dolor sit, amet <a href="#0" class="color-contrast-high">consectetur adipisicing</a> elit. Nisi molestias hic voluptatibus.</p>
    </div>
  </div>

  <button class="reset modal__close-btn modal__close-btn--outer  js-modal__close js-tab-focus">
    <svg class="icon icon--sm" viewBox="0 0 24 24">
      <title>Close modal window</title>
      <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="3" y1="3" x2="21" y2="21" />
        <line x1="21" y1="3" x2="3" y2="21" />
      </g>
    </svg>
  </button>
</div>

 
    @else
    <button class="btn btn--primary" type="submit">Написать</button>
    @endif 
  </form>
  @endif 
  </section>
</div>

