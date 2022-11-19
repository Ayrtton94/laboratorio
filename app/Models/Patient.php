<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
	use HasFactory;
	protected $table = "patients";
	protected $fillable = [
		'name',
		'codigo_historial_clinico',
		'last_name',
		'document',
		'sexo',
		'birth_date',
		'lugar_nacimiento',
		'ocupacion',
		'email',
		'phone',
		'address',
		'country_id',
		'department_id',
		'province_id',
		'district_id',
        'imagen',
        'path_imagen'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function province()
	{
		return $this->belongsTo(Province::class);
	}

	public function district()
	{
		return $this->belongsTo(District::class);
	}
}
