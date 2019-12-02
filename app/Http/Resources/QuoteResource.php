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
          'qty' => $this->qty,
          'archive' => explode('/',$this->archive)[1], // Aquí corto el nombre del archivo de la ruta
          'status' => $this->status,
          'created_at' => $this->created_at->format('Y M d'),
          'id' => $this->id,
          'user_name' => $this->user->name,
          'enum_iva' => $this->iva,
          'iva' => $this->iva(),
          'total' => $this->total(),
          'qty_format' =>number_format($this->qty,2),
          'iva_format' => number_format($this->iva(),2),
          'total_format' => number_format($this->total(),2),
          'cycle_id' => $this->cycle_id,
          'item_id' => $this->item_id,
          'department_id' => $this->department_id,
        ];
    }
}
