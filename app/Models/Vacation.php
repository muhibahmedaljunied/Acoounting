<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{



    public function scopeWhereLeave($query, $value)

    {
        return $query->where([
            'staff_id' => $value['staff'],
            'vacation_type_id' => $value['leave_type'],
            'start_date' => $value['start_date'],
            'end_date' => $value['end_date'],

        ]);
    }





    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function vacation_type()
    {
        return $this->belongsTo(VacationType::class);
    }
}
