<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresentacionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required'
        ];
    }
}
