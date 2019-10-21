<?php

namespace App\Listeners;

use App\Events\UpdatedItem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdjustBudgetQty
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
     * @param  UpdatedItem  $event
     * @return void
     */
    public function handle(UpdatedItem $event)
    {
      $adjustedAmount = $event->item->specification->qty - $event->newQty;
      $event->item->budget->specification->qty +=   $adjustedAmount;
      $event->item->budget->specification->save();
    }
}
