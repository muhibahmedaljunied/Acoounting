<?php

namespace App\Traits\Sale;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

trait SaleDetailsTrait
{


    public function add_into_sale_details_table()
    {


        $Details = new SaleDetail();
        $Details->sale_id = $this->core->sale_id;
        $Details->price = $this->core->data['price'][$this->core->value];
        $Details->total = $this->core->data['sub_total'];
        $Details->store_product_id = $this->core->id_store_product;
        // $Details->unit_id = $this->core->unit_array[0];
        $Details->qty = $this->core->micro_unit_qty;
        $Details->save();
    }

    function refresh_qty_return_sale_details()
    {

 
        DB::table('sale_details')
            ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
            ->increment('qty_return', $this->core->micro_unit_qty);


    }
}
