<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id', 'grand_total','status',' discount '
    ];

    public function purchase_returns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }


    public function payable_notes()
    {
        return $this->hasMany(PayableNote::class);
    }

    public function payment_purchases()
    {
        return $this->hasMany(PaymentPurchase::class);
    }
}
