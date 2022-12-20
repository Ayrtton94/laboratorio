<?php

namespace App\Inputs;

use App\Models\Person as PersonModel;

class PersonInput
{
    public static function set($person_id)
    {
        $query =  PersonModel::query();
        if($person_id == 1)
        {
            $query->with('identity_document');
        }else{
            $query->with('identity_document', 'country', 'department', 'province', 'district');
        }
        $person = $query->find($person_id);

        if(!$person) {
            return null;
        }

        return [
            'identity_document_id' => $person->identity_document_id,
            'identity_document' => [
                'id' => $person->identity_document_id,
                'description' => $person->identity_document->description,
            ],
            'number' => $person->number,
            'name' => $person->name,
            'country_id' => $person->country_id,
            'country' => [
                'id' => $person->country_id,
                'description' => $person_id == 1 ? 'PE' : optional($person->country)->description,
            ],
            'department_id' => $person->department_id,
            'department' => [
                'id' => $person->department_id,
                'description' =>  $person_id == 1 ? '' : optional($person->department)->description,
            ],
            'province_id' => $person->province_id,
            'province' => [
                'id' => $person->province_id,
                'description' => $person_id == 1 ? '' :  optional($person->province)->description,
            ],
            'district_id' => $person->district_id,
            'district' => [
                'id' => $person->district_id,
                'description' =>  $person_id == 1 ? '' : optional($person->district)->description,
            ],
            'address' => $person->address,
            'email' => $person->email,
            'telephone' => $person->telephone
        ];
    }
}
