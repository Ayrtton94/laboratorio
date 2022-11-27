<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muestra extends Model
{
	use HasFactory;
	protected $table = "muestras";
	protected $fillable = [
		'matriz_id',
		'description',
		'estado'
	];

	public function matriz(){
		return $this->belongsTo(Matriz::class,'matriz_id');
	}

	public function prueba()
    {
        return $this->hasMany(Prueba::class);
    }

}
