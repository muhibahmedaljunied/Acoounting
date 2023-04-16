<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    protected $fillable = [
        'attendance_id','period_id','status_attendance','check_in','check_out','duration','delay','leave'
    ];


    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }


 
}
