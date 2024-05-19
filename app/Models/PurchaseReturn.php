<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    protected $fillable = ['purchase_id','quantity ',' date ','note'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
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
