<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubEspecie extends Model
{
	use HasFactory;
	protected $table = "subespecies";
	protected $fillable = [
		'especie_id',
		'description'
	];

	public function especie(){
		return $this->belongsTo(Especie::class,'especie_id');
	}

}
