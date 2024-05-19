<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'supplier_id','supplier_name','date','grand_total'
    ];

    public function supply_returns()
    {
        return $this->hasMany(SupplyReturn::class);
    }
    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    // public function scopeAll_where($query,$data,$type)
    // {

    //     if($type == 1){
    //         return $query->where($data);
    //     }else{
    //         return $query->whereBetween($data);
    //     }
      
    // }



}


