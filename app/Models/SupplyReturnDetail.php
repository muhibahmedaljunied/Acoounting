<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyReturnDetail extends Model
{
    protected $fillable = [
        'supply_return_id','product_id','quantity'
    ];
}
