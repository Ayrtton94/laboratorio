<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'identity_document_id' => $this->identity_document_id,
            'number' => $this->number,
            'name' => $this->name,
            'email' => $this->email,
            'country_id' => $this->country_id,
            'department_id' => $this->department_id,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'address' => $this->address,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'address' => $this->address,
            'description' => $this->number . ' - ' . $this->name,
            'deleted_at' => optional($this->deleted_at)->format('Y-m-d H:i:s'),
            'estado' => is_null($this->deleted_at) ? 1 : 0,


        ];
    }
}
