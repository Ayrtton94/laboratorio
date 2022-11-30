<?php

namespace App\Models\Catalogs;
use Illuminate\Database\Eloquent\Model;

class DetractionType extends Model
{

    protected $table = "cat_detraction_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'percentage',
        'operation_type_id',
        'description',
    ];

}