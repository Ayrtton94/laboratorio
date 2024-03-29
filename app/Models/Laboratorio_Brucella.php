<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorio_Brucella extends Model
{
    protected $table = "laboratorio_brucellas";
	protected $fillable = [
		'series_id',
        'date_of_issue',
        'customer_id',
        'responsable_id',
        'referencia',
        'temperatura',
        'date_of_muestra',
        'date_of_recepcion',
        'date_of_resultado',
        'observacion'
	];
}
