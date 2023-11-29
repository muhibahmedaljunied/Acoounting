<?php

namespace App\Traits\Transfer;

use App\Models\StoreProduct;
use Illuminate\Support\Facades\DB;

trait StoreProductTrait
{



    public function init_store_product_table() // this intial store that transfer into it if it empty
    {


        if ($this->core->store_product_f == 0) {


            $store_product = new StoreProduct();
            $store_product->product_id = $this->core->data['old'][$this->core->value]['product_id'];
            $store_product->store_id = $this->core->data['intostore_id'];
            $store_product->status_id = $this->core->data['old'][$this->core->value]['status_id'];
            $store_product->desc = $this->core->data['old'][$this->core->value]['desc'];
            $store_product->quantity = $this->core->micro_unit_qty;
            $store_product->cost = $this->core->data['old'][$this->core->value]['cost'];
            $store_product->save();

            // dd($store_product);
            $this->core->id_store_product = $store_product->id;
        }
    }


    public function increment_store_product_table()  //this make increase for store that trasfer into it
    {
        $this->core->store_product_f = 0;

        $this->core->store_product_f =  DB::table('store_products')
            ->where(['store_id' => $this->core->data['intostore_id']])
            ->where(['product_id' => $this->core->data_store_product['product_id']])
            ->where(['status_id' => $this->core->data_store_product['status_id']])
            ->where(['desc' => $this->core->data_store_product['desc']])
            ->increment('quantity', $this->core->micro_unit_qty);
    }


    public function decrement_store_product_tale()  //this make decrease for store that trasfer from it
    {

        $this->core->store_product_f = 0;
        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->data_store_product['store_product_id']])
            ->decrement('quantity', $this->core->micro_unit_qty);
    }



    public function get_store_product_table()  // this check and return store that transfer from it
    {

        return  StoreProduct::where([
            'store_products.id' => $this->core->data['old'][$this->core->value]['store_product_id'],

        ])
            ->select(
                'store_products.id',
                'store_products.product_id',
                'store_products.status_id',
                'store_products.desc',
                
            )
            ->get();
    }
}
