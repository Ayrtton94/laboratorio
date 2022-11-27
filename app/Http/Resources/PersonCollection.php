<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PersonCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
			
            return [
                'id' => $row->id,
				'identity_document_id' => $row->identity_document_id,
                'number' => $row->number,
                'name' => $row->name,
				'ap_lastname' => $row->ap_lastname,
				'am_lastname' => $row->am_lastname,
				'address' => $row->address,
				'address' => $row->address,
				'email' => $row->email,
                'reference_address' => $row->reference_address,
				'additional_phone' => $row->additional_phone,
				'department_id' => $row->department_id,
				'province_id' => $row->province_id,
                'district_id' => $row->district_id,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
				'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
				'deleted_at' => optional($row->deleted_at)->format('Y-m-d H:i:s'),
				'status' => is_null($row->deleted_at) ? 1 : 0
            ];
        });
    }
}