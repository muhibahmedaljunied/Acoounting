<?php

namespace App\Traits\Cash;
use App\Models\Cash;
use Illuminate\Support\Facades\DB;

trait CashTrait
{


    public function add_into_cash_table()
    {


      

        $table_one = Cash::create(
            [
                'customer_id' => (array_key_exists('customer_id',$this->core->data)) ? $this->core->data['customer_id'] : null,
                'customer_name' => (array_key_exists('customer_name',$this->core->data)) ? $this->core->data['customer_name'] : null,
                'grand_total' => $this->core->data['grand_total'],
                'date' => $this->core->data['date'],

            ]
        );
        $this->core->cash =  $table_one;
        $this->core->cash_id =  $table_one->id;
        $this->core->stockable = $table_one;
        $this->core->paymentable = $table_one;
 
    }

    public function refresh_cash_table()
    {

  
        DB::table('cashes')
            ->where(['id' => $this->core->cash_id])
            ->update(['daily_id' => $this->core->daily_id]);
 
    }

    
}
