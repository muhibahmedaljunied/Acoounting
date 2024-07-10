<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CashReturn extends Model
{
    protected $fillable = [
        'cash_id','date','note'
    ];

    public function cash()
    {
        return $this->belongsTo(Cash::class);
    }

    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }
}
