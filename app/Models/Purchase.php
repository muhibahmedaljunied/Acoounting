<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id','supplier_name','sub_total','tax_amount','date','grand_total','status',' discount '
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


    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

}
