<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewBudget extends JsonResource
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
        'concept' => $this->specification->concept,
        'qty' => $this->specification->qty,
        'cycle_id' => $this->specification->cycle_id
      ];
    }
}
