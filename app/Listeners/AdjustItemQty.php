<?php

namespace App\Listeners;

use App\Events\QuotationCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdjustItemQty
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
     * @param  QuotationCreated  $event
     * @return void
     */
    public function handle(QuotationCreated $event)
    {
        if($event->quotation->iva)
          $event->quotation->qty = $event->quotation->qty * 1.16;
        $event->quotation->item->specification->qty -= $event->quotation->qty;
        $event->quotation->item->specification->save();
    }
}
