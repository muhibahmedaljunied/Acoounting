<?php

namespace App\Traits\Cash;
use App\Models\CashReturn;
use App\Models\CashReturnDetail;
use Illuminate\Support\Facades\DB;
trait CashReturnTrait
{

     function add_into_cash_return_table()
    {


        $return = new CashReturn();
        $return->cash_id = $this->core->data['cash_id'];
        $return->date  = $this->core->data['date'];
        // $return->quantity = $request->post('total');
        $return->save();
        $this->core->return_id = $return->id;
        // $this->core->return = $return;
        $this->core->stockable = $return;

 
    }

    function refresh_cash_return_table()
    {

        DB::table('cash_returns')
            ->where(['id' => $this->core->return_id])
            ->update(['daily_id' => $this->core->daily_id]); 
    }

     function add_into_cash_return_details_table()
    {

        $Details = new CashReturnDetail();
        $Details->cash_return_id = $this->core->return_id;
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->micro_unit_qty;
        $Details->save();
    }

     function refresh_cash_return_details_table()
    {

 
        DB::table('cash_details')
            ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
            ->increment('qty_return', $this->core->micro_unit_qty);


    }
    
}

