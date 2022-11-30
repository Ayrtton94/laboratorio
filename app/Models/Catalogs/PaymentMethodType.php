<?php

namespace App\Models\Catalogs;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodType extends Model
{
    protected $table = "cat_payment_method_types";
    public $incrementing = false;
}