<?php

namespace App\Traits\Cash;
use App\Models\StoreProduct;
use App\Models\Stock;
use DB;

trait StoreProductTrait
{


    function get_store_product_table()
    {

        return  StoreProduct::where([
            'store_products.id' => $this->core->data['old'][$this->core->value]['store_product_id'],

        ])
            ->select()
            ->get();

    }


    public function refresh_store_product_table(...$list_data)
    {

        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->decrement('quantity', $this->core->micro_unit_qty);
    }


}
