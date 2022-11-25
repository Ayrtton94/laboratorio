<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matriz extends Model
{
	use HasFactory;
	protected $table = "matrices";
	protected $fillable = [
		'description'
	];

	public function muestras()
    {
        return $this->hasMany(Muestra::class);
    }

	public function prueba()
    {
        return $this->hasMany(Prueba::class);
    }

}
