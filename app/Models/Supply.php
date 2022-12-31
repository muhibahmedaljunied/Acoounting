<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'supplier_id','supplier_name','date'
    ];


    // public function scopeAll_where($query,$data,$type)
    // {

    //     if($type == 1){
    //         return $query->where($data);
    //     }else{
    //         return $query->whereBetween($data);
    //     }
      
    // }



}


