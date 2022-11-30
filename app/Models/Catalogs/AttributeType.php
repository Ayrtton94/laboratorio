<?php

namespace App\Models\Catalogs;
use Illuminate\Database\Eloquent\Model;

class AttributeType extends Model
{

    protected $table = "cat_attribute_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'description',
    ];
}