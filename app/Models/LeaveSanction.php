<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveSanction extends Model
{
    protected $fillable = ['part_id','sanction_discount_id','leave_type_id','iteration','sanction','discount'];


   
    public function scopeWhereLeaveSanction($query, $value,$val)

    {

        return $query->where([
            'leave_type_id' => $value['leave'][$val],
            'part_id' => $value['leave_part'][$val], 
            'iteration' => $value['iteration'][$val],
            'sanction_discount_id' => $value['discount_type'][$val],
            'discount' => $value['discount'][$val]
        ]);



        


                

    }


    public function staff_sanction()
    {
        return $this->morphMany(StaffSanction::class, 'sanctionable');
    }



}
