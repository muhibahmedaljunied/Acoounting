<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentSupply extends Model
{
    protected $fillable = ['supply_id','payment_info','payment_status','paid','remaining'];

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
    
}
