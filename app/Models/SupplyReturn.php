<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyReturn extends Model
{
    protected $fillable = [
        'supply_id','date','note'
    ];
}
