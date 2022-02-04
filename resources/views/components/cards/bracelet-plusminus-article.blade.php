<div>
    <div class="text-component__block">
        <div class="text-divider"><span>Плюсы и минусы {{ $bracelet->name }}</span></div>
        <div class="grid gap-xs">
            <div class="col-6@sm">
                <p class="text-center text-md">Плюсы</p>

                <ul class="list list--icons">
                    @foreach ($bracelet->plus as $plus)
                        <li>
                            <div class="flex items-start">
                                <svg class="list__icon icon" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2" />
                                    <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                              stroke-linecap="square" stroke-miterlimit="10" stroke-width="2" />
                                </svg>

                                <div>{{ $plus }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-6@sm">
                <p class="text-center text-md">Минусы</p>
                <ul class="list list--icons">
                    @foreach ($bracelet->minus as $minus)
                        <li>
                            <div class="flex items-start">
                                <svg class="list__icon icon" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2" />
                                    <g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10"
                                       stroke-width="2">
                                        <line x1="7" y1="17" x2="17" y2="7" />
                                        <line x1="17" y1="17" x2="7" y2="7" />
                                    </g>
                                </svg>

                                <div>{{ $minus }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>
