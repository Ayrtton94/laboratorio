<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        $type = $this->input('type');
        $identity_document_id = $this->input('identity_document_id');
        
        return [
            'number' => [
                (in_array($identity_document_id,[0,4,7]) )?'required':'numeric',
                'required',
                "min:8",
                Rule::unique('persons')->where(function ($query) use($id, $type) {
                    return $query->where('type', $type)
                                 ->where('id', '<>' ,$id);
                })
            ],
            'name' => [
                'required',
                Rule::unique('persons')->where(function ($query) use($id, $type) {
                    return $query->where('type', $type)
                                 ->where('id', '<>' ,$id);
                })
            ],
            'identity_document_id' => [
                'required',
            ],
            'email' => [
                'nullable',
                'email',
            ],
        ];
    }
}