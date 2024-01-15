<?php

namespace App\Services;
use App\Services\CoreService;
use App\Models\Daily;
use App\Models\DailyDetail;
use DB;
class DailyService
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
        $daily->total = $this->core->data['grand_total'];
        $daily->save();
        $this->core->daily_id = $daily->id;

        return $this;
    }


    public function detect_number_daily($data,$type){

        if (gettype($data[$type.'_account_id']) == 'string' || gettype($data[$type.'_account_id']) == 'integer') {

            $this->one_daily($data,$type);
      
        } else {

            $this->multble_daily($data,$type);
          
        }

    }

    public function one_daily($data,$type){

        $debit_data = $this->set_daily_data($data,0,$type);
        DailyDetail::create($debit_data);

    }
    public function multble_daily($data,$type){
        
        for ($i = 1; $i < count($data[$type.'_account_id']); $i++) {

            $debit_data = $this->set_daily_data($data, $i,$type);

            DailyDetail::create($debit_data);
        }

    }

    
    public function debit()
    {
    
      
        $this->detect_number_daily($this->core->data['debit'],'debit');
     

        return $this;
    }


    public function credit()
    {

        $this->detect_number_daily($this->core->data['credit'],'credit');

        return $this;
    }


    public function set_daily_data($data, $i, $type)
    {

        // dd($this->core->data);
        $debit = 0;
        $credit = 0;
        if ($type == 'debit') {

            $retVal = ($i == 0) ? $this->core->data['grand_total'] : $this->core->data['debit']['paid'][$i] ;
            $account_id = ($i) ? $data['debit_account_id'][$i] : $data['debit_account_id'];
            // $debit = $this->core->data['grand_total'];
            $debit = $retVal;
            $credit = 0;
        }
        if ($type == 'credit') {

            $retVal = ($i == 0) ? $this->core->data['grand_total'] : $this->core->data['credit']['paid'][$i] ;
            $account_id = ($i) ? $data['credit_account_id'][$i] : $data['credit_account_id'];
            // $credit = $this->core->data['grand_total'];
            $credit = $retVal;
            $debit = 0;
        }

        return $data = [
            'daily_id' => $this->core->daily_id,
            'account_id' => $account_id,
            'description' => '',
            'debit' => $debit,
            'credit' => $credit
        ];
    }



}
