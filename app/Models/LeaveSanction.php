<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveSanction extends Model
{
    // protected $fillable = ['staff_id','absence_type_id','date'];


   
    public function scopeWhereLeaveSanction($query, $value)

    {

        return $query->where([
            'leave_type_id' => $value['leave'],
            'part_id' => $value['leave_part'], 
            'iteration' => $value['iteration'],
            'sanction_discount_id' => $value['discount_type'],
            'discount' => $value['discount']
        ]);

                

    }


    public function staff_sanction()
    {
        return $this->morphMany(StaffSanction::class, 'sanctionable');
    }



}
