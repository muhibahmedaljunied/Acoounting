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
                'purchase_id' => $core->data['supplier_id'],
                'quantity' => $core->data['supplier_name'],
                'date' => $core->data['date'],

            ]
        );

        $this->core->purchase_id = $table_one->id;
        $this->core->purchase = $table_one;


    }

    public function add_into_purchase_return_details_table($core)
    {



        
        $details = new PurchaseReturnDetail();
        $details->purchase_return_id = $core->purchase_id;
        $details->store_product_id = $core->id_store_product;
        $details->unit_id = $core->unit_value;
        $details->qty = $core->data['qty'][$core->value];
        $details->save();
    }

    public function refresh_purchase_return_details_table()
    {


        DB::table('purchase_details')
            ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
            ->increment('qty_return', $this->core->data['old'][$this->core->value]['qty_return_now']);




    }
    
}
