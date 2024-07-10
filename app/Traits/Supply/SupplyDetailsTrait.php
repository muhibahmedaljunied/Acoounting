<?php

namespace App\Traits\Supply;

use App\Models\SupplyDetail;
use Illuminate\Support\Facades\DB;
trait SupplyDetailsTrait
{




    public function add_into_supply_details_table()
    {



        
        // dd($this->core->data['grand_total']);
        $Details = new SupplyDetail();
        $Details->supply_id = $this->core->supply_id;
        $Details->price = $this->core->data['price'][$this->core->value];
        $Details->total = $this->core->data['total'][$this->core->value];
        $Details->store_product_id = $this->core->id_store_product;
        // $Details->unit_id = $this->core->unit_array[0];
        $Details->qty = $this->core->micro_unit_qty;

        // $Details->grand_total = $this->core->data['grand_total'],
        $Details->save();
    }

    public function refresh_qty_return_supply_details()
    {

        DB::table('supply_details')
        ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
        ->increment('qty_return', $this->core->micro_unit_qty);

    }
}
