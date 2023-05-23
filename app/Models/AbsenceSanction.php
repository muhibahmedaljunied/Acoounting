<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceSanction extends Model
{
    // protected $fillable = ['staff_id','absence_type_id','date'];


    public function scopeWhereAbsenceSanction($query, $value)

    {


        return $query->where([
            'staff_id' => $value['staff'],
            'absence_type_id' => $value['absence'],
            'iteration' => $value['iteration'],
            'sanction_discount_id' => $value['discount_type'],
            'discount' => $value['discount']
        ]);
    }


    public function delay_sanction()
    {
        return $this->belongsToMany(DelaySanction::class);
    }

    public function attendance()
    {
        return $this->belongsToMany(Attendance::class);
    }
}
