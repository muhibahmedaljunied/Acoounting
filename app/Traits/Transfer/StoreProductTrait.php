<?php

namespace App\Traits\Transfer;

use App\Models\StoreProduct;
use Illuminate\Support\Facades\DB;

trait StoreProductTrait
{


    public function init_store_product_table() // this intial store that transfer into it if it empty
    {


        // if ($this->init_status == false) {



            $this->core->data_store_product =  new StoreProduct();
            $this->core->data_store_product->product_id = $this->core->data['old'][$this->core->value]['product_id'];
            $this->core->data_store_product->store_id = $this->core->data['intostore_id'];
            $this->core->data_store_product->status_id = $this->core->data['old'][$this->core->value]['status_id'];
            $this->core->data_store_product->desc = $this->core->data['old'][$this->core->value]['desc'];
            $this->core->data_store_product->quantity = $this->core->micro_unit_qty;
            $this->core->data_store_product->cost = $this->core->data['old'][$this->core->value]['cost'];
            $this->core->data_store_product->total = $this->core->data['old'][$this->core->value]['cost'] * $this->core->micro_unit_qty;
            $this->core->data_store_product->save();
            $this->core->data_store_product = collect($this->core->data_store_product)->toArray();
            $this->core->id_store_product = $this->core->data_store_product['id'];
        // }
    }


    // public function refresh_transfer_qty_store_product_table($operation)  //this make increase for store that trasfer into it
    // {
    // DB::table('store_products')
    //         ->where(['id' => $this->core->data_store_product[0]['id']])
    //         ->$operation('quantity', $this->core->micro_unit_qty);
    // }


    // public function refresh_transfer_total_store_product_table($operation)  //this make increase for store that trasfer into it
    // {
       
    //     // dd($this->core->data_store_product);
    //     DB::table('store_products')
    //         ->where(['id' => $this->core->data_store_product[0]['id']])
    //         ->$operation('total',($this->core->micro_unit_qty*$this->core->data_store_product[0]['cost']));
    // }

    // public function refresh_cost_store_product_table()
    // {


    //     DB::table('store_products')
    //         ->where(['id' => $this->core->data_store_product[0]['id']])
    //         ->update(['cost' => ($this->core->data_store_product[0]['total'] / $this->core->data_store_product[0]['quantity'])]);
    // }



    public function get_store_product_table()  // this check and return store that transfer from it
    {

        
        $this->core->data_store_product = collect(
            StoreProduct::where([
                'store_products.product_id' => $this->core->data['old'][$this->core->value]['product_id'],
                'store_products.store_id' => $this->store,
                'store_products.status_id' => $this->core->data['old'][$this->core->value]['status_id'],
                'store_products.desc' => $this->core->data['old'][$this->core->value]['desc'],


            ])
                ->select(
                    'store_products.*',
                )
                ->get()
        )->toArray();


        // dd($this->core->data_store_product);
        $this->core->id_store_product = ($this->core->data_store_product == null) ? 0 : $this->core->data_store_product[0]['id'];

    }
}
