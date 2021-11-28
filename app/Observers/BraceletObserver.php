<?php

namespace App\Observers;

use App\Models\Bracelet;

class BraceletObserver
{
    /**
     * Handle the Bracelet "created" event.
     *
     * @param  \App\Models\Bracelet  $bracelet
     * @return void
     */
    public function created(Bracelet $bracelet)
    {
        //
    }

    /**
     * Handle the Bracelet "updated" event.
     *
     * @param  \App\Models\Bracelet  $bracelet
     * @return void
     */
    public function updated(Bracelet $bracelet)
    {
       



    }

    /**
     * Handle the Bracelet "deleted" event.
     *
     * @param  \App\Models\Bracelet  $bracelet
     * @return void
     */
    public function deleted(Bracelet $bracelet)
    {
        //
    }

    /**
     * Handle the Bracelet "restored" event.
     *
     * @param  \App\Models\Bracelet  $bracelet
     * @return void
     */
    public function restored(Bracelet $bracelet)
    {
        //
    }

    /**
     * Handle the Bracelet "force deleted" event.
     *
     * @param  \App\Models\Bracelet  $bracelet
     * @return void
     */
    public function forceDeleted(Bracelet $bracelet)
    {
        //
    }

    protected function setPublishedAt (Bracelet $bracelet)
    {
        if ($bracelet->published_at == null && $bracelet->is_published) {

            $bracelet->published_at = Carbon::now()->format('d/m/Y');
        }
    }
}
