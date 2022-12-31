<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CashReturn extends Model
{
    protected $fillable = [
        'cash_id','date','note'
    ];
}
