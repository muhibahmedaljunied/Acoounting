<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentPurchase extends Model
{
    protected $fillable = ['purchase_id','payment_info','payment_status','paid','remaining'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    
}
