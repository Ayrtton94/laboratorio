<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'last_name' => 'required',
            'document' => 'required',
            'sexo' => 'required',
            'birth_date' => 'required',
            'lugar_nacimiento' => 'required',
            'ocupacion' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'country_id' => 'required',
			'department_id' => 'required',
			'province_id' => 'required',
            // 'district_id' => 'required'
        ];
    }
}
