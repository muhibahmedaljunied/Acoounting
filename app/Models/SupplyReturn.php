<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyReturn extends Model
{
    protected $fillable = [
        'supply_id','date','note'
    ];

    public function supply()
    {
        return $this->belongsTo(Sale::class);
    }

    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }
}
