<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceSanction extends Model
{
    protected $fillable = ['absence_type_id','sanction_discount_id','discount','iteration','sanction'];


    public function scopeWhereAbsenceSanction($query, $value,$val)

    {


        return $query->where([
            'absence_type_id' => $value['absence'][$val],
            'iteration' => $value['iteration'][$val],
            'sanction_discount_id' => $value['discount_type'][$val],
            'discount' => $value['discount'][$val]
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


    public function staff_sanction()
    {
        return $this->morphMany(StaffSanction::class, 'sanctionable');
    }
}
