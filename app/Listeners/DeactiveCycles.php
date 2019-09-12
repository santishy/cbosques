<?php

namespace App\Listeners;

use App\Events\CycleInsert;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Cycle;

class DeactiveCycles
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
     * @param  CycleInsert  $event
     * @return void
     */
    public function handle(CycleInsert $event)
    {
        Cycle::where('id','!=',$event->cycle->id)->update(['active'=>0]);
        session('cycle',$event->cycle);
    }
}
