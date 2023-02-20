<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\DB;
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
				'telephone'=>$row->telephone,
				'ap_lastname' => $row->ap_lastname,
				'am_lastname' => $row->am_lastname,
				'name_full' => $row->type=='staff' ? $row->name.' '.$row->ap_lastname.' '. $row->am_lastname : '',
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
				'status' => is_null($row->deleted_at) ? 1 : 0,
				'user_account' => $row->user_account ? 1 : 0,
				'username' => $row->type=='staff' ? self::username($row) : [],
				'userpassword' => $row->type=='staff' ? '' : '',
				'rol' => $row->type=='staff' ? self::roleName($row) : [],
				'area_id' => $row->type=='staff' ? $row->area_id : '',
				'schedule_id' => $row->type=='staff' ? $row->schedule_id : ''
            ];
        });
    }

	public static function username($row){
		$useName = '';
		foreach ($row->user as $key => $value) {
			$useName.= optional($value)->email;
		}
		return $useName;
	}
	
	public static function roleName($row){
		$roleName = '';
		foreach($row->user as $value){
			$roleName.= optional($value->roles[0])->name;
		}
		return $roleName;
	}
}