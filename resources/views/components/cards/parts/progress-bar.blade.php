<div
    class="progress-bar progress-bar--color-update js-progress-bar flex flex-column items-center margin-y-xxs">
    <p class="sr-only" aria-live="polite" aria-atomic="true">Оценка составляет
        <span
            class="js-progress-bar__aria-value">{{ $grade->pivot->value * 10 }}%</span>
    </p>

    <div class="margin-y-xxs width-100%">{{ $grade->name }} <span
            class="text-bold float-right">{{ number_format($grade->pivot->value, 1) }}</span>
    </div>

    <div class="progress-bar__bg width-100%" aria-hidden="true">
        <div class="progress-bar__fill"
            style="width: {{ $grade->pivot->value * 10 }}%;"></div>
    </div>
</div>