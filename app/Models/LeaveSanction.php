<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveSanction extends Model
{
    // protected $fillable = ['staff_id','absence_type_id','date'];


   
    public function scopeWhereLeaveSanction($query, $value)

    {

        return $query->where([
            'staff_id' => $value['staff'],
            'leave_type_id' => $value['leave'],
            'leave_part_id' => $value['leave_part'], 
            'iteration' => $value['iteration'],
            'sanction_discount_id' => $value['discount_type'],
            'discount' => $value['discount']
        ]);

                

    }


}
