<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorio_detalles_brucellas extends Model
{
    protected $table = "laboratorio_detalles_brucellas";
	protected $fillable = [
		'laboratorio_brucellas_id',
        'ruta',
        'codigo',
        'nombre',
        'peso',
        'v_prodccion',
        't_hato',
        'estado',
        'dato1',
        'dato2'
	];
}
