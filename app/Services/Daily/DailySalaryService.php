<?php

namespace App\Services\Daily;

use App\Models\Daily;
use App\Models\DailyDetail;
use App\Models\HrStaffAccount;
use App\Services\CoreStaffService;
use DB;

class DailySalaryService
{

    public $dailyId;
    public $daily_detail;
    public $debit_data;
    public $account_id;
    public $core;
    public $debit;
    public $credit;
    public function __construct()
    {

        $this->core = app(CoreStaffService::class);
    }


    public function init_debit_credit()
    {

        $this->debit = 0;
        $this->credit = 0;
    }
    public function daily()
    {


        // dd($this->core->credit);
        $daily = new Daily();
        $daily->daily_date = $this->core->data['date'];
        $daily->total = $this->core->data['grand_total'];
        $daily->save();

        $this->core->daily_id = $daily->id;

        return $this;
    }


    public function debit()
    {

        $this->init_debit_credit();
        $this->set_daily_data_allowance_hr('debit');
        return $this;
    }


    public function credit()
    {

        $this->init_debit_credit();
        $this->set_daily_data_allowance_hr('credit');
        return $this;
    }

    public function set_daily_data_allowance_hr($type)
    {


        foreach ($this->core->paid as $key => $value) {

            if (gettype($value) === 'array') {

                foreach ($value as $key2 => $value2) {


                    $this->handle($type, $value2, $key2);
                }
            } else {


                $this->handle($type, $value, $key);
            }
        }
    }


    public function handle($type, $value, $key)
    {

        if ($value != 0) {

            $this->get_debit_credit($type, $value);
            $this->get_account($type, $key);
            $r = $this->store_data($type, $key);
        }
    }
    public function get_debit_credit($type, $value2)
    {


        if ($type == 'credit') {

            $this->credit = $value2;
        }

        if ($type == 'debit') {

            $this->debit = $value2;
        }
    }
    public function store_data($type, $key)
    {

        $this->data_daily_detail();
        $this->staff_account($type, $key);
    }

    public function staff_account($type, $key)
    {

        if ($type == 'debit') {


            $staff= ($this->core->data['type_daily'] == 'hr_all_paid_salary') ?  $this->core->data['data_staff'][$this->core->value]['id']
                :
                $this->core->data['data_staff'];
            HrStaffAccount::create([
                'daily_detail_id' => $this->daily_detail->id,
                'hr_account_id' => $this->get_hr_account($type, $key),
                'staff_id' => $staff
            ]);
        }
    }



    public function data_daily_detail()
    {


        $this->daily_detail = DailyDetail::create([
            'daily_id' => $this->core->daily_id,
            'account_id' => $this->account_id,
            'description' => '',
            'debit' => $this->debit,
            'credit' => $this->credit
        ]);
    }


    public function get_account($type, $key)
    {




        $account = ($type == 'debit') ? $this->core->debit : $this->core->credit;


        foreach ($account as $key1 => $value1) {




            foreach ($value1 as $key2 => $value2) {


                if ($key1 == $key || $key2 == $key) {


                    $this->account_id = $value2;
                }
                // if ($key2 == 'allowance4' && $key == 'allowance4' && $type == 'credit') {

                //     // dd($key1,$key);
                //     dd($account_id);
                // }
            }
        }



        // $this->account_id = $account_id;
    }

    public function get_hr_account($type, $key)
    {

        $hr_account_id = 0;
        // $account = ($type == 'debit') ? $this->core->debit : $this->core->credit;


        // dd($this->core->hr_account_id);
        foreach ($this->core->hr_account_id as $key1 => $value1) {



            foreach ($value1 as $key2 => $value2) {


                if ($key1 == $key || $key2 == $key) {

                    $hr_account_id = $value2;
                }
            }
        }


        return $hr_account_id;
    }
}
