<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PruebaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'muestra_id'=> 'required',
			'matriz_id'=> 'required',
			'name'=> 'required',
			'price'=> 'required',
			'laboratorio_id'=> 'required',
			'metodo_id'=> 'required',
			'time_entrega'=> 'required'
        ];
    }

	public function messages(){
		return [
			'name.required' => 'Nombre obligatorio',
			'muestra_id.required' => 'Muestra requerida',
			'matriz_id.required' => 'Matriz requerida',
			'laboratorio_id.required' => 'Laboratorio requerido',
			'metodo_id.required' => 'Metodo requerido',
			'price.required' => 'Precio requerido',
		];
	}
}
