<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetail extends Model
{
    protected $fillable = ['purchase_return_id','store_product_id','product_id','store_id','status_id','quantity'];

    
}
