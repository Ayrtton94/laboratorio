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
			'condicion'=> 'required',
			'time_entrega'=> 'required'
        ];
    }
}
