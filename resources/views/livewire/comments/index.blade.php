@foreach ($reply as $reply)
   <li class="comments__comment hash-link hash-link--visible" id="c{{ $reply->id }}">
              <div class="items-start border border-contrast-lower padding-sm radius-lg">
                <div class="comments__content margin-top-xxxs">
                  <div class="text-component text-sm v-space-xs line-height-sm">

                      <div class="flex items-center margin-bottom-sm">
                      <span class="comments__author-img">
                            <img class="user-cell__img" src="{{ asset('/img/theme/comments-placeholder.svg') }}">
                      </span>

                      <span class="color-contrast-high"><strong>@if($reply->user_id) {{ $reply->user->name }} @else {{ $reply->username }} @endif</strong></span>

                      <span class="color-contrast-medium margin-left-xs"><time class="comments__time" aria-label="{{ $reply->created_at->diffForHumans() }}">{{ $reply->created_at->diffForHumans() }}</time></span>

                      <span><a title="Постоянная ссылка на комментарий" class="hash-link__anchor text-bold text-decoration-none padding-x-xxs js-smooth-scroll" href="#c{{ $reply->id }}" aria-hidden="true">#</a></span>

                      </div>
                    <div class="text-component">{!! $reply->comment !!}</div>
                  </div>
                  <div class="margin-top-xs text-sm">

                        @if($commentIdReply !== $reply->id)
                        <button type="button" class="reset comments__label-btn js-tab-focus" wire:click.prevent="commentId({{ $reply->id }})">Ответить</button>
                        @else
                        <form wire:submit.prevent="store({{ $reply->id }})">

                          @if($user == '')
                          <div class="grid gap-xxs">
                            <div class="col-6@md">
                                <input class="form-control width-100%" wire:model.debounce.999999ms="username"
                                       @error('username') form-control--error @enderror" type="text" name="username" id="username"
                                placeholder="Имя" value="{{ old('username') }}">
                                @error('username')
                                <div role="alert"
                                     class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                    <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                @enderror
                            </div>

                            <div class="col-6@md">
                                <input class="form-control width-100%" wire:model.debounce.999999ms="useremail"
                                       @error('useremail') form-control--error @enderror" type="email" name="useremail" id="useremail"
                                placeholder="email@myemail.com">
                                @error('useremail')
                                <div role="alert"
                                     class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                    <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                @enderror
                            </div>
                        </div>
                          <p class="text-xs color-contrast-medium margin-y-xxxxs">Укажите <span class="text-bold">имя</span> и <span class="text-bold">email</span>, либо <a href="{{ route('register') }}" aria-controls="modal-form">зарегистрируйтесь</a>.</p>
                          @endif

                          <fieldset>
                            <div class="margin-bottom-xs">
                              <label class="sr-only" for="commentNewContent">Ваш ответ на комментарий c id {{ $reply->id }}</label>
                              <div class="margin-y-xs">
                                    <label class="sr-only" for="comment">Ваш комментарий</label>
                                    <div class="margin-y-md">
                                      <x-trix-editor comment="comment_text">

                                      </x-trix-editor>

                                            </div>
                                            @error('comment')
                                            <div role="alert"
                                                 class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                                <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                            @enderror
                                  </div>
                            </div>
                          </fieldset>
                          <button class="btn btn--primary" type="submit">Написать</button>
                          <button class="btn btn--secondary" wire:click.prevent="resetCommentId">Отмена</button>
                        </form>
                        @endif

                  </div>
                </div>
              </div>
              @if($reply->replies->count() > 0)
              <div class="border-left border-3 border-opacity-20%">
                <ul class="margin-left-sm  margin-top-sm">
                  @include('livewire.comments.index', ['reply' => $reply->replies])
                </ul>
              </div>
              @endif

            </li>
@endforeach