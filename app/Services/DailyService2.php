<?php

namespace App\Services;

use App\Models\Daily;
use App\Models\DailyDetail;
use App\Models\HrStaffAccount;
use DB;

class DailyService
{
    public $dailyId;
    public $core;
    public function __construct()
    {

        $this->core = app(CoreStaffService::class);
    }


    public function daily()
    {


        $daily = new Daily();
        $daily->daily_date = $this->core->data['date'];
        $daily->total = $this->core->data['grand_total'];
        $daily->save();

        $this->core->daily_id = $daily->id;

        return $this;
    }


    public function detect_number_daily($type)
    {


        // dd($this->core->data[$type][$type . '_account_id']);
        $account_id = $this->core->data[$type][$type . '_account_id'];

        if (gettype($account_id) == 'string' || gettype($account_id) == 'integer') {

            $this->one_daily($type);
        } else {


            $this->multble_daily($type);
        }
    }

    public function one_daily($type)
    {

        $debit_data = $this->set_daily_data(0, $type);
        DailyDetail::create($debit_data);
    }
    public function multble_daily($type)
    {


        if ($this->core->data['type_daily']) {

            if ($this->core->data['type_daily'] == 'hr_allowance') {

                $this->allowance_daily($type);
            }

            if ($this->core->data['type_daily'] == 'hr_advance') {

                $this->advance_daily($type);
            }

            if ($this->core->data['type_daily'] == 'hr_salary') {

                $this->salary_daily($type);
            }
        } else {

            $this->another_daily($type);
        }
    }


    public function debit()
    {


        $this->detect_number_daily('debit');
        return $this;
    }


    public function credit()
    {


        $this->detect_number_daily('credit');
        return $this;
    }


    public function set_daily_data($i, $type)
    {


        $debit = 0;
        $credit = 0;
        if ($type == 'debit') {

            $debit = ($i == 0) ? $this->core->data['grand_total'] : $this->core->data[$type]['paid'][$i];
            $account_id = ($i) ? $this->core->data[$type]['debit_account_id'][$i] : $this->core->data[$type]['debit_account_id'];
        }
        if ($type == 'credit') {

            $credit = ($i == 0) ? $this->core->data['grand_total'] : $this->core->data[$type]['paid'][$i];
            $account_id = ($i) ? $this->core->data[$type]['credit_account_id'][$i] : $this->core->data[$type]['credit_account_id'];
        }

        return [
            'daily_id' => $this->core->daily_id,
            'account_id' => $account_id,
            'description' => '',
            'debit' => $debit,
            'credit' => $credit
        ];
    }

    public function set_daily_data_allowance_hr($type)
    {


        $debit = 0;
        $credit = 0;


        if ($type == 'debit') {


            $debit = $this->core->data[$type]['paid'][$this->core->value];
            $account_id = $this->core->data[$type]['debit_account_id'][$this->core->value];
        }
        if ($type == 'credit') {

            $credit = $this->core->data[$type]['paid'][$this->core->value];
            $account_id = $this->core->data[$type]['credit_account_id'][$this->core->value];
        }

        return [
            'daily_id' => $this->core->daily_id,
            'account_id' => $account_id,
            'description' => '',
            'debit' => $debit,
            'credit' => $credit
        ];
    }

    // public function set_daily_data_hr($type)
    // {


    //     // dd($data['debit_account_id'][0]);
    //     $debit = 0;
    //     $credit = 0;
    //     if ($type == 'debit') {

    //         $debit = $this->core->data[$type]['paid'][$this->core->value];
    //         $account_id = $this->core->data[$type]['debit_account_id'][0]['account_id'];
    //     }
    //     if ($type == 'credit') {

    //         $credit = $this->core->data[$type]['paid'][$this->core->value];
    //         $account_id = $this->core->data[$type]['credit_account_id'][$this->core->value];
    //     }

    //     return [
    //         'daily_id' => $this->core->daily_id,
    //         'account_id' => $account_id,
    //         'description' => '',
    //         'debit' => $debit,
    //         'credit' => $credit
    //     ];
    // }

    public function allowance_daily($type)
    {


        $debit_data = $this->set_daily_data_allowance_hr($type);

        $daily_detail = DailyDetail::create($debit_data);

        if ($type == 'debit') {


            HrStaffAccount::create([
                'daily_detail_id' => $daily_detail->id,
                'hr_account_id' => $this->core->data[$type]['hr_account_id'][$this->core->value],
                'staff_id' => $this->core->data[$type]['staff'][$this->core->value]
            ]);
        }
    }

    public function advance_daily($type)
    {


        $debit = 0;
        $credit = 0;

        if ($type == 'debit') {

            $debit = $this->core->data[$type]['paid'][$this->core->value];
            $account_id = $this->core->data[$type]['debit_account_id'][0]['account_id'];
            $daily_detail = $this->daily_detail($account_id,$debit,$credit);
            HrStaffAccount::create([
                'daily_detail_id' => $daily_detail->id,
                'hr_account_id' => $this->core->data[$type]['debit_account_id'][0]['hr_account_id'],
                'staff_id' => $this->core->data[$type]['staff'][$this->core->value]
            ]);

        } else {



            $credit = $this->core->data[$type]['paid'][$this->core->value];
            $account_id = $this->core->data[$type]['credit_account_id'][$this->core->value];
            $this->daily_detail($account_id,$debit,$credit);

        }


    

    }


    public function another_daily($type)
    {

        for ($i = 1; $i < count($this->core->data[$type][$type . '_account_id']); $i++) {

            $debit_data = $this->set_daily_data($i, $type);

            DailyDetail::create($debit_data);
        }
    }

    public function daily_detail($account_id,$debit,$credit){


        $debit_data =  [
            'daily_id' => $this->core->daily_id,
            'account_id' => $account_id,
            'description' => '',
            'debit' => $debit,
            'credit' => $credit
        ];

        return DailyDetail::create($debit_data);
    }
}
