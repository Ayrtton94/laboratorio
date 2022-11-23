<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PruebaCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
            return [
                'id' => $row->id,
				'matriz' => optional($row->matriz)->description,
				'muestra' => optional($row->muestra)->description,
				'name' => $row->name,
				'price' => $row->price,
				'laboratorio' => optional($row->laboratorio)->name,
				'metodo' => optional($row->metodo)->name,
				'condicion' => $row->condicion,
				'time_entrega' => $row->time_entrega,
				'estado' => $row->estado ? 0 : 1,
            ];
        });
    }
}
