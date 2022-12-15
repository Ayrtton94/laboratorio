<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

	protected $table = "series";

	protected $fillable = [
		'establishment_id',
		'document_type_id',
        'serie',
        'number'
	];
}
