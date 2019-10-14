<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
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
          'description' => $this->description,
          'qty' => number_format($this->qty,2),
          'archive' => explode('/',$this->archive)[1], // Aquí corto el nombre del archivo de la ruta 
        ];
    }
}
