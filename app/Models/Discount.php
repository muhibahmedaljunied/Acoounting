<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    


    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function discount_type()
    {
        return $this->belongsTo(DiscountType::class);
    }



}
