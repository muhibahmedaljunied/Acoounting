<?php

namespace App\Services;

use App\Models\Daily;
use App\Models\DailyDetail;
use App\Models\GroupAccount;
use App\Models\HrStaffAccount;
use DB;

class DailyService
{
    public $dailyId;
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

        // dd($this->core->data);
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
            if ($this->core->data['type_daily'] == 'hr_prove_salary') {

                $this->prove_salary_daily($type);
            }
            if ($this->core->data['type_daily'] == 'hr_all_prove_salary') {

                $this->prove_salary_daily_all($type);
            }

            if ($this->core->data['type_daily'] == 'hr_paid_salary') {

                $this->paid_salary_daily($type);
            }
            if ($this->core->data['type_daily'] == 'hr_all_paid_salary') {

                $this->paid_salary_daily_all($type);
            }
        } else {

            $this->another_daily($type);
        }
    }


    public function debit()
    {


        $this->init_debit_credit();
        $this->detect_number_daily('debit');
        return $this;
    }


    public function credit()
    {

        $this->init_debit_credit();
        $this->detect_number_daily('credit');
        return $this;
    }


    public function set_daily_data($i, $type)
    {



        if ($type == 'debit') {

            $this->debit = ($i == 0) ? $this->core->data['grand_total'] : $this->core->data[$type]['paid'][$i];
            $this->account_id = ($i) ? $this->core->data[$type]['debit_account_id'][$i] : $this->core->data[$type]['debit_account_id'];
        }
        if ($type == 'credit') {

            $this->credit = ($i == 0) ? $this->core->data['grand_total'] : $this->core->data[$type]['paid'][$i];
            $this->account_id = ($i) ? $this->core->data[$type]['credit_account_id'][$i] : $this->core->data[$type]['credit_account_id'];
        }

        return $this->data_daily_detail();
    }

    public function set_daily_data_allowance_hr($type)
    {


        if ($type == 'debit') {

            $this->debit = $this->core->data[$type]['paid'][$this->core->value];
            $this->account_id = $this->core->data[$type]['debit_account_id'][$this->core->value];
        }
        if ($type == 'credit') {

            $this->credit = $this->core->data[$type]['paid'][$this->core->value];
            $this->account_id = $this->core->data[$type]['credit_account_id'][$this->core->value];
        }

        return $this->data_daily_detail();
    }

    public function set_daily_data_advance_hr($type)
    {


        // dd($data['debit_account_id'][0]);
        if ($type == 'debit') {

            $this->debit = $this->core->data[$type]['paid'][$this->core->value];
            $this->account_id = $this->core->data[$type]['debit_account_id'][0]['account_id'];
        }
        if ($type == 'credit') {

            $this->credit = $this->core->data[$type]['paid'][$this->core->value];
            $this->account_id = $this->core->data[$type]['credit_account_id'][$this->core->value];
        }

        return $this->data_daily_detail();
    }
    public function set_daily_data_prove_salary_hr($type)
    {




        if ($type == 'credit') {

            $this->credit = $this->core->data[$type]['paid'];
            $this->account_id = $this->core->data[$type]['credit_account_id'][0]['account_id'];
        }

        if ($type == 'debit') {

            // dd($this->core->data[$type]['debit_account_id'][0]['account_second_id']);
            $this->debit = $this->core->data[$type]['paid'];
            $this->account_id = $this->core->data[$type]['debit_account_id'][0]['account_second_id'];
        }

        return $this->data_daily_detail($type);
    }
    public function set_daily_data_prove_salary_hr_all($type)
    {



        if ($type == 'credit') {


            $this->credit = $this->core->data['data_staff'][$this->core->value]['salary'];
            $this->account_id = $this->core->data[$type]['credit_account_id'][0]['account_id'];
        }

        if ($type == 'debit') {

            $this->debit = $this->core->data['data_staff'][$this->core->value]['salary'];
            $this->account_id = $this->core->data[$type]['debit_account_id'][0]['account_second_id'];
        }

        return $this->data_daily_detail($type);
    }

    public function set_daily_data_paid_salary_hr($type)
    {




        if ($type == 'credit') {

            $this->credit = $this->core->data[$type]['paid'];
            $this->account_id = $this->core->data[$type]['credit_account_id'][0]['account_id'];
        }

        if ($type == 'debit') {

            // dd($this->core->data[$type]['debit_account_id'][0]['account_second_id']);
            $this->debit = $this->core->data[$type]['paid'];
            $this->account_id = $this->core->data[$type]['debit_account_id'][0]['account_second_id'];
        }

        return $this->data_daily_detail($type);
    }
    public function set_daily_data_paid_salary_hr_all($type)
    {



        if ($type == 'credit') {


            $this->credit = $this->core->data['data_staff'][$this->core->value]['salary'];
            $this->account_id = $this->core->data[$type]['credit_account_id'][0]['account_id'];
        }

        if ($type == 'debit') {

            $this->debit = $this->core->data['data_staff'][$this->core->value]['salary'];
            $this->account_id = $this->core->data[$type]['debit_account_id'][0]['account_second_id'];
        }

        return $this->data_daily_detail($type);
    }

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



        $debit_data = $this->set_daily_data_advance_hr($type);
        $daily_detail = DailyDetail::create($debit_data);

        if ($type == 'debit') {

            HrStaffAccount::create([
                'daily_detail_id' => $daily_detail->id,
                'hr_account_id' => $this->core->data[$type]['debit_account_id'][0]['hr_account_id'],
                'staff_id' => $this->core->data[$type]['staff'][$this->core->value]
            ]);
        }
    }

    public function prove_salary_daily($type)
    {



        $debit_data = $this->set_daily_data_prove_salary_hr($type);

        $daily_detail = DailyDetail::create($debit_data);


        if ($type == 'credit') {

            HrStaffAccount::create([
                'daily_detail_id' => $daily_detail->id,
                'hr_account_id' => $this->core->data[$type]['credit_account_id'][0]['hr_account_id'],
                'staff_id' => $this->core->data[$type]['staff']
            ]);
        }
    }
    public function prove_salary_daily_all($type)
    {



        $debit_data = $this->set_daily_data_prove_salary_hr_all($type);

        $daily_detail = DailyDetail::create($debit_data);


        if ($type == 'credit') {


            HrStaffAccount::create([
                'daily_detail_id' => $daily_detail->id,
                'hr_account_id' => $this->core->data[$type]['credit_account_id'][0]['hr_account_id'],
                'staff_id' => $this->core->data['data_staff'][$this->core->value]['id']
            ]);
        }
    }

    public function paid_salary_daily($type)
    {



        $debit_data = $this->set_daily_data_paid_salary_hr($type);

        $daily_detail = DailyDetail::create($debit_data);


        if ($type == 'debit') {

            HrStaffAccount::create([
                'daily_detail_id' => $daily_detail->id,
                'hr_account_id' => $this->core->data[$type]['credit_account_id'][0]['hr_account_id'],
                'staff_id' => $this->core->data[$type]['staff']
            ]);
        }
    }
    public function paid_salary_daily_all($type)
    {



        $debit_data = $this->set_daily_data_paid_salary_hr_all($type);

        $daily_detail = DailyDetail::create($debit_data);


        if ($type == 'debit') {


            HrStaffAccount::create([
                'daily_detail_id' => $daily_detail->id,
                'hr_account_id' => $this->core->data[$type]['credit_account_id'][0]['hr_account_id'],
                'staff_id' => $this->core->data['data_staff'][$this->core->value]['id']
            ]);
        }
    }





    public function another_daily($type)
    {

  
        for ($i = 1; $i < count($this->core->data[$type][$type . '_account_id']); $i++) {

            $debit_data = $this->set_daily_data($i, $type);
            DailyDetail::create($debit_data);
        }
    }

    public function data_daily_detail()
    {



        return [
            'daily_id' => $this->core->daily_id,
            'account_id' => $this->account_id,
            'description' => '',
            'debit' => $this->debit,
            'credit' => $this->credit
        ];
    }
}
