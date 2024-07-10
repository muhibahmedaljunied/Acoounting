<?php

namespace App\Traits\Cash;
use App\Models\Cash;
use App\Models\CashDetail;
use Illuminate\Support\Facades\DB;

trait CashDetailsTrait
{


    public function add_into_cash_details_table()
    {

        
        $Details = new CashDetail();
        $Details->cash_id = $this->core->cash_id;
        $Details->price = $this->core->data['old'][$this->core->value]['price'];
        $Details->total = $this->core->data['total'][$this->core->value];
        $Details->store_product_id = $this->core->id_store_product;
        // $Details->unit_id = $this->core->unit_array[0];
        $Details->qty = $this->core->micro_unit_qty;
        $Details->save();


    }
    function refresh_qty_return_cash_details()
    {

 
        DB::table('cash_details')
            ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
            ->increment('qty_return', $this->core->micro_unit_qty);


    }
}
