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
                {{ Breadcrumbs::render('admin_manual', $manual) }}
            </div>
            <div>
                <a target="_blank" title="Откроется в новом окне" class="text-sm block font-bold text-decoration-none"
                    href="{{ route('pub.manuals.show', ['manual' => $manual]) }}">Посмотреть 👉</a>
            </div>
        </div>
        <div class="tabs js-tabs">
            <ul class="flex flex-wrap gap-sm js-tabs__controls margin-bottom-sm" aria-label="Tabs Interface">
                <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Мануал</a></li>
                <li><a href="#tab1Panel2" class="tabs__control">Комментарии</a></li>
                <li><a href="#tab1Panel3" class="tabs__control">Ссылки</a></li>
            </ul>

            <div class="js-tabs__panels">
                <section id="tab1Panel1" class="is-visible js-tabs__panel">

                    <form class="form-template-v3" method="POST"
                        action="{{ route('manuals.update', ['manual' => $manual->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- Сообщение об успешности сохранения --}}
                        @if (session('success'))

                            <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24"
                                            aria-hidden="true">
                                            <path
                                                d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z">
                                            </path>
                                        </svg>

                                        <p class="text-sm"><strong>Успешно:</strong> {{ session('success') }}.</p>
                                    </div>

                                    <button class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
                                        <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            <title>Close alert</title>
                                            <line x1="3" y1="3" x2="17" y2="17" />
                                            <line x1="17" y1="3" x2="3" y2="17" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                        {{-- Конец сообщения об успешности сохранения --}}

                        <x-admin.seo-block :model="$manual" :users="$users">

                        </x-admin.seo-block>

                        <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
                            {{-- Add bracelets --}}
                            <section class="margin-bottom-md">
                                <div class="text-component">
                                    <h4>Добавить браслеты, которые упоминаются в мануале</h4>
                                </div>

                                <div class="alert alert--warning alert--is-visible padding-sm radius-md js-alert margin-top-sm"
                                    role="alert">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24"
                                                aria-hidden="true">
                                                <path
                                                    d="M12,0C5.383,0,0,5.383,0,12s5.383,12,12,12s12-5.383,12-12S18.617,0,12,0z M13.645,5L13,14h-2l-0.608-9 H13.645z M12,20c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C14,19.105,13.105,20,12,20z">
                                                </path>
                                            </svg>

                                            <p class="text-sm"><strong>Внимание:</strong> это необязательное поле. В
                                                мануале могут вообще не упоминаться браслеты.
                                                Это поле нужно для перелинковки. В карточке браслета появится ссылка на этот
                                                мануал.
                                            </p>
                                        </div>

                                        <button
                                            class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
                                            <svg class="icon" viewBox="0 0 20 20" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2">
                                                <title>Close alert</title>
                                                <line x1="3" y1="3" x2="17" y2="17" />
                                                <line x1="17" y1="3" x2="3" y2="17" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="js-repeater" data-repeater-input-name="allbracelets[n]">
                                    <div class="js-repeater__list">
                                        {{-- Используем функцию forelse, чтобы при отсутствии связей вывести пустую форму --}}
                                        @forelse ($manual->bracelets as $item)
                                            <div class="margin-y-md js-repeater__item">
                                                <div class="grid gap-xs">
                                                    <div class="col">

                                                        <div class="select margin-bottom-xxs">
                                                            <select class="select__input form-control"
                                                                name="allbracelets[{{ $loop->index }}]"
                                                                id="allbracelets[0]" class="form-control">
                                                                <option value="">-- Выбрать браслет --</option>
                                                                @foreach ($bracelets as $k => $v)
                                                                    <option value="{{ $k }}" @if ($item->id == $k)
                                                                        selected
                                                                @endif >{{ $v }}</option>
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
                                </div>

                                <div class="col-content">
                                    <button class="btn btn--subtle btn--accent padding-x-xs col-content js-repeater__remove"
                                        type="button">
                                        <svg class="icon" viewBox="0 0 20 20">
                                            <title>Remove item</title>

                                            <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2">
                                                <line x1="1" y1="5" x2="19" y2="5" />
                                                <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5" />
                                                <path
                                                    d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8" />
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                        </div>


            </div>

        @empty

            <div class="margin-y-md js-repeater__item">
                <div class="grid gap-xs">
                    <div class="col">
                        <div class="select margin-bottom-xxs">
                            <select class="select__input form-control" name="allbracelets[0]" id="allbracelets[0]"
                                class="form-control">
                                <option value="">-- Выбрать браслет --</option>
                                @foreach ($bracelets as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>

                            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                                <g stroke-width="1" stroke="currentColor">
                                    <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 ">
                                    </polyline>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="col-content">
                        <button class="btn btn--subtle padding-x-xs col-content js-repeater__remove" type="button">
                            <svg class="icon" viewBox="0 0 20 20">
                                <title>Remove item</title>

                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <line x1="1" y1="5" x2="19" y2="5" />
                                    <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5" />
                                    <path d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8" />
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            @endforelse
        </div>
        <button class="btn btn--primary width-100% margin-top-xs js-repeater__add" type="button">+ Добавить браслет</button>
    </div>
    </section>
    {{-- End add bracelets --}}
    </div>

    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

        @include('admin.layouts.parts.htmlcomponents')

        <button class="btn btn--primary margin-y-sm" aria-controls="drawer-1">Галерея</button>


        <x-admin.codemirror-editor :content="$manual->content_raw" name="content" id="content">
            <h4>Основной контент</h4>
            <p class="text-sm color-contrast-medium">Нажать F11 для переключения редактора на
                полный экран, ESC для выхода.</p>
        </x-admin.codemirror-editor>

    </div>

    <x-admin.add-images :currentCover="$manual->getFirstMedia('covers')" alt="Превью">

    </x-admin.add-images>

    <div class="margin-y-md">
        <button type="submit" class="btn btn--success">Сохранить</button>
    </div>
    </form>

    {{-- Control Images --}}
    <div class="margin-top-lg drawer js-drawer" id="drawer-1">
        <div class="drawer__content bg-light inner-glow shadow-md" role="alertdialog" aria-labelledby="drawer-title-1">
            <div class="drawer__body padding-sm js-drawer__body">

                @livewire('admin.control-images', ['images' => $manual->getMedia('manuals')])

            </div>

            <button
                class="reset drawer__close-btn position-fixed top-0 right-0 z-index-fixed-element margin-xs js-drawer__close js-tab-focus">
                <svg class="icon icon--xs" viewBox="0 0 16 16">
                    <title>Close drawer panel</title>
                    <g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-miterlimit="10">
                        <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                        <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                    </g>
                </svg>
            </button>
        </div>
    </div>
    {{-- End Control Images --}}


    </section>

    <section id="tab1Panel2" class="js-tabs__panel">

        {{-- Таблица комментариев для текущей страницы. В функции foreach заменить модель для вызова комментов --}}

            <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

                @livewire('admin.comments', ['model' => $manual, 'user' => null, 'users' => $users])

            </div>

        {{-- Конец таблицы комментариев --}}

    </section>

    <section id="tab1Panel3" class="js-tabs__panel">
        <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
            @livewire('admin.create-links')
        </div>
    </section>


    </div>

    </div>
@endsection
@push('js')
    <script src="{{ asset('js/admin/prism.min.js') }}"></script>
@endpush
