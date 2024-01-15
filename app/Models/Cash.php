<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $fillable = [
        'customer_id','customer_name','date'
    ];

    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

}
