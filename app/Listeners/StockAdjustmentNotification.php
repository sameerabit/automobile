<?php

namespace App\Listeners;

use App\Events\StockAdjust;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StockAdjustmentNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StockAdjust  $event
     * @return void
     */
    public function handle(StockAdjust $event)
    {
        //
    }
}
