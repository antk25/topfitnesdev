<li class="comments__comment hash-link hash-link--visible" id="c{{ $comment->id }}">
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

                    <span><a title="Постоянная ссылка на комментарий"
                             class="hash-link__anchor text-bold text-decoration-none padding-x-xxs js-smooth-scroll"
                             href="#c{{ $comment->id }}" aria-hidden="true">#</a></span>
                </div>
                    <div class="text-component">
                        {!! $comment->comment !!}
                    </div>
            </div>

            <div class="margin-top-xs text-sm">

                @if($commentIdReply !== $comment->id)
                    <button type="button" class="reset comments__label-btn js-tab-focus"
                            wire:click.prevent="commentId({{ $comment->id }})">Ответить
                    </button> |

                    <a type="button" class="reset comments__label-btn js-tab-focus"
                            href="{{ route('comments.edit', ['comment' => $comment->id]) }}">Изменить
                    </a>
                @else
                    <form wire:submit.prevent="store({{ $comment->id }})">
                        <fieldset>
                            <label class="form-label margin-bottom-xxs text-bold" for="user_id">Автор</label>
                        <div class="select margin-bottom-sm">
                            <select
                                class="select__input form-control @error('user') form-control--error @enderror"
                                 wire:model="user">
                                <option value="">Выбрать автора</option>
                                @foreach ($users as $k => $v)
                                    <option value="{{ $k }}"
                                            selected>{{ $v }}</option>
                                @endforeach
                            </select>

                            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                                <g stroke-width="1" stroke="currentColor">
                                    <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                              stroke-linejoin="round" stroke-miterlimit="10"
                                              points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                                </g>
                            </svg>
                        </div>
                        @error('user')
                        <div role="alert"
                             class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                            <p><strong>ошибка:</strong> {{ $message }}</p></div>
                        @enderror

                        @if($user == '')
                            <div class="grid gap-xxs">
                            <div class="col-6@md">
                                <input class="form-control width-100%" wire:model.lazy="username"
                                       @error('username') form-control--error @enderror" type="text" name="username" id="username"
                                placeholder="Имя" value="{{ old('username') }}">
                                @error('username')
                                <div role="alert"
                                     class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                    <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                @enderror
                            </div>

                            <div class="col-6@md">
                                <input class="form-control width-100%" wire:model.lazy="useremail"
                                       @error('useremail') form-control--error @enderror" type="email" name="useremail" id="useremail"
                                placeholder="email@myemail.com">
                                @error('useremail')
                                <div role="alert"
                                     class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                    <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div class="margin-y-sm">

                            <label for="created_at" class="form-label margin-bottom-xxs">Выбрать дату</label>

                            <x-admin.flatpickr wire:model.lazy="created_at" placeholder="YYYY-MM-DD HH:mm:ss"/>

                        </div>

                        <fieldset>
                            <div class="margin-bottom-xs">
                                <label class="sr-only" for="commentNewContent">Ваш ответ на комментарий c
                                    id {{ $comment->id }}</label>
                                <div class="margin-y-xs">
                                    <label class="sr-only" for="comment">Ваш комментарий</label>
                                    <div class="margin-y-md">
                                                {{-- <div x-data="{textEditor: $wire.entangle('comment').defer}"
                                                     x-init="()=>{var element = document.querySelector('trix-editor');
                                                               element.editor.insertHTML(textEditor);}"
                                                     wire:ignore>

                                                    <input x-ref="editor"
                                                           id="editor-x"
                                                           type="hidden"
                                                           name="comment">

                                                    <trix-editor class="trix-editor border-gray-300 trix-content" input="editor-x"
                                                                 x-on:trix-change="textEditor=$refs.editor.value;"
                                                                 wire:model.lazy="comment"
                                                    ></trix-editor>
                                                </div> --}}

                                                <x-trix-editor comment="comment_text">

                                                </x-trix-editor>
                                            </div>
                                            @error('comment_text')
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
