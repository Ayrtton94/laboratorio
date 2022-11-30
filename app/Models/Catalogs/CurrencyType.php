<?php

namespace App\Models\Catalogs;
use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    
    protected $table = "cat_currency_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'symbol',
        'description',
    ];
}