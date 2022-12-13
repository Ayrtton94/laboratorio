<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

	protected $table = "schedule";
	protected $fillable = [
		'description',
		'hour_start',
		'hour_end',
		'status'
	];


	public function persons()
    {
		return $this->hasMany(Person::class, 'id');
    }
}
