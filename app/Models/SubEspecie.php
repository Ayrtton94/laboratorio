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

}
