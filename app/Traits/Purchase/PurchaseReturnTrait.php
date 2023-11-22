<?php

namespace App\Traits\Purchase;

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;

trait PurchaseReturnTrait
{

    public function add_into_purchase_return_table($core)
    {


        $table_one = PurchaseReturn::create(
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

        $this->core->purchase_id = $table_one->id;
        $this->core->purchase = $table_one;

        // return $table_one;
    }

    public function add_into_purchase_return_details_table($core)
    {



        
        $Details = new PurchaseReturnDetail();
        $Details->purchase_id = $core->purchase_id;
        $Details->price = $core->data['price'][$core->value];
        $Details->qty = $core->data['qty'][$core->value];
        $Details->total = $core->data['sub_total'];
        $Details->store_product_id = $core->id_store_product;
        $Details->unit_id = $core->unit_value;
        $Details->qty = $core->data['qty'][$core->value];
        $Details->save();
    }

    public function refresh_details()
    {


        DB::table('purchase_details')
            ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
            ->increment('qty_return', $this->core->data['old'][$this->core->value]['qty_return_now']);
        // dd($result);



    }
    
}
