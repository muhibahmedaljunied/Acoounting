<?php

namespace App\Traits\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
trait SaleReturnTrait
{

     function add_into_sale_return_table()
    {



        $table_one = SaleReturn::create(
            [
                'sale_id' => $this->core->data['customer_id'],
                'quatity' => $this->core->data['customer_name'],
                'date' => $this->core->data['date'],

            ]
        );
        $this->core->sale =  $table_one;
        $this->core->sale_id =  $table_one->id;
 
    }

     function add_into_sale_return_details_table()
    {


        $details = new SaleReturnDetail();
        $details->sale_return_id = $this->core->sale_id;
        $details->store_product_id = $this->core->id_store_product;
        $details->unit_id = $this->core->unit_value;
        $details->qty = $this->core->data['qty'][$this->core->value];
        $details->save();
    }

     function refresh_sale_return_details_table()
    {

        DB::table('sale_details')
                    ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
                    ->increment('qty_return', $this->core->data['old'][$this->core->value]['qty_return_now']);
            



    }
    
}

