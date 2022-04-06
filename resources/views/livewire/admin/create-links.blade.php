<div>
    <label class="form-label margin-bottom-xxxs" for="select-this">Модель:</label>

    <div class="select">
        <select class="select__input btn btn--subtle" wire:model="selectedModel" name="select-this" id="selectedModel">
                <option value="">Выбрать модель</option>
                @foreach($model as $k => $v)
                <option value="{{ $v }}">{{ $k }}</option>
            @endforeach
        </select>

        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
    </div>

    @if(!is_null($selectedModel))
    <label class="form-label margin-bottom-xxxs" for="select-this">Страница:</label>

    <div class="select">
        <select class="select__input btn btn--subtle" wire:model="selectedLink" name="select-this" id="selectedLinks">
            <option value="">Выбрать страницу</option>
            @foreach($links as $item)
               <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>

        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
    </div>
    @endif
    <div class="margin-y-sm">
        <label class="form-label margin-bottom-xxxs" for="linkText">Текст ссылки:</label>
        <input class="form-control width-100%" wire:model.debounce.500ms="linkText" name="linkText" placeholder="Свой текст ссылки">
    </div>
    @if(!is_null($selectedLink))
    <p class="color-contrast-medium">Простая ссылка:</p>
       <div class="padding-sm bg-contrast-lower radius-md margin-y-sm">
          &lt;a href="{{ $domain }}/{{ $category }}{{ $link->slug }}"&gt;@if($linkText){{ $linkText }}@else{{ $link->name }}@endif&lt;/a&gt;
       </div>

    <p class="color-contrast-medium">Ссылка и картинка без оформления:</p>
        <div class="padding-sm bg-contrast-lower radius-md margin-y-sm">
            &lt;a href="{{ $domain }}/{{ $category }}{{ $link->slug }}"&gt;@if($linkText){{ $linkText }}@else{{ $link->name }}@endif&lt;/a&gt;<br>
            &lt;img src="@if ($link->getFirstMediaUrl('covers')) {{ $link->getFirstMediaUrl('covers') }} @else {{ $link->getFirstMediaUrl('bracelets') }} @endif"&gt;
            &lt;img src="@if ($link->getFirstMediaUrl('bracelets', 'thumb')) {{ $link->getFirstMediaUrl('bracelets', 'thumb') }} @else @endif"&gt;
        </div>


    <p class="color-contrast-medium">Баннер:</p>
        <div class="padding-sm bg-contrast-lower radius-md margin-y-sm">
            &lt;a class=&quot;banner&quot; href=&quot;{{ $domain }}/{{ $category }}{{ $link->slug }}&quot; aria-label=&quot;@if($linkText){{ $linkText }}@else{{ $link->name }}@endif&quot;&gt;<br>
            &lt;div class=&quot;grid flex-row-reverse@md&quot;&gt;<br>
                &lt;div class=&quot;col-6@md overflow-hidden&quot; aria-hidden=&quot;true&quot;&gt;<br>
                &lt;div class=&quot;banner__figure width-100%&quot; style=&quot;background-image: url(@if ($link->getFirstMediaUrl('covers')) {{ $link->getFirstMediaUrl('covers') }} @else {{ $link->getFirstMediaUrl('bracelets') }} @endif);&quot;&gt;&lt;/div&gt;<br>
                &lt;/div&gt;<br><br>

                &lt;div class=&quot;col-6@md&quot;&gt;<br>
                &lt;div class=&quot;text-component text-space-y-md height-100% flex flex-column padding-md padding-lg@md&quot;&gt;<br>
                    &lt;p class=&quot;text-lg text-bold&quot;&gt;@if($linkText){{ $linkText }}@else{{ $link->name }}@endif&lt;/p&gt;
                    &lt;p class=&quot;text-md font-bold&quot;&gt;Перейти&lt;/p&gt;<br>
                    &lt;p class=&quot;margin-top-sm margin-top-md@md&quot;&gt;&lt;span class=&quot;banner__link&quot;&gt;&lt;i&gt;@if($linkText){{ $linkText }}@else{{ $link->name }}@endif&lt;/i&gt;&lt;/span&gt;&lt;/p&gt;<br>
                &lt;/div&gt;<br>
                &lt;/div&gt;<br>
            &lt;/div&gt;<br>
            &lt;/a&gt;
        </div>

        <p class="color-contrast-medium">Маленький баннер:</p>
        <div class="padding-sm bg-contrast-lower radius-md margin-y-sm">
            &lt;ul class=&quot;list-v3&quot;&gt;
            &lt;li class=&quot;list-v3__item flex gap-sm items-center@sm&quot;&gt;
                &lt;figure class=&quot;list-v3__figure&quot;&gt;
                &lt;img class=&quot;block width-100% object-cover&quot; src=&quot;@if ($link->getFirstMediaUrl('covers')) {{ $link->getFirstMediaUrl('covers') }} @else {{ $link->getFirstMediaUrl('bracelets') }} @endif&quot; alt=&quot;@if($linkText){{ $linkText }}@else{{ $link->name }}@endif&quot;&gt;
                &lt;/figure&gt;

                &lt;div class=&quot;text-component text-space-y-sm&quot;&gt;
                &lt;p class=&quot;text-base font-bold&quot;&gt;&lt;a class=&quot;color-contrast-higher list-v3__link&quot; href=&quot;{{ $domain }}/{{ $category }}{{ $link->slug }}&quot;&gt;@if($linkText){{ $linkText }}@else{{ $link->name }}@endif&lt;/a&gt;&lt;/p&gt;
                &lt;p class=&quot;text-sm color-contrast-medium&quot;&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit&lt;/p&gt;
                &lt;/div&gt;
            &lt;/li&gt;
            &lt;/ul&gt;
        </div>


    @endif

</div>
