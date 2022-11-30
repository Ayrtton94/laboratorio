<?php

namespace App\Models\Catalogs;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{

    protected $table = "cat_document_types";
	public $incrementing = false;
	

	public function newQuery() {
		if(session()->has('MERCADO_ESPECIAL'))
		{
			if(session('MERCADO_ESPECIAL')->valor == 1){
				return parent::newQuery()
					->whereNotIn('id', ['100']);
			}
		}
		
		return parent::newQuery();
    } 
}