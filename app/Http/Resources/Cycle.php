<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class Cycle extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return $this->map(function($cycle){
        return [
          'id' => $cycle->id,
          'initialized_at' => $cycle->initialized_at->format('Y-m-d'),
          'finalized_at' => $cycle->finalized_at->format('Y-m-d'),
          'active' => $cycle->active
        ];
      });
    }
}
