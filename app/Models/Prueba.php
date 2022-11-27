<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
	use HasFactory;
	protected $table = "pruebas";
	protected $fillable = [
		'matriz_id',
		'muestra_id',
		'name',
		'price',
		'laboratorio_id',
		'metodo_id',
		'condicion',
		'time_entrega',
		'estado'
	];

	public function matriz()
    {
        return $this->belongsTo(Matriz::class,'matriz_id');
    }

	public function muestra()
    {
        return $this->belongsTo(Muestra::class,'muestra_id');
    }

	public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class,'laboratorio_id');
    }

	public function metodo()
    {
        return $this->belongsTo(Metodo::class,'metodo_id');
    }

}
