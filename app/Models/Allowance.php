<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    //


    protected $fillable = ['staff_id','allowance_type_id','quantity','status','date'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function allowance_type()
    {
        return $this->belongsTo(AllowanceType::class);
    }

    public function scopeWhereAllowance($query, $value)

    {
        return $query->where([
            'staff_id' => $value['staff'],
            'allowance_type_id' => $value['allowance_type'],
        ]);
    }



                                                    
}
