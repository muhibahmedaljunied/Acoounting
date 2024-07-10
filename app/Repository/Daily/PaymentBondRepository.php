<?php

namespace App\Repository\Daily;

use App\RepositoryInterface\DailyRepositoryInterface;
use App\Services\CoreService;
use App\Models\Daily;
use App\Models\DailyDetail;
use DB;

class PaymentBondRepository  
{
    public $dailyId;
    public $core;
    public function __construct()
    {

        $this->core = app(CoreService::class);
    }


    public function daily()
    {

        $daily = new Daily();
        $daily->daily_date = $this->core->data['date'];
        $daily->total = $this->core->data['paid'];
        $daily->save();

        $this->core->daily_id = $daily->id;

        return $this;
    }


    public function debit()
    {
        $data = $this->core->data['debit'];

        if (gettype($data['debit_account_id']) == 'string' || gettype($data['debit_account_id']) == 'integer') {

            $debit_data = [
                'daily_id' => $this->core->daily_id,
                'account_id' => $this->core->data['debit']['debit_account_id'],
                'description' => '',
                'debit' => $this->core->data['paid'],
                'credit' => 0
            ];
        } else {

            for ($i = 1; $i < count($data['debit_account_id']); $i++) {

                $debit_data = [
                    'daily_id' => $this->core->daily_id,
                    'account_id' => $this->core->data['debit']['debit_account_id'],
                    'description' => '',
                    'debit' => $this->core->data['paid'],
                    'credit' => 0
                ];
                DailyDetail::create($debit_data);
            }
        }
        DailyDetail::create($debit_data);
        return $this;
    }


    public function credit()
    {


        $data = $this->core->data['credit'];


        if (gettype($data['credit_account_id']) == 'string' || gettype($data['credit_account_id']) == 'integer') {

            $credit_data = [
                'daily_id' => $this->core->daily_id,
                'account_id' => $data['credit_account_id'],
                'description' => '',
                'debit' => 0,
                'credit' => $this->core->data['paid']
            ];
        } else {

            for ($i = 1; $i < count($data['credit_account_id']); $i++) {
                # code...

                $credit_data = [
                    'daily_id' => $this->core->daily_id,
                    'account_id' => $data['credit_account_id'][$i],
                    'description' => '',
                    'debit' => 0,
                    'credit' => $this->core->data['paid']
                ];
                DailyDetail::create($credit_data);
            }
        }
        DailyDetail::create($credit_data);

        return $this;
    }
}
