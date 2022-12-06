<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
