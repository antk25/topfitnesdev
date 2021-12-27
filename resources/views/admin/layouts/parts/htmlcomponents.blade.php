<ol class="list list--ol">
@foreach ($items as $item)
<li>
    <a href="#0" class="text-sm" aria-controls="component-{{ $loop->iteration }}">{{ $item->name }}</a>

    <div id="component-{{ $loop->iteration }}" class="is-hidden js-collapse" data-collapse-animate="on">
        <p class="text-sm color-contrast-medium">
            {{ $item->about }}
        </p>

        <div class="margin-top-xs padding-xs bg-dark radius-md">

            <pre><code class="language-html">{{ $item->code }}</code></pre>

        </div>
      </div>
</li>
@endforeach
</ol>