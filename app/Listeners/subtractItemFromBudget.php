<?php

namespace App\Listeners;

use App\Events\ItemInsert;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Budget;

class subtractItemFromBudget
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
     * @param  ItemInsert  $event
     * @return void
     */
    public function handle(ItemInsert $event)
    {
        $budget = Budget::find($event->item->budget_id);
        if($budget){
          $qty = $budget->specification->qty - $event->item->specification->qty;
          $budget->specification->update(['qty'=> $qty]);
        }
    }
}
