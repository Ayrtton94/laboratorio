<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Prueba;
use App\Models\Matriz;
use App\Models\Muestra;

class OrderLaboratorioResource extends JsonResource
{
    public function toArray($request)
{
    $items = [];
    foreach ($this->items as $item) {
        $prueba_id = $item->prueba_id;
        $matrizes = $item->matriz_id;
        $muestras = $item->muestra_id;

        $pruebas = Prueba::where('id', $prueba_id)->get();
        $matrizes = Matriz::select('description')->where('id', $matrizes)->get();
        $muestras = Muestra::select('description')->where('id', $muestras)->get();        

        foreach($matrizes as $matrize){
            foreach($muestras as $muestra){
                foreach($pruebas as $prueba){
                    return [
                        'id' => $this->id,
                        'usuario' => optional($this->user)->name,
                        'date_of_issue' => $this->date_of_issue,
                        'time_of_issue' => $this->time_of_issue,
                        'number' => $this->number_full,
                        'tipo_orden' => $this->tipoorden->name,
                        'referencia' => $this->referencia,
                        'customer_name' => optional($this->customer)->name,
                        'customer_number' => optional($this->customer)->number,
                        'currency_type_id' => $this->currency_type_id,
                        'responsable_id' => optional($this->staff)->name,
                        'total_value' => $this->total_value,
                        'total_igv' => $this->total_igv,
                        'total' => $this->total,
                        'created_at' => optional($this->created_at)->format('Y-m-d H:i:s'),
                        'updated_at' => optional($this->updated_at)->format('Y-m-d H:i:s'),
                        'estado' => $this->estado,
                        'status_paid' => $this->status_paid,
                        'status_order' => $this->status_order,
                        'especie_id' => $item->especie_id,
                        
                        'date_of_muestra' => $item->date_of_muestra,
                        'date_of_recepcion' => $item->date_of_recepcion,
                        'date_of_resultado' => $item->date_of_resultado,
                        'temperatura' => $item->temperatura,  
        
                        'matriz_id' => $matrize->description,
                        'muestra_id' => $muestra->description,
        
                        'quantity' => $item->quantity,
                        'observacion' => $item->observacion,
                        'referencia' => $this->referencia,
                        'prueba_id' => $prueba->name
                    ];        
                }
            }            
        }           
    }    
}
}
