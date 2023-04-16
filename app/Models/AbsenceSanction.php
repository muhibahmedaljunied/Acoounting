<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceSanction extends Model
{
    // protected $fillable = ['staff_id','absence_type_id','date'];


    public function delay_sanction()
    {
        return $this->belongsToMany(DelaySanction::class);
    }

    public function attendance()
    {
        return $this->belongsToMany(Attendance::class);
    }


}
