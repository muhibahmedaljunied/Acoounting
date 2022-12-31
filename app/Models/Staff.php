<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name', 'personal_card', 'job_id', 'branch_id', 'department_id', 'phone',
        'salary_id', 'register_id', 'date', 'staff_status', 'qualification_id',
        'nationality_id', 'gender', 'staff_type_id', 'barth_date', 'religion_id', 'social_status', 'email'
    ];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }


    public function allowance()
    {
        return $this->hasMany(Allowance::class);
    }

    public function payroll()
    {
        return $this->hasMany(Payroll::class);
    }


    public function staff_allowance()
    {
        return $this->hasMany(StaffAllowance::class);
    }

    public function discount()
    {
        return $this->hasMany(Discount::class);
    }

    public function extra()
    {
        return $this->hasMany(Extra::class);
    }

    public function vacation()
    {
        return $this->hasMany(Vacation::class);
    }


}
