<div>
    @if ($model->comments->count())
        <section class="comments">
            <ul class="margin-bottom-lg">
                @foreach ($model->commentsParentless as $comment)
                    @include('livewire.admin.comments.show', ['comment' => $comment])
                    @if($comment->replies->count() > 0)
                        <div class="border-left border-3 border-opacity-20%">
                            <ul class="margin-left-sm margin-top-sm">
                                @include('livewire.admin.comments.index', ['reply' => $comment->replies])
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
                                <input class="form-control width-100%" wire:model.lazy="useremail"
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
                    @endif

                    <div class="margin-y-sm">

                        <label for="created_at" class="form-label margin-bottom-xxs">Выбрать дату</label>

                        <x-admin.flatpickr wire:model.lazy="created_at" placeholder="YYYY-MM-DD HH:mm:ss"/>

                    </div>

                    <div class="margin-y-xs">

                        <label class="sr-only" for="commentNewContent">Ваш комментарий</label>
                        <div class="margin-y-md">
                            <x-trix-editor comment="comment_text">

                            </x-trix-editor>

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
@once
    @push('js')
        <script src="{{ asset('js/admin/alpine.min.js') }}"></script>
    @endpush
@endonce