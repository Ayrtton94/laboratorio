<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
	use HasFactory;
	protected $table = "pruebas";
	protected $fillable = [
		'muestra_id',
		'matriz_id',
		'name',
		'price',
		'laboratorio_id',
		'metodo_id',
		'condicion',
		'time_entrega'
	];

}
