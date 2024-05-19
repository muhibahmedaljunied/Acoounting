<?php

namespace App\Services;

use App\Models\Daily;
use App\Models\DailyDetail;
use App\Models\GroupAccount;


class DailyStockService
{



    public $core;
    public $daily_payment;

    public function __construct(DailyPaymentStockService $daily_payment)
    {
        $this->daily_payment = $daily_payment;
        $this->core = $daily_payment->core;
    }


    public function init_items($type)
    {


        $this->core->daily_type = $type;
        // dd($this->core->data[$this->core->daily_type]);
        $this->core->value = $this->core->data[$this->core->daily_type]['value'];
        $this->core->dailyDetailId_item =  [
            'daily_id' => '',
            'account_id' => '',
            'description' => '',
            'debit' => 0,
            'credit' => 0
        ];
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


    public function detect_number_daily()
    {




        if (gettype($this->core->value) == 'string' || gettype($this->core->value) == 'integer') {



            $this->one_daily();
        }

        if (gettype($this->core->value) == 'array') {


          
            $this->multble_daily();
        }
    }

    public function one_daily()
    {


        $this->core->set_row_daily_details(0);
        $this->set_daily_value();
        $this->data_daily_detail();
        $this->group_account();
    }
    public function multble_daily()
    {



        if ($this->core->data['type_daily']) {

            // dd(1);


            if (
                $this->core->data['type_daily'] == 'sale' ||
                $this->core->data['type_daily'] == 'cash' ||
                $this->core->data['type_daily'] == 'salereturn' ||
                $this->core->data['type_daily'] == 'purchasereturn'
            ) {


                $this->start_daily(0);
            }

            if (
                $this->core->data['type_daily'] == 'purchase' ||
                $this->core->data['type_daily'] == 'supply'
            ) {



                $this->start_daily(1);
            }
        }
        // else {

        //     $this->another_daily();
        // }
    }


    public function exicute($type)
    {





        $this->init_items($type);
        $this->detect_number_daily();
        return $this;
    }





    // public function set_daily_data($i)
    // {


    //     $this->set_daily_value($i);
    //     $this->check_daily(); //this check for make refreshing in DailyDetail Table

    // }



    public function set_daily_value()
    {



        $this->core->account_id = (gettype($this->core->data[$this->core->daily_type]['account_id']) == 'array') ?
            $this->core->data[$this->core->daily_type]['account_id'][$this->core->row_daily_details] : $this->core->data[$this->core->daily_type]['account_id'];

        $this->core->dailyDetailId_item[$this->core->daily_type] = (gettype($this->core->data[$this->core->daily_type]['value']) == 'array') ?
            $this->core->data[$this->core->daily_type]['value'][$this->core->row_daily_details] : $this->core->data[$this->core->daily_type]['value'];
    }


    public function start_daily($f)
    {




        for ($i = $f; $i < count($this->core->data[$this->core->daily_type]['value']); $i++) {

            foreach ($this->core->data['count'] as $value) {

                if ($value == $i ) {


                    $this->core->set_row_daily_details($i);
                    $this->daily_payment->check_payment_type();

                    $this->set_daily_value();

                    $this->check_daily(); //this check for make refreshing in DailyDetail Table

                }
            }

       
        }
    }




    // public function another_daily()
    // {


    //     for ($i = 1; $i < count($this->core->data[$this->core->daily_type]['account_id']); $i++) {

    //         $debit_data = $this->set_daily_data($i);
    //         DailyDetail::create($debit_data);
    //     }
    // }

    public function data_daily_detail()
    {



        $this->core->dailyDetailId_item['daily_id'] = $this->core->daily_id;
        $this->core->dailyDetailId_item['account_id'] = $this->core->account_id;
        $dailyDetailId =  DailyDetail::create($this->core->dailyDetailId_item);

        $this->core->dailyDetailId = $dailyDetailId->id;
    }

    public function group_account()
    {


        $this->daily_payment->check_payment_type($this->core->row_daily_details);
        $this->store_group_account();
    }

    public function store_group_account()
    {

        // dd($this->core->account_details);
        $daily = new GroupAccount();
        $daily->dailyable()->associate($this->core->account_details);
        $daily->daily_details_id = $this->core->dailyDetailId;
        $daily->save();
    }

    public function check_daily()
    {





        $this->get_daily_detail_id();

        if (count($this->core->status_daily_detail) != 1) {

            $this->data_daily_detail();

            $this->group_account();
        }
    }

    public function get_daily_detail_id()
    {

        // dd($this->core->dailyDetailId_item);
        $this->core->status_daily_detail = collect(
            tap(DailyDetail::where('daily_id', $this->core->daily_id)
                ->where('account_id', $this->core->account_id))
                ->increment($this->core->daily_type, $this->core->dailyDetailId_item[$this->core->daily_type])
                ->get()
        )
            ->toArray();
    }
}
