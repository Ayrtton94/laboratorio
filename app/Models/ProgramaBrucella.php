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
		'supplier_id',
		'peso',
		'parcela',
        'v_produccion',
		't_hato',
		'accion',
		'asignar_modulo'
	];


	public function muestra()
    {
        return $this->belongsTo(Muestra::class,'muestra_id');
    }

	public function supplier()
    {
        return $this->belongsTo(Person::class,'supplier_id');
    }

}
