<?php

namespace App\Listeners;

use App\Events\RideRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyDrivers
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
     * @param  \App\Events\RideRequest  $event
     * @return void
     */
    public function handle(RideRequest $event)
    {
        //
    }
}
