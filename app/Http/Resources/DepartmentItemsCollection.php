<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentItemsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return $this->collection->transform(function($item){
        return [
          'id' => $item->id,
          'concept' => $item->specification->concept,
          'specification_id' => $item->specification->id,
          'budget_id' => $item->budget_id,
          'qty' => $item->specification->qty,
          'cycle_id' => $item->specification->cycle_id,
          'department_item_id' => $item->pivot->id
        ];
      });
    }
}
