<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    protected $fillable = ['id','name'];




    // public function staff()
    // {
    //     return $this->hasMany(Staff::class);
    // }



            
    // public function periods()
    // {
    //     return $this->belongsToMany(Period::class, 'period_work_types', 'work_type_id','period_id')->withPivot('day_id');
    // }





}
