<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramaBrucellaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'muestra_id'=> 'required',
			'ruta'=> 'required',
			'parcela'=> 'required',
			'proveedor_id'=> 'required',
			'peso'=> 'required',
			'parcela'=> 'required',
			't_hato'=> 'required',
			'accion'=> 'required',
			'asignacion_modulo'=> 'required'
        ];
    }

	public function messages(){
		return [
			'muestra_id.required' => 'Muestra requerida',
			'ruta.required' => 'Ruta requerida',
			'parcela.required' => 'Parcela requerido',
			'proveedor_id.required' => 'Proveedor requerido',
			'peso.required' => 'Peso requerido',
			'parcela.required' => 'Parcela requerido',
			't_hato.required' => 'THato requerido',
			'accion.required' => 'Accion requerido',
			'asignacion_modulo.required' => 'AsignacionModulo requerido',
		];
	}
}
