<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MuestraRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'matriz_id' => 'required',
            'description' => 'required'
        ];
    }
}
