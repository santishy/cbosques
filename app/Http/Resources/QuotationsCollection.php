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
          'iva' => $quotation->iva(),
          'total' => $quotation->total(),
          'user_name' => $quotation->user->name,
          'item_id' => $quotation->item_id,
          'cycle_id' => $quotation->cycle_id
        ];
      });
    }
}
