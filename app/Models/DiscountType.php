<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DiscountType extends Model
{
    public function discount()
    {
        return $this->hasMany(Discount::class);
    }
}
