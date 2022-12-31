<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAllowance extends Model
{
    protected $fillable = ['staff_id','allowance_id','qty','date','salary'];


    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
