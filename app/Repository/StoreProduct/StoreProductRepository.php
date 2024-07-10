<?php

namespace App\Repository\StoreProduct;

use App\Models\StoreProduct;
use App\Services\CoreService;
use Illuminate\Support\Facades\DB;

class StoreProductRepository
{
    public function __construct(public  CoreService $core)
    {
    }


    public function refresh_qty_store_product_table()
    {


        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->increment('quantity', $this->core->micro_unit_qty);
    }

    public function refresh_total_store_product_table()
    {


        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->increment('total', $this->core->data['total'][$this->core->value]);
    }


    public function refresh_cost_store_product_table()
    {


        $this->get_store_product_table();

     
            DB::table('store_products')
                ->where(['id' => $this->core->data_store_product[0]['id']])
                ->update(['cost'=>
                ($this->core->data_store_product[0]['total'] / $this->core->data_store_product[0]['quantity'])]);
        
    }

}
