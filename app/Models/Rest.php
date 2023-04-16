<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    // protected $fillable = ['id','name'];

    

    public function work_type()
    {
        return $this->belongsToMany(WorkType::class)->using(WorkSystem::class);
    }

    public function period()
    {
        return $this->belongsToMany(Period::class)->using(WorkSystem::class);
    }




}
