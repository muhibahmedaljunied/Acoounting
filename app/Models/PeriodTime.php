<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodTime extends Model
{
    protected $fillable = ['id','period_id','from_time','into_time','duration'];


    

    public function period()
    {
        return $this->belongsTo(Period::class);
    }


    // public function work_types()
    // {
    //     return $this->belongsToMany(WorkType::class, 'period_work_types', 'period_id','work_type_id')
    //     ->withPivot('day_id');    
    // }


  

    
    






}
