<?php

namespace App\Models;

use App\Models\Catalogs\DocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

	protected $table = "series";

	protected $fillable = [
		'establishment_id',
		'document_type_id',
        'serie',
        'number'
	];

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = strtoupper($value);
    }

    public function scopeByNumber($query,$number)
    {
        $query->where('number',$number);
    }

}
