<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentSale extends Model
{
    protected $fillable = ['sale_id','payment_info','payment_status','paid','remaining'];
}
