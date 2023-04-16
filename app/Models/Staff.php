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
    public function advance()
    {
        return $this->hasMany(Advance::class);
    }

    public function vacation()
    {
        return $this->hasMany(Vacation::class);
    }


    public function department()

    {

        return $this->belongsTo(AdministrativeStructure::class);
    }

    public function job()

    {

        return $this->belongsTo(AdministrativeStructure::class, 'job_id');
    }

    public function qualification()

    {

        return $this->belongsTo(Qualification::class);
    }


    public function branch()

    {

        return $this->belongsTo(Branch::class);
    }


    public function staff_type()

    {

        return $this->belongsTo(StaffType::class);
    }



    public function work_type()

    {

        return $this->belongsTo(WorkType::class);
    }





    public function staff_religion()

    {

        return $this->belongsTo(StaffReligion::class);
    }

    public function nationality()

    {

        return $this->belongsTo(Nationality::class);
    }



}
