<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    
    protected $fillable = ['staff_id','net_salary','total_allowance','total_discount','total_advance','total_extra'];
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }


}
