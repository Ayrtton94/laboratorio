<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
//            'series' => 'required',
            'date_of_issue'=> 'required',
            'customer_id',
            'tporden_id' => 'required',
            'responsable_id' => 'required'
        ];
    }
}
