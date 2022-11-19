<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	use HasFactory;
	
	public $incrementing = false;
	public $timestamps = false;
	public function province()
	{
		return $this->hasMany(Province::class);
	}

	static function idByDescription($description)
	{
		$department = Department::where('description', $description)->first();
		if ($department) {
			return $department->id;
		}
		return '15';
	}
}
