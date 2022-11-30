<?php

namespace App\Models\Catalogs;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = "cat_payment_methods";
    public $incrementing = false;
}