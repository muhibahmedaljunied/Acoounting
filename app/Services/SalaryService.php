<?php

namespace App\Services;
use App\Models\StaffSanction;
use App\Models\Advance;
use App\Models\Allowance;
use App\Models\Discount;
use Illuminate\Support\Facades\DB;

class SalaryService
{
    public $account;
    public $staff;
    public function __construct(
        protected CoreStaffService $core,
    ) {

    }
    
    public function handle()
    {

        $this->get_data_account();
        $this->handle_daily_salary();
        $this->handle_daily_allowance();
        $this->handle_daily_extra();
    }
    public function get_data_account()
    {



        $this->account =  collect(HrAccount::whereIn('type', ['salary', 'extra', 'allowance', 'discount', 'leave', 'absence', 'delay', 'advance'])
            ->select('account_id', 'id as hr_account_id', 'account_second_id', 'type', 'code')
            ->get())->groupBy('type')
            ->toArray();
    }

  
    public function handle_daily_salary()
    {


        $this->filter_salary_data();
        $this->filter_salary_account();
    }

    public function handle_daily_allowance()
    {

        $this->filter_allowance_data();
        $this->filter_allowance_account();
    }

    public function handle_daily_extra()
    {


        $this->filter_extra_data();
        $this->filter_extra_account();
    }

    public function filter_salary_data()
    {

        $this->core->paid['salary'] =  collect(Staff::where('id', $this->staff)
            ->select('salary')
            ->get()->sum('salary'))
            ->toArray()[0];
        $this->core->data['grand_total'] =  $this->core->data['grand_total'] + $this->core->paid['salary'];

        // ---------------------------------------------------------------------------------------
        $this->core->paid['advance'] =  collect(Advance::where('staff_id', $this->staff)
            ->select('quantity as advance')
            ->get()->sum('advance'))
            ->toArray()[0];
        $this->core->data['grand_total'] =  $this->core->data['grand_total'] + $this->core->paid['advance'];

        // ---------------------------------------------------------------------------------------
        $this->core->paid['discount']['discount1'] =  collect(Discount::where('staff_id', $this->staff)
            ->select('quantity as discount')
            ->get()->sum('discount'))
            ->toArray()[0];
        $this->core->data['grand_total'] =  $this->core->data['grand_total'] + $this->core->paid['discount']['discount1'];

        // ---------------------------------------------------------------------------------------
        $this->core->paid['discount']['absence'] =  collect(StaffSanction::where('staff_sanctions.staff_id', $this->staff)
            ->where('staff_sanctions.status', 1)
            ->join('absence_sanctions', 'staff_sanctions.sanctionable_id', '=', 'absence_sanctions.id')
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            ->select('absence_sanctions.sanction as absence')
            ->get()->sum('absence'))
            ->toArray()[0];
        $this->core->data['grand_total'] =  $this->core->data['grand_total'] + $this->core->paid['discount']['absence'];

        // ---------------------------------------------------------------------------------------
        $this->core->paid['discount']['leave'] =  collect(StaffSanction::where('staff_sanctions.staff_id', $this->staff)
            ->where('staff_sanctions.status', 1)

            ->join('leave_sanctions', 'staff_sanctions.sanctionable_id', '=', 'leave_sanctions.id')
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            ->select('leave_sanctions.sanction as leave')
            ->get()->sum('leave'))
            ->toArray()[0];
        $this->core->data['grand_total'] =  $this->core->data['grand_total'] + $this->core->paid['discount']['leave'];

        // ---------------------------------------------------------------------------------------
        $this->core->paid['discount']['delay'] =  collect(StaffSanction::where('staff_sanctions.staff_id', $this->staff)
            ->where('staff_sanctions.status', 1)

            ->join('delay_sanctions', 'staff_sanctions.sanctionable_id', '=', 'delay_sanctions.id')
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            ->select('delay_sanctions.sanction as delay')
            ->get()->sum('delay'))
            ->toArray()[0];
        $this->core->data['grand_total'] =  $this->core->data['grand_total'] + $this->core->paid['discount']['delay'];
    }
    public function filter_salary_account()
    {



        foreach ($this->account as $key => $value) {




            foreach ($value as $key2 => $value2) {



                if ($key == 'salary') {


                    $this->core->debit[$key][$key2] = $value2['account_id'];
                    $this->core->credit[$key][$key2] = $this->core->data['account_id'];
                    $this->core->hr_account_id[$key][$key2] = $value2['hr_account_id'];
                }

                // ---------------------credit------------------------------------------------------------------------

                if ($key == 'advance') {

                    $this->core->credit[$key][$key2] = $value2['account_id'];
                    $this->core->hr_account_id[$key][$key2] = $value2['hr_account_id'];
                }

                if ($key == 'discount') {

                    $this->core->credit[$key][$value2['code']] = $value2['account_id'];
                    $this->core->hr_account_id[$key][$value2['code']] = $value2['hr_account_id'];
                }
            }
        }
    }


    // ------------------------------------------------------------------------------------
    public function filter_allowance_data()
    {

        // dd(1);


        foreach ($this->account as $key => $value) {


            foreach ($value as $key2 => $value2) {


                if ($key == 'allowance') {




                    $this->core->paid['allowance'][$value2['code']] =  collect(Allowance::where('staff_id', $this->staff)
                        ->join('allowance_types', 'allowances.allowance_type_id', '=', 'allowance_types.id')
                        ->where('allowance_types.code', $value2['code'])
                        ->select('quantity as allowance')
                        ->get()->sum('allowance'))
                        ->toArray()[0];

                    $this->core->data['grand_total'] =  $this->core->data['grand_total'] + $this->core->paid['allowance'][$value2['code']];
                }
            }
        }
    }
    public function filter_allowance_account()
    {


        foreach ($this->account as $key => $value) {

            foreach ($value as $key2 => $value2) {

                if ($key == 'allowance') {

                    $this->core->debit[$key][$value2['code']] = $value2['account_id'];
                    $this->core->credit[$key][$value2['code']] = $this->core->data['account_id'];
                    $this->core->hr_account_id[$key][$value2['code']] = $value2['hr_account_id'];
                }
            }
        }
    }


    // -------------------------------------------------------------------------------------

    public function filter_extra_data()
    {


        $this->core->paid['extra'] =  collect(StaffSanction::where('staff_sanctions.staff_id', $this->staff)
            ->where('staff_sanctions.status', 1)
            ->join('extra_sanctions', 'staff_sanctions.sanctionable_id', '=', 'extra_sanctions.id')
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            ->select('extra_sanctions.sanction as extra')
            ->get()
            ->sum('extra'))
            ->toArray()[0];

        $this->core->data['grand_total'] =  $this->core->data['grand_total'] + $this->core->paid['extra'];
    }
    public function filter_extra_account()
    {



        foreach ($this->account as $key => $value) {

            foreach ($value as $key2 => $value2) {

                if ($key == 'extra') {

                    $this->core->debit[$key][$key2] = $value2['account_id'];
                    $this->core->credit[$key][$key2] = $this->core->data['account_id'];
                    $this->core->hr_account_id[$key][$key2] = $value2['hr_account_id'];
                }
            }
        }
    }

}
