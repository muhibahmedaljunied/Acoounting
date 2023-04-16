<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PayableNote extends Model
{
    protected $fillable = ['purchase_id','date','paid'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    
}
