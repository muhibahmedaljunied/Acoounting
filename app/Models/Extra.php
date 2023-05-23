<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    protected $fillable = ['staff_id','extra_type_id','start_time','end_time'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function extra_type()
    {
        return $this->belongsTo(ExtraType::class);
    }

    public function extra_sanction()
    {
        return $this->belongsTo(ExtraSanction::class);
    }

    public function scopeWhereExtra($query, $value)

    {
        return $query->where([
            'staff_id' => $value['staff'],
            'extra_type_id' => $value['extra_type'],
          
        ]);

                                                        
                                                            
    }

    

}
