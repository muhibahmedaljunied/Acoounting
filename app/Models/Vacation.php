<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    
    public function vacation_type()
    {
        return $this->belongsTo(VacationType::class);
    }

}
