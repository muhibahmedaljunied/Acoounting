<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['paymentable_id','paymentable_type','payment_status','payment_info','paid','remaining'];


      public function paymentable()
    {
        return $this->morphTo();
    }

    
}
