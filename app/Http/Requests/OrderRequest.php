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

            'document_type_id' => 'required',
            'series' => 'required',
            'date_of_issue'=> 'required',
            'time_of_issue'=> 'required',

            'customer_id',
            'customer',
            'currency_type_id',
            'tporden_id' => 'required',
            'responsable_id' => 'required',
            'documento_referencia',

            'total_value',
            'total_igv',
            'total',
        ];
    }
}
