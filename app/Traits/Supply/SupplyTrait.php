<?php

namespace App\Traits\Supply;

use App\Models\Supply;
use App\Models\SupplyDetail;
use Illuminate\Support\Facades\DB;
trait SupplyTrait
{

    public function add_into_supply_table()
    {


        $table_one = Supply::create(
            [
                'supplier_id' => $this->core->data['supplier_id'],
                'supplier_name' => $this->core->data['supplier_name'],
                'grand_total' => $this->core->data['grand_total'],
                'date' => $this->core->data['date'],

            ]
        );

        $this->core->supply_id = $table_one->id;
        $this->core->supply = $table_one;

        // return $table_one;
    }

    public function refresh_supply_table()
    {


        DB::table('supplies')
            ->where(['id' => $this->core->supply_id])
            ->update(['daily_id' => $this->core->daily_id]);
    }


    public function add_into_supply_details_table()
    {



        
        // dd($this->core->data['grand_total']);
        $Details = new SupplyDetail();
        $Details->supply_id = $this->core->supply_id;
        $Details->cost = $this->core->data['price'][$this->core->value];
        $Details->total = $this->core->data['grand_total'];
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->micro_unit_qty;
        $Details->save();
    }
}
