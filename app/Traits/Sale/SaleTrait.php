<?php

namespace App\Traits\Sale;

use App\Models\Sale;
use App\Models\SaleDetail;

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
                'status' => 'pendding',
                'date' => $this->core->data['date'],

            ]
        );
        $this->core->sale =  $table_one;
        $this->core->sale_id =  $table_one->id;
 
    }

    public function add_into_sale_details_table()
    {


        $Details = new SaleDetail();
        $Details->sale_id = $this->core->sale_id;
        $Details->price = $this->core->data['old'][$this->core->value]['cost'];
        $Details->qty = $this->core->data['qty'][$this->core->value];
        $Details->total = $this->core->data['sub_total'];
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->data['qty'][$this->core->value];
        $Details->save();
    }
}