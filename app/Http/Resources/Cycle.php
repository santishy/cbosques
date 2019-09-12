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
          'created_at' => $cycle->created_at->format('Y-m-d'),
          'finalized_at' => Carbon::create($cycle->finalized_at,'America/Mexico_City')->toDateString(),
          //'finalized_at' => date('Y-m-d',strtotime($cycle->finalized_at)),
          'active' => $cycle->active
        ];
      });
    }
}
