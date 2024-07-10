<?php

namespace App\Traits\Purchase;

use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;
trait PurchaseDetailsTrait
{



    public function add_into_purchase_details_table()
    {


        
      
        $Details = new PurchaseDetail();
        $Details->purchase_id = $this->core->purchase_id;
        $Details->price = $this->core->data['price'][$this->core->value];
        $Details->total = $this->core->data['grand_total'];
        $Details->store_product_id = $this->core->id_store_product;
        // $Details->unit_id = $this->core->unit_array[0];
        $Details->qty = $this->core->micro_unit_qty;
        // $Details->qty = $this->core->data['qty'][$this->core->value];

        $Details->save();
        // dd($Details->id);
    }

    public function refresh_qty_return_purchase_details()
    {

        DB::table('purchase_details')
        ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
        ->increment('qty_return', $this->core->micro_unit_qty);


    }
}
