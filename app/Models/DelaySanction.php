<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelaySanction extends Model
{
    protected $fillable = ['part_id','delay_type_id','sanction_discount_id','discount','iteration','sanction'];


    public function scopeWhereDelaySanction($query, $value,$val)

    {


        return $query->where([
            'delay_type_id' => $value['delay'][$val],
            'part_id' => $value['delay_part'][$val],
            'iteration' => $value['iteration'][$val],
            'sanction_discount_id' => $value['discount_type'][$val],
            'discount' => $value['discount'][$val]
        ]);
    }

    public function absence_sanction()
    {
        return $this->belongsToMany(AbsenceSanction::class);
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
