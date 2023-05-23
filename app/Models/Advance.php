<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    public function scopeWhereAdvance($query, $value)

    {


        return $query->where([
                                'staff_id' => $value['staff'],
                                'date' => $value['date'],
        ]);
    }

    

                                                        
}
