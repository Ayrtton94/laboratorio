<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderLaboratorioCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {

            return [
                'id' => $row->id,
                'usuario' => optional($row->user)->name,
                'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                'time_of_issue' => $row->time_of_issue,
                'number' => $row->number_full,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'currency_type_id' => $row->currency_type_id,
                'responsable_id' => optional($row->staff)->name,
                'total_value' => $row->total_value,
                'total_igv' => $row->total_igv,
                'total' => $row->total,

                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
                'estado' => $row->estado


            ];
        });
    }
}
