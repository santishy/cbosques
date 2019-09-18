<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        'budget_id' => $this->budget_id,
        'concept' => $this->specification->concept,
        'qty' => $this->specification->qty,
        'cycle_id' => $this->specification->cycle_id
      ];
    }
}
