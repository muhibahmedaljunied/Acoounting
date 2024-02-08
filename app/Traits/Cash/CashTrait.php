<?php

namespace App\Traits\Cash;
use App\Models\Cash;
use App\Models\CashDetail;
use Illuminate\Support\Facades\DB;

trait CashTrait
{


    public function add_into_cash_table()
    {



        $table_one = Cash::create(
            [
                'customer_id' => $this->core->data['customer_id'],
                'customer_name' => $this->core->data['customer_name'],
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

    public function add_into_cash_details_table()
    {


        $Details = new CashDetail();
        $Details->cash_id = $this->core->cash_id;
        $Details->cost = $this->core->data['old'][$this->core->value]['cost'];
        $Details->total = $this->core->data['sub_total'];
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->micro_unit_qty;
        $Details->save();
    }
}
