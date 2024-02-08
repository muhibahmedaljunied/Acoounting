<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    protected $fillable = ['staff_id','date', 'extra_type_id', 'start_time', 'end_time'];

  
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function extra_type()
    {
        return $this->belongsTo(ExtraType::class);
    }



    public function scopeWhereExtra($query, $core)

    {

        return $query->where([
            'staff_id' => $core->data['staff'][$core->value],
            'extra_type_id' => $core->data['extra_type'][$core->value],
            'date' => $core->data['date'][$core->value],
            'start_time' => $core->data['start_time'][$core->value],
            'end_time' => $core->data['end_time'][$core->value],


        ]);

    }
}
