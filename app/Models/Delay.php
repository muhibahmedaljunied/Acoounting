<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Delay extends Model
{
    protected $fillable = ['staff_id','delay_type_id','part_id','date'];

    public function scopeWhereDelay($query, $value)

    {
        return $query->where([
            'staff_id' => $value['staff'],
            'delay_type_id' => $value['delay_type'],

        ]);
    }

}
