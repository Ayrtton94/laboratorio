<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorio_detalles_brucellas extends Model
{
    protected $table = "laboratorio_detalles_brucellas";
	protected $fillable = [
		'brucellas_id',
        'temperatura',
        'date_of_muestra',
        'date_of_recepcion',
        'date_of_resultado',
        'observacion'
	];
}
