<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerBrucelaRequest extends FormRequest
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
            'identity_document_id' => 'required',
            'name' => 'required',
            'number'=> 'required',
            'name'=> 'required',
            'address'=> 'required',
            'country_id'=> 'required',
            'department_id'=> 'required',
            'province_id'=> 'required',
            'district_id'=> 'required',
            'email'=> 'required',
            'telephone'=> 'required',
            'status'=> 'required',
            'code_porongo'=> 'required',
            'route'=> 'required',
            'companies'=> 'required',
            'tipo'=> 'required'
        ];
    }

    public function messages()
    {
		return [
			'name.required' => 'Nombre obligatorio'
		];
	}
}
