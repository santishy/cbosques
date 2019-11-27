<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BudgetWithItemsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return $this->collection->transform(function($budget){
        return [
          'id' => $budget->id,
          'concept' => $budget->specification->concept,
          'specification_id' => $budget->specification->id,
          'qty' => $budget->specification->qty,
          'cycle_id' => $budget->specification->cycle_id,
          'items' => new ItemsCollection($budget->items),
        ];
      });
    }
}
