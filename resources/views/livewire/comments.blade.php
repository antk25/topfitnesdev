<div>
  @if ($comments->count())
<section class="comments">
  <div class="margin-bottom-sm">
    <h2 class="text-md">Комментарии</h2>
  </div>
  <ul class="margin-bottom-lg">
    @foreach ($comments as $comment)
    @include('livewire.comments.show', ['comment' => $comment])
    @if($comment->replies->count() > 0)
    <div class="border-left border-3 border-opacity-20%">
      <ul class="margin-left-sm margin-top-sm">
        @include('livewire.comments.index', ['reply' => $comment->replies])
      </ul>
    </div>
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

  
  </section>

  @endif
  <section class="form-comment">
    <h3 class="margin-y-xs">
    <a class="text-bg-fx text-bg-fx--underline text-bg-fx--text-shadow" href="#" wire:click.prevent="resetInputFields">Написать комментарий</a>
    
    </h3>
    @if($commentIdReply == '')
<form wire:submit.prevent="store()">
    <fieldset>
      @if($user == '')
    <div class="input-merger form-control width-100% grid">
      <input type="text" class="reset input-merger__input min-width-0 col" name="username" wire:model="username" id="username" placeholder="Ваше имя">
      <input type="email" class="reset input-merger__input min-width-0 col" name="useremail" wire:model="useremail" id="useremail" placeholder="Email">
    </div> 
    <p class="text-xs color-contrast-medium margin-y-xxs">Укажите <span class="text-bold">имя</span> и <span class="text-bold">email</span>, либо <a href="{{ route('login') }}" aria-controls="modal-form">войдите</a>, <a href="{{ route('register') }}" aria-controls="modal-form">зарегистрируйтесь</a>.</p> 
    @endif
      <div class="margin-y-xs">
        <label class="sr-only" for="commentNewContent">Ваш комментарий</label>
        <textarea class="form-control width-100%" wire:model.lazy="comment"></textarea>
      </div>
    </fieldset>
    
    <button class="btn btn--primary" type="submit">Написать</button>
  </form>
  @endif 
  </section>
</div>
