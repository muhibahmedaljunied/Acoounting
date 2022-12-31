<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CashReturnDetail extends Model
{
    protected $fillable = [
        'cash_return_id','product_id','quantity'
    ];
}
