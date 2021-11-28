<div>
    <form wire:submit.prevent="import" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="file-upload inline-block">
         <label for="importFile" class="file-upload__label btn btn--primary">
           <span class="flex items-center">
             <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="2"><path  stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path><path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path><path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path></g></svg>

             <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить</span>
           </span>
         </label>

         <input type="file" class="file-upload__input" wire:model="importFile" id="importFile">

         @error('import_file')
            {{ $message }}
         @enderror
       </div>
        <button class="btn">Импортировать</button>
       </form>


       @if ($importing && !$importFinished)

       <div wire:poll="updateImportProgress">Импортируется...</div>

       @endif

       @if ($importFinished)
          Импорт завершен
       @endif


</div>
