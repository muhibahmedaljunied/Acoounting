<?php

namespace App\Traits\Purchase;

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use Illuminate\Support\Facades\DB;
trait PurchaseReturnTrait
{

    public function add_into_purchase_return_table()
    {

        $return = new PurchaseReturn();
        $return->purchase_id = $this->core->data['purchase_id'];
        $return->date  = $this->core->data['date'];
        $return->save();

        $this->core->return_id = $return->id;
        // $this->core->return = $return;
        $this->core->stockable = $return;
        $this->core->paymentable = $return;


    }

    public function refresh_purchase_return_table()
    {

        DB::table('purchase_returns')
        ->where(['id' => $this->core->return_id])
        ->update(['daily_id' => $this->core->daily_id]);

    }


    public function add_into_purchase_return_details_table()
    {

        $Details = new PurchaseReturnDetail();
        $Details->purchase_return_id = $this->core->return_id;
        $Details->store_product_id = $this->core->id_store_product;
        // $Details->unit_id = $this->core->unit_value;
        // $Details->unit_id = $this->core->unit_array[0];
        $Details->qty = $this->core->micro_unit_qty;
        $Details->save();
    }

    
}
