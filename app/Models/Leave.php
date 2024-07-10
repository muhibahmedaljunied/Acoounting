<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['id','staff_id','leave_type_id','part_id','date'];


    public function scopeWhereLeave($query, $value)

    {
        return $query->where([
            'staff_id' => $value['staff'],
            'leave_type_id' => $value['leave_type'],

        ]);
    }

}
