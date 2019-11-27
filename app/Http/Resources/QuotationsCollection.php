<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QuotationsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return $this->collection->transform(function($quotation){
        return [
          'id' => $quotation->id,
          'description' => $quotation->description,
          'qty' => $quotation->qty,
          'status' => $quotation->status,
          'created_at' => $quotation->created_at->format('Y M d'),
          'iva' => $quotation->iva(),
          'enum_iva' => $quotation->iva,
          'qty_format' =>number_format($quotation->qty,2),
          'iva_format' => number_format($quotation->iva(),2),
          'total_format' => number_format($quotation->total(),2),
          'total' => $quotation->total(),
          'user_name' => $quotation->user->name,
          'archive' => explode('/',$quotation->archive)[1],
          'item_id' => $quotation->item_id,
          'cycle_id' => $quotation->cycle_id
        ];
      });
    }
}
