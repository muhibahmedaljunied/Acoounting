<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    protected $fillable = ['sale_id','quantity ',' date ','note'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

}
