<?php

namespace App\Traits\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
use Illuminate\Support\Facades\DB;
trait SaleReturnTrait
{

     function add_into_sale_return_table()
    {


        $return = new SaleReturn();
        $return->sale_id = $this->core->data['sale_id'];
        $return->date  = $this->core->data['date'];
        // $return->quantity = $request->post('total');
        $return->save();
        $this->core->return_id = $return->id;
        $this->core->stockable = $return;
        $this->core->paymentable = $return;


    }

    function refresh_sale_return_table()
    {

        DB::table('sale_returns')
            ->where(['id' => $this->core->return_id])
            ->update(['daily_id' => $this->core->daily_id]); 
    }

     function add_into_sale_return_details_table()
    {

        $Details = new SaleReturnDetail();
        $Details->sale_return_id = $this->core->return_id;
        $Details->store_product_id = $this->core->id_store_product;
        // $Details->unit_id = $this->core->unit_value;
        // $Details->unit_id = $this->core->unit_array[0];

        $Details->qty = $this->core->micro_unit_qty;
        $Details->save();
    }

   
    
}

