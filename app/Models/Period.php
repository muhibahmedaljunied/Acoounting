<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = ['id','name','from_time','into_time'];

    public function period_time()
    {
        return $this->hasMany(PeriodTime::class);
    }

           
    
    // public function work_types()
    // {
    //     return $this->belongsToMany(WorkType::class, 'period_work_types', 'period_id','work_type_id')->withPivot('day_id');
    // }


}
