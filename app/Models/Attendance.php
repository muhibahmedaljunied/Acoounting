<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function delay_sanction()
    {
        return $this->belongsToMany(DelaySanction::class);
    }

    public function absence_sanction()
    {
        return $this->belongsToMany(AbsenceSanction::class);
    }

    public function attendance_details()
    {
        return $this->hasMany(AttendanceDetail::class);
    }

    
}
