<?php

namespace App\Models;

use App\Models\Country;
use App\Models\District;
use App\Models\Province;

use App\Models\IdentityDocument;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_brucela extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'customer_brucelas';
    protected $with = ['identity_document'];
    protected $fillable = [
        'identity_document_id',
        'number',
        'name',
        'address',
        'country_id',
        'department_id',
        'province_id',
        'district_id',
        'email',
        'telephone',
        'status',
        'code_porongo',
        'route',
        'companies',
        'customer_brucelas',
        'tipo'
    ];

    public function identity_document()
    {
        return $this->belongsTo(IdentityDocument::class, 'identity_document_id');
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


}
