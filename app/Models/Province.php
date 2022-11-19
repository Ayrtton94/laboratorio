<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
	use HasFactory;
	
	public $incrementing = false;
	public $timestamps = false;
	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	static function idByDescription($description)
	{
		$province = Province::where('description', $description)->first();
		if ($province) {
			return $province->id;
		}
		return '1501';
	}
}
