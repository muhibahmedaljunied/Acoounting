<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentCash extends Model
{
    protected $fillable = ['cash_id','payment_info','payment_status','paid','remaining'];

    public function cash()
    {
        return $this->belongsTo(Cash::class);
    }
    
}
