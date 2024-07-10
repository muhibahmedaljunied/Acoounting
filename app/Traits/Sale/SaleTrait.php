<?php

namespace App\Traits\Sale;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

trait SaleTrait
{


    public function add_into_sale_table()
    {



        $table_one = Sale::create(
            [
                'customer_id' => $this->core->data['customer_id'],
                'customer_name' => $this->core->data['customer_name'],
                'grand_total' => $this->core->data['grand_total'],
                'sub_total' => $this->core->data['sub_total'],
                'discount' => $this->core->discount,
                'tax_amount' => $this->core->data['total_tax'],
                'date' => $this->core->data['date'],

            ]
        );
        // $this->core->sale =  $table_one;
        $this->core->sale_id =  $table_one->id;
        $this->core->stockable = $table_one;
        $this->core->paymentable = $table_one;
    }

    public function refresh_sale_table()
    {

  
        DB::table('sales')
            ->where(['id' => $this->core->sale_id])
            ->update(['daily_id' => $this->core->daily_id]);
 
    }

    // public function add_into_sale_details_table()
    // {


    //     $Details = new SaleDetail();
    //     $Details->sale_id = $this->core->sale_id;
    //     $Details->cost = $this->core->data['old'][$this->core->value]['cost'];
    //     $Details->total = $this->core->data['sub_total'];
    //     $Details->store_product_id = $this->core->id_store_product;
    //     $Details->unit_id = $this->core->unit_array[0];
    //     $Details->qty = $this->core->micro_unit_qty;
    //     $Details->save();

    //     // $this->core->id_store_product =  $this->core->data_store_product->id;

    //     // $this->core->id_store_product = ($this->core->data_store_product == null) ?0 : $this->core->data_store_product[0]['id'];



        
    // }

    // function refresh_sale_details_table()
    // {

 
    //     DB::table('sale_details')
    //         ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
    //         ->increment('qty_return', $this->core->micro_unit_qty);


    // }
}
