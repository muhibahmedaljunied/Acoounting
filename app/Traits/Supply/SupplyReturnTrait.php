<?php

namespace App\Traits\Supply;

use App\Models\SupplyReturn;
use App\Models\SupplyReturnDetail;
use Illuminate\Support\Facades\DB;
trait SupplyReturnTrait
{

    public function add_into_supply_return_table()
    {

        $return = new SupplyReturn();
        $return->supply_id = $this->core->data['supply_id'];
        $return->date  = $this->core->data['date'];
        $return->save();

        $this->core->return_id = $return->id;
        $this->core->return = $return;
    }

    public function refresh_supply_return_table()
    {

        DB::table('supply_returns')
        ->where(['id' => $this->core->return_id])
        ->update(['daily_id' => $this->core->daily_id]);

    }


    public function add_into_supply_return_details_table()
    {

        $Details = new SupplyReturnDetail();
        $Details->supply_return_id = $this->core->return_id;
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->micro_unit_qty;
        $Details->save();
    }

    public function refresh_supply_details_table()
    {

        DB::table('supply_details')
        ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
        ->increment('qty_return', $this->core->micro_unit_qty);

    }
}
