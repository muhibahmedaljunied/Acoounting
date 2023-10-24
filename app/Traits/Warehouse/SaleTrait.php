<?php

namespace App\Traits\Warehouse;

use App\Models\Sale;
use App\Models\SaleDetail;

trait SaleTrait
{


    public function add_into_sale_table($core)
    {


        $table_one = Sale::create(
            [
                'supplier_id' => $core->data['supplier_id'],
                'supplier_name' => $core->data['supplier_name'],
                'grand_total' => $core->data['grand_total'],
                'sub_total' => $core->data['sub_total'],
                'discount' => $core->discount,
                'tax_amount' => $core->data['total_tax'],
                'status' => 'pendding',
                'date' => $core->data['date'],

            ]
        );

        return $table_one->id;
    }

    public function add_into_sale_details_table($core)
    {
        $Details = new SaleDetail();
        $Details->purchase_id = $core->purchase_id;
        $Details->price = $core->data['price'][$this->core->value];
        $Details->qty = $core->data['qty'][$this->core->value];
        $Details->total = $core->data['sub_total'];
        $Details->store_product_id = $core->id_store_product;
        $Details->unit_id = $core->unit_value;
        $Details->qty = $core->data['qty'][$this->core->value];
        $Details->save();
    }
}
