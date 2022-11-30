<?php

namespace App\Models\Catalogs;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    
    protected $table = "cat_account_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'description',
    ];
}