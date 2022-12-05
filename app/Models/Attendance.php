<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

	protected $table = 'attendance';
	protected $fillable = [
		'staff_id',
		'date_of_issue',
		'hour_start',
		'hour_end',
		'hour_start_1',
		'hour_end_1',
		'delays_min',
		'ouput_min',
		'extra_hours'
	];

	public function persons()
    {
		return $this->hasMany(Person::class, 'id');
    }
}
