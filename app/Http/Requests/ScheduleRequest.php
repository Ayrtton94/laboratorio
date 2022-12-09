<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
	
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
		return [
			'description' => 'required',
			'hour_start' => 'required',
            'hour_end' => 'required'
        ];
    }

	public function messages(){
		return [
			'description.required' => 'Nombre Obligatorio',
			'hour_start.required' => 'Campo obligatorio',
			'hour_end.required' => 'Campo obligatorio'
		];
	}
}
