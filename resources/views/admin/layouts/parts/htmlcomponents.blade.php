<div class="grid gap-xs">
@foreach ($items as $item)
<div class="col-2@md">
    <h4>{{ $loop->iteration }}. {{ $item->name }}</h4>

    <img class="border border-sm padding-sm radius-lg" src="{{ $item->getFirstMediaUrl('htmlcomponents') }}" aria-controls="component-{{ $loop->iteration }}">

    <div id="component-{{ $loop->iteration }}" class="is-hidden js-collapse" data-collapse-animate="on">

        <div class="margin-top-xs padding-xs bg-dark radius-md">

            <pre><code class="language-html">{{ $item->code }}</code></pre>

        </div>
      </div>

</div>
@endforeach
</div>