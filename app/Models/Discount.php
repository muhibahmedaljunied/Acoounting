<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{



    public function scopeWhereDiscount($query, $value)

    {


        return $query->where([
            'staff_id' => $value['staff'],
            'discount_type_id' => $value['discount_type'],
            'date' => $value['date']
        ]);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function discount_type()
    {
        return $this->belongsTo(DiscountType::class);
    }
}
