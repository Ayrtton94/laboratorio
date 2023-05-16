<?php

namespace App\Models;

use App\Models\Country;
use App\Models\District;
use App\Models\Province;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\IdentityDocument;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Person extends Model
{
	use HasFactory;
	use SoftDeletes;
    protected $table = 'persons';
	protected $with = ['identity_document'];
    protected $fillable = [
        'type',
        'identity_document_id',
        'number',
        'name',
		'ap_lastname',
		'am_lastname',
        'country_id',
        'department_id',
        'province_id',
        'district_id',
        'address',
		'reference_address',
        'email',
        'telephone',
		'additional_phone',
		'sexo',
		'status',
		'imagen',
		'path_imagen',
		'signature',
		'user_account',
		'area_id',
		'schedule_id'
    ];

    public function identity_document()
    {
        return $this->belongsTo(IdentityDocument::class, 'identity_document_id');
    }

	public function attendance()
    {
        return $this->hasMany(Attendance::class, 'staff_id');
    }

	public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

	public function areas()
    {
        return $this->belongsTo(Area::class);
    }

	public function user()
    {
		return $this->hasMany(User::class, 'staff_id');
    }

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

    public function scopeWhereType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getAddressFullAttribute()
    {
        $address = trim($this->address);
        $address = ($address === '-' || $address === '')?'':$address.' ,';
        if ($address === '') {
            return '';
        }

        if(!is_null($this->department_id) && !is_null($this->province_id) && !is_null($this->district_id))
        {
            return "{$address} {$this->department->description} - {$this->province->description} - {$this->district->description}";
        }
        else {
            return $address;
        }
    }
}