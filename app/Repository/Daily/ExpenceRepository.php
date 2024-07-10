<?php

namespace App\Repository\Daily;

use App\Services\CoreService;
use App\Models\Daily;
use App\Models\DailyDetail;
use DB;
class ExpenceRepository  
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
        $daily->total = $this->core->data['total'];
        $daily->save();

        $this->core->daily_id = $daily->id;

        return $this;
    }


    public function debit()
    {
        $data = $this->core->data['debit'];
        for ($i = 1; $i < count($data['debit_account_id']); $i++) {

            $debit_data = [
                'daily_id' => $this->dailyId,
                'account_id' => $this->core->data['debit']['debit_account_id'],
                'description' => '',
                'debit' => $this->core->data['debit']['total'],
                'credit' => 0
            ];
            DailyDetail::create($debit_data);
        }

        return $this;
    }


    public function credit()
    {


        $data = $this->core->data['credit'];

        for ($i = 1; $i < count($data['credit_account_id']); $i++) {
            # code...

            $credit_data = [
                'daily_id' => $this->dailyId,
                'account_id' => $data['credit_account_id'][$i],
                'description' => $data['description'][$i],
                'debit' => 0,
                'credit' => $data['paid'][$i]
            ];
            DailyDetail::create($credit_data);
        }

        return $this;
    }


}
