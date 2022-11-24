<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name' => 'required',
            'description' => 'required'
        ];
    }

	public function messages(){
		return [
			'name.required' => 'Nombre obligatorio',
			'description.required' => 'Campo obligatorio'
		];
	}
}
