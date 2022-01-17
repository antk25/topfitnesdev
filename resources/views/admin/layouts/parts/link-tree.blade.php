<nav class="tree js-tree">
    <ul class="tree__nodes">
        <li class="tree__node tree__node--expanded">
            <button class="reset tree__item js-tree__node-control" type="button">
                <svg class="tree__arrow-icon icon color-contrast-higher opacity-50%" viewBox="0 0 16 16"><title>Toggle Group Content</title><path d="M10.724,7.553l-5-2.5A.5.5,0,0,0,5,5.5v5a.5.5,0,0,0,.724.447l5-2.5a.5.5,0,0,0,0-.894Z"/></svg>

                <svg class="tree__label-icon icon color-primary" viewBox="0 0 16 16" aria-hidden="true"><path d="M15,3H8V2A1,1,0,0,0,7,1H1A1,1,0,0,0,0,2V5H16V4A1,1,0,0,0,15,3Z" opacity="0.5"/><path d="M16,5H0v8a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2Z"/></svg>

                <span class="tree__label">Блог</span>
            </button>

            <ul class="tree__nodes">
                @foreach($posts as $item)
                <li class="tree__node">
                    <a class="tree__item" href="/blog/{{ $item->slug }}">
                        <!-- 👇 used to occupy the same space of the arrow icon -->
                        <span class="tree__arrow-icon-spacer" aria-hidden="true"></span>

                        <svg class="tree__label-icon icon color-contrast-higher opacity-50%" height="16" viewBox="0 0 16 16"><title>Link Node</title><path d="M14,16H2a1,1,0,0,1-1-1V1A1,1,0,0,1,2,0H9V6h6v9A1,1,0,0,1,14,16Z"/><polygon points="9 6 9 0 15 6 9 6" opacity="0.5"/></svg>

                        <span class="tree__label">{{ $item->name }}</span>
                    </a>
                </li>
                @endforeach

            </ul>
        </li>
        <li class="tree__node tree__node--expanded">
            <button class="reset tree__item js-tree__node-control" type="button">
                <svg class="tree__arrow-icon icon color-contrast-higher opacity-50%" viewBox="0 0 16 16"><title>Toggle Group Content</title><path d="M10.724,7.553l-5-2.5A.5.5,0,0,0,5,5.5v5a.5.5,0,0,0,.724.447l5-2.5a.5.5,0,0,0,0-.894Z"/></svg>

                <svg class="tree__label-icon icon color-primary" viewBox="0 0 16 16" aria-hidden="true"><path d="M15,3H8V2A1,1,0,0,0,7,1H1A1,1,0,0,0,0,2V5H16V4A1,1,0,0,0,15,3Z" opacity="0.5"/><path d="M16,5H0v8a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2Z"/></svg>

                <span class="tree__label">Рейтинги</span>
            </button>

            <ul class="tree__nodes">
                @foreach($ratings as $item)
                    <li class="tree__node">
                        <a class="tree__item" href="/{{ $item->slug }}">
                            <!-- 👇 used to occupy the same space of the arrow icon -->
                            <span class="tree__arrow-icon-spacer" aria-hidden="true"></span>

                            <svg class="tree__label-icon icon color-contrast-higher opacity-50%" height="16" viewBox="0 0 16 16"><title>Link Node</title><path d="M14,16H2a1,1,0,0,1-1-1V1A1,1,0,0,1,2,0H9V6h6v9A1,1,0,0,1,14,16Z"/><polygon points="9 6 9 0 15 6 9 6" opacity="0.5"/></svg>

                            <span class="tree__label">{{ $item->name }} (&lt;a class="link" hreh="{{ $item->slug }}"&lt; )</span>
                        </a>
                    </li>
                @endforeach

            </ul>
        </li>

    </ul>
</nav>
