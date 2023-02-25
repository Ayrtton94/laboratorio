<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'rol' => 'required',
            'person'=>'required',
			'name' => 'required',
            'email' => 'required'
        ];
    }

	public function messages(){
		return [
			'rol.required' => 'Rol requerido',
            'person.required' => 'Tipo requerido',
			'name.required' => 'Nombre obligatorio',
			'email.required' => 'Campo obligatorio'
		];
	}
}