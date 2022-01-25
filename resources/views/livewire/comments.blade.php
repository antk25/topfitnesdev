<div>
    @if ($model->comments->count())
        <section class="comments">
            <div class="margin-bottom-sm">
                <h2 class="text-md">Комментарии</h2>
            </div>
            <ul class="margin-bottom-lg">
                @foreach ($model->comments as $comment)
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
            <div x-data="{ open: true }">
                <div x-show="open" x-transition class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24"
                                 aria-hidden="true">
                                <path
                                    d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
                            </svg>

                            <p class="text-sm">{{ session('message') }}.</p>
                        </div>

                        <button x-on:click="open = ! open" class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
                            <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <title>Close alert</title>
                                <line x1="3" y1="3" x2="17" y2="17"/>
                                <line x1="17" y1="3" x2="3" y2="17"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </section>

    @endif
    <section class="form-comment">
        <h3 class="margin-y-xs">
            <a class="text-bg-fx text-bg-fx--underline text-bg-fx--text-shadow" href="#"
               wire:click.prevent="resetCommentId">Написать комментарий</a>
        </h3>
        @if($commentIdReply == '')
            <form wire:submit.prevent="store()">
                <fieldset>
                    @if($user == '')
                        <div class="grid gap-xxs">
                            <div class="col-6@md">
                                <input class="form-control width-100%" wire:model.debounce.999999ms="username"
                                       @error('username') form-control--error @enderror" type="text" name="username"
                                id="username"
                                placeholder="Имя" value="{{ old('username') }}">
                                @error('username')
                                <div role="alert"
                                     class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                    <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                @enderror
                            </div>

                            <div class="col-6@md">
                                <input class="form-control width-100%" wire:model.debounce.999999ms="useremail"
                                       @error('useremail') form-control--error @enderror" type="email" name="useremail"
                                id="useremail"
                                placeholder="email@myemail.com">
                                @error('useremail')
                                <div role="alert"
                                     class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                                    <p><strong>ошибка:</strong> {{ $message }}</p></div>
                                @enderror
                            </div>
                        </div>
                        <p class="text-xs color-contrast-medium margin-y-xxs">Укажите <span class="text-bold">имя</span>
                            и <span class="text-bold">email</span>, либо <a href="{{ route('login') }}"
                                                                            aria-controls="modal-form">войдите</a>, <a
                                href="{{ route('register') }}" aria-controls="modal-form">зарегистрируйтесь</a>.</p>
                    @endif
                    <div class="margin-y-xs">

                        <label class="sr-only" for="commentNewContent">Ваш комментарий</label>
                        <div class="margin-y-md">
                            <x-trix-editor comment="comment_text">

                            </x-trix-editor>
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

                        </div>
                        @error('comment_text')
                        <div role="alert"
                             class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs">
                            <p><strong>ошибка:</strong> {{ $message }}</p></div>
                        @enderror
                    </div>
                </fieldset>

                <button class="btn btn--primary" type="submit">Написать</button>
            </form>
        @endif
    </section>
</div>
