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
        $newIVA = $event->quotation->getAttribute('iva');
        $oldIVA = $event->quotation->getOriginal('iva');
        // $event->quotation->item->specification->qty = $oldIVA;
        // return $event->quotation->item->specification->save();
        // if(empty($oldIVA))
        //   $event->quotation->item->specification->qty =0;
        // else
        if($newStatus == 'ACEPTADO' && $oldStatus == 'ACEPTADO'){
          //$event->quotation->item->specification->qty = 20000;
          if(!$oldIVA && $newIVA)
            $event->quotation->item->specification->qty += $event->quotation->item->specification->qty*0.16;
          elseif($oldIVA && !$newIVA)
            $event->quotation->item->specification->qty -= $event->quotation->iva();
        }
        elseif($oldStatus == 'ACEPTADO'){
          $event->quotation->item->specification->qty += $event->quotation->total();
        }elseif($newStatus == 'ACEPTADO')
          $event->quotation->item->specification->qty -= $event->quotation->total();
        $event->quotation->item->specification->save();
    }
}
