<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    //


    
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function allowance_type()
    {
        return $this->belongsTo(AllowanceType::class);
    }
}
