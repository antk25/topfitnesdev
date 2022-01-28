<div>
<div class="text-center margin-bottom-sm">
<button wire:click.prevent='refresh' wire:loading.class='btn-states--state-b' wire:loading.class.remove="btn-states" class="reset btn-states btn-states--preserve-width btn btn--success btn--sm">
  <span class="btn-states__content-a">Обновить</span>

  <span class="btn-states__content-b inline-flex flex-center">
    <svg class="icon icon--is-spinning" aria-hidden="true" viewBox="0 0 16 16"><title>Loading</title><g stroke-width="1" fill="currentColor" stroke="currentColor"><path d="M.5,8a7.5,7.5,0,1,1,1.91,5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path></g></svg>
  </span>
</button>
</div>
@foreach ($images as $image)
<div class="gap-xxs grid border border-contrast-low radius-md margin-bottom-sm padding-sm">
    <div class="col-4 text-center">
        {{ $image('thumb') }}
        <p class="color-contrast-medium">{{ $image->human_readable_size }}</p>
    <button class="btn btn--sm btn--accent" wire:click.prevent="imageDelete({{ $image->id }})">
        <svg class="icon" viewBox="0 0 20 20">
            <title>Удалить навсегда</title>

            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <line x1="1" y1="5" x2="19" y2="5"></line>
              <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5"></path>
              <path d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8"></path>
            </g>
          </svg>
    </button>
    </div>
    <div class="col-8 text-center">
                @if ($imageId == $image->id)
                <form wire:submit.prevent="updateName({{ $image->id }})">
                    <div class="input-group">
                        <div class="input-group__tag">alt</div>
                    <input class="form-control flex-grow width-100% text-xs" type="text" wire:model="imageName">
                    <button title="Обновить" class="btn btn--success" type="submit">
                        <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
                            <g>
                                <path
                                    d="M8,3c1.179,0,2.311,0.423,3.205,1.17L8.883,6.492l6.211,0.539L14.555,0.82l-1.93,1.93 C11.353,1.632,9.71,1,8,1C4.567,1,1.664,3.454,1.097,6.834l1.973,0.331C3.474,4.752,5.548,3,8,3z">
                                </path>
                                <path
                                    d="M8,13c-1.179,0-2.311-0.423-3.205-1.17l2.322-2.322L0.906,8.969l0.539,6.211l1.93-1.93 C4.647,14.368,6.29,15,8,15c3.433,0,6.336-2.454,6.903-5.834l-1.973-0.331C12.526,11.248,10.452,13,8,13z">
                                </path>
                            </g>
                        </svg>
                    </button>
                </div>
                </form>
                @else
                <div class="input-group">
                    <div class="input-group__tag">alt</div>
                    <input class="form-control flex-grow width-100% text-xs" type="text" readonly value="{{ $image->name }}">
                    <button class="btn btn--primary" wire:click='imageEdit({{ $image->id }})' type="submit">Edit</button>
                </div>
                @endif

                @if (request()->segment(2) != 'bracelets' && request()->segment(2) != 'ratings')

                    <span class="text-xs">Просто картинка</span>
                    <div class="text-sm padding-xxxs bg-contrast-lower margin-y-xxxs">&lt;img.{{ $loop->index }}&gt;</div>

                    <span class="text-xs">С увеличением по клику</span>
                    <div class="text-sm padding-xxxs bg-contrast-lower margin-y-xxxs">&lt;box_img.{{ $loop->index }}&gt;</div>

                    <span class="text-xs">С увеличением и размером 50%</span>
                    <div class="text-sm padding-xxxs bg-contrast-lower margin-y-xxxs">&lt;box_img_half.{{ $loop->index }}&gt;</div>

                @endif

    </div>
</div>
@endforeach
</div>