@extends('admin.layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/fullscreen.css') }}">
@endpush

@section('content')

    <div class="container">

        <div class="flex justify-between bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
            <div>
            {{ Breadcrumbs::render('admin_post', $post) }}
            </div>
            <div>
                <a target="_blank" title="Откроется в новом окне" class="text-sm block font-bold text-decoration-none" href="{{ route('pub.posts.show', ['post' => $post]) }}">Посмотреть 👉</a>
            </div>
        </div>


        <div class="tabs js-tabs">
            <ul class="flex flex-wrap gap-sm js-tabs__controls" aria-label="Tabs Interface">
                <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Статья</a></li>
                <li><a href="#tab1Panel2" class="tabs__control">Комментарии</a></li>
                <li><a href="#tab1Panel3" class="tabs__control">Ссылки</a></li>
            </ul>

            <div class="js-tabs__panels">
            <section id="tab1Panel1" class="is-visible js-tabs__panel padding-top-sm">

                <form class="form-template-v3" method="POST"
                      action="{{ route('posts.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Сообщение об успешности сохранения --}}
                    @if(session('success'))

                        <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert"
                             role="alert">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24"
                                         aria-hidden="true">
                                        <path
                                            d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
                                    </svg>

                                    <p class="text-sm"><strong>Успешно:</strong> {{ session('success') }}.</p>
                                </div>

                                <button
                                    class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
                                    <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <title>Close alert</title>
                                        <line x1="3" y1="3" x2="17" y2="17"/>
                                        <line x1="17" y1="3" x2="3" y2="17"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                    {{-- Конец сообщения об успешности сохранения --}}
                    <x-admin.seo-block :model="$post" :users="$users">

                    </x-admin.seo-block>


                    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                        @include('admin.layouts.parts.htmlcomponents')

                        <button class="btn btn--primary margin-y-sm" aria-controls="drawer-1">Галерея</button>

                        <x-admin.codemirror-editor :content="$post->content_raw" name="content" id="content">
                            <h4>Основной контент</h4>
                            <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
                                полный экран, ESC для выхода.</p>
                        </x-admin.codemirror-editor>

                        <x-admin.codemirror-editor :content="$post->sources" name="sources" id="sources">
                            <h4>Источники</h4>
                            <p class="color-contrast-medium text-sm">Указать ссылки на сайты или научные статьи</p>

                        </x-admin.codemirror-editor>


                    </div>

                    <x-admin.add-images currentCover="{{ $post->getFirstMedia('covers') }}" alt="Превью">

                    </x-admin.add-images>

                    <div class="margin-y-md">
                        <button type="submit" class="btn btn--success">Сохранить</button>
                    </div>
                </form>

                <div class="margin-top-lg drawer js-drawer" id="drawer-1">
                    <div class="drawer__content bg-light inner-glow shadow-md" role="alertdialog"
                         aria-labelledby="drawer-title-1">
                        <div class="drawer__body padding-sm js-drawer__body">

                                @livewire('admin.control-images', ['images' => $post->getMedia('posts')])

                        </div>

                        <button
                            class="reset drawer__close-btn position-fixed top-0 right-0 z-index-fixed-element margin-xs js-drawer__close js-tab-focus">
                            <svg class="icon icon--xs" viewBox="0 0 16 16"><title>Close drawer panel</title>
                                <g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                   stroke-linejoin="round" stroke-miterlimit="10">
                                    <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                                    <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>

            </section>

            <section id="tab1Panel2" class="js-tabs__panel padding-top-sm">

                {{-- Таблица комментариев для текущей страницы. В функции foreach заменить модель для вызова комментов --}}

                    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

                        @livewire('admin.comments', ['model' => $post, 'user' => null, 'users' => $users])

                    </div>

                {{-- Конец таблицы комментариев --}}

            </section>

            <section id="tab1Panel3" class="js-tabs__panel padding-top-sm">
                <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                    @livewire('admin.create-links')
                </div>
            </section>

        </div>

    </div>
@endsection

@push('js')
    <script src="{{ asset("js/admin/prism.min.js") }}"></script>
@endpush
