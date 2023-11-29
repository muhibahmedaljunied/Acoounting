<?php

namespace App\Services;
use App\Models\DailyDetail;

class DailyService
{
   public $daily_id;
    public function daily($date,$total){



        $daily = new Daily();
        $daily->daily_date = $date;
        $daily->total = $total;
        $daily->save();

        $this->daily_id = $daily->id;
        return $this;

    }


    public function depit($depit,$value){



        foreach ($depit as $value) {
            $depit_data = [
                'daily_id' => $this->daily_id,
                'account_id' => $value,
                'description' => $quantity[$i],
                'debit' => ,
                'credit' => ,
            ];
            DailyDetail::create($depit_data);
        }

        return $this;



    }


    public function credit($credit,$value){



        foreach ($credit as $value) {
            $credit_data = [
                'daily_id' => $this->daily_id,
                'account_id' => ,
                'description' =>,
                'debit' => ,
                'credit' => $,
            ];
            DailyDetail::create($credit_data);
        }

        return $this;

    }

    public function set(){


        $receivab = new ReceivableNote();
        $receivab->sale_id = $request->post('sale_id');
        $receivab->daily_id = $this->daily_id;
        $receivab->date = $request->post('date');
        $receivab->save();
      

    }



}









        // foreach ($credit as $value) {

        //     $dailyDetail = new DailyDetail();
        //     $dailyDetail->daily_id = $daily->id;
        //     $dailyDetail->account_id = $credit;
        //     $dailyDetail->description = $request->post('description');
        //     $dailyDetail->debit = 0;
        //     $dailyDetail->credit = $value;
        //     $dailyDetail->save();

        // }


        
        // foreach ($depit as $value) {

        //     $dailyDetail = new DailyDetail();
        //     $dailyDetail->daily_id = $daily->id;
        //     $dailyDetail->account_id = $depit;
        //     $dailyDetail->description = $request->post('description');
        //     $dailyDetail->debit = $value;
        //     $dailyDetail->credit = 0;
        //     $dailyDetail->save();

        // }
