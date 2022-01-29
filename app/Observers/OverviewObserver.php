<?php

namespace App\Observers;

use App\Models\Overview;

class OverviewObserver
{
    /**
     * Handle the Overview "created" event.
     *
     * @param  \App\Models\Overview  $overview
     * @return void
     */
    public function created(Overview $overview)
    {
        //
    }

    /**
     * Handle the Overview "updated" event.
     *
     * @param  \App\Models\Overview  $overview
     * @return void
     */
    public function updated(Overview $overview)
    {
        //
    }

    /**
     * Handle the Overview "deleted" event.
     *
     * @param  \App\Models\Overview  $overview
     * @return void
     */
    public function deleted(Overview $overview)
    {
        //
    }

    /**
     * Handle the Overview "restored" event.
     *
     * @param  \App\Models\Overview  $overview
     * @return void
     */
    public function restored(Overview $overview)
    {
        //
    }

    /**
     * Handle the Overview "force deleted" event.
     *
     * @param  \App\Models\Overview  $overview
     * @return void
     */
    public function forceDeleted(Overview $overview)
    {

        $overview->comments->each->delete();

    }
}
