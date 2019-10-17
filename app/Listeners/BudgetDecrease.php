<?php

namespace App\Listeners;

use App\Events\UpdatedQuotation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Item;

class BudgetDecrease
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  UpdatedQuotation  $event
     * @return void
     */
    public function handle(UpdatedQuotation $event)
    {
        $item = Item::find($event->quotation->item_id);
        if($event->quotation->iva)
          $event->quotation->qty = $event->quotation->qty * 1.16;
        $item->specification->qty -= $event->quotation->qty;
        $item->specification->save();
    }
}
