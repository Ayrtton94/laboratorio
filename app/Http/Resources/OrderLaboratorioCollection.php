<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderLaboratorioCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {

            return [
                'id' => $row->id,
                'usuario' => optional($row->user)->name,
                'date_of_issue' => $row->date_of_issue,
                'time_of_issue' => $row->time_of_issue,
                'number' => $row->number_full,
				'tipo_orden' => $row->tipoorden->name,
				'referencia' => $row->referencia,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'currency_type_id' => $row->currency_type_id,
                'responsable_id' => optional($row->staff)->name,
                'total_value' => $row->total_value,
                'total_igv' => $row->total_igv,
                'total' => $row->total,
                'created_at' => optional($row->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => optional($row->updated_at)->format('Y-m-d H:i:s'),
                'estado' => $row->estado,
				'status_paid' => $row->status_paid,
				'status_order' => $row->status_order
            ];
        });
    }
}
