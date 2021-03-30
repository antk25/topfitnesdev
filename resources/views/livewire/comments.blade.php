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
  <p>{{ session('message') }}</p>
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
    <button class="btn btn--primary" type="submit">Написать</button>
  </form>
  @endif 
  </section>
</div>