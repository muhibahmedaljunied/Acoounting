<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    protected $fillable = ['id','name'];



    
    // public function period()
    // {
    //     return $this->belongsToMany(Period::class)->using(WorkSystem::class);
    // }

    // public function rest()
    // {
    //     return $this->belongsToMany(Rest::class)->using(WorkSystem::class);
    // }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }



}
