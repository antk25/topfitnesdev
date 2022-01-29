<?php

namespace App\Observers;

use App\Models\Manual;

class ManualObserver
{
    /**
     * Handle the Manual "created" event.
     *
     * @param  \App\Models\Manual  $manual
     * @return void
     */
    public function created(Manual $manual)
    {
        //
    }

    /**
     * Handle the Manual "updated" event.
     *
     * @param  \App\Models\Manual  $manual
     * @return void
     */
    public function updated(Manual $manual)
    {
        //
    }

    /**
     * Handle the Manual "deleted" event.
     *
     * @param  \App\Models\Manual  $manual
     * @return void
     */
    public function deleted(Manual $manual)
    {
        //
    }

    /**
     * Handle the Manual "restored" event.
     *
     * @param  \App\Models\Manual  $manual
     * @return void
     */
    public function restored(Manual $manual)
    {
        //
    }

    /**
     * Handle the Manual "force deleted" event.
     *
     * @param  \App\Models\Manual  $manual
     * @return void
     */
    public function forceDeleted(Manual $manual)
    {

        $manual->comments->each->delete();

    }
}
