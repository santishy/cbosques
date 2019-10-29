<?php

namespace App\Listeners;

use App\Events\UpdatedQuotation;
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
    public function handle(UpdatedQuotation $event)
    {
        $newStatus = $event->quotation->getAttribute('status');
        $oldStatus = $event->quotation->getOriginal('status');
        if($oldStatus == 'ACEPTADO'){
          $event->quotation->item->specification->qty += $event->quotation->total();
        }elseif($newStatus == 'ACEPTADO')
          $event->quotation->item->specification->qty -= $event->quotation->total();
        $event->quotation->item->specification->save();
    }
}
