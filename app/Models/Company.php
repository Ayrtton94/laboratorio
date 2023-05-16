<?php

namespace App\Models;

use App\Models\IdentityDocument;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
	protected $fillable = [
        'identity_document_id',
        'number',
        'name',
        'email',
        'telephone',
        'ruc',
        'business_name',
        'status',
        'address',
        'department_id',
        'province_id',
        'district_id'
    ];

    public function identity_document_type()
    {
        return $this->belongsTo(IdentityDocumentType::class, 'identity_document_id');
    }
}
