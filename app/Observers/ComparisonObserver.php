<?php

namespace App\Observers;

use App\Models\Comparison;

class ComparisonObserver
{
    /**
     * Handle the Comparison "created" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function created(Comparison $comparison)
    {
        //
    }

    /**
     * Handle the Comparison "updated" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function updated(Comparison $comparison)
    {
        //
    }

    /**
     * Handle the Comparison "deleted" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function deleted(Comparison $comparison)
    {
        //
    }

    /**
     * Handle the Comparison "restored" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function restored(Comparison $comparison)
    {
        //
    }

    /**
     * Handle the Comparison "force deleted" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function forceDeleted(Comparison $comparison)
    {

        $comparison->comments->each->delete();

    }
}
