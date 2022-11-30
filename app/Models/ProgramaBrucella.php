<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaBrucella extends Model
{
	use HasFactory;
	protected $table = "programa_brucellas";
	
	protected $fillable = [
		'muestra_id',
		'ruta',
		'parcela',
		'proveedor_id',
		'peso',
		'parcela',
		't_hato',
		'accion',
		'asignacion_modulo'
	];


	public function muestra()
    {
        return $this->belongsTo(Muestra::class,'muestra_id');
    }

	public function proveedor()
    {
        return $this->belongsTo(Person::class,'proveedor_id');
    }

}
