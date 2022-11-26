<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoOrden extends Model
{
    use HasFactory;
	protected $table = "tipo_orden";
	protected $fillable = [
		'name',
		'estado'
	];
}
