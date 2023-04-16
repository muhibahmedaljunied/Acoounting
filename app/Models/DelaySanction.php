<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DelaySanction extends Model
{
    // protected $fillable = ['staff_id','delay_type_id','date'];


    public function absence_sanction()
    {
        return $this->belongsToMany(AbsenceSanction::class);
    }

    public function attendance()
    {
        return $this->belongsToMany(Attendance::class);
    }

}
