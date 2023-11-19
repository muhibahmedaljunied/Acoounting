<?php

namespace App\Traits\Transfer;
use App\Models\StoreProduct;


trait StoreProductTrait
{


  
    public function init_store_product_table()
    {


       
        $store_product = new StoreProduct();
        $store_product->product_id = $this->core->data['old'][$this->core->value]['product_id'];
        $store_product->store_id = $this->core->data['old'][$this->core->value]['store_id'];
        $store_product->status_id = $this->core->data['old'][$this->core->value]['status_id'];
        $store_product->desc = $this->core->data['old'][$this->core->value]['desc'];
        $store_product->quantity = $this->core->micro_unit_qty;
        $store_product->cost = $this->core->data['old'][$this->core->value]['cost'];
        $store_product->save();
        $this->core->id_store_product = $store_product->id;
    }


    public function increment_store_product_table(){

        $this->core->store_product_f =  DB::table('store_products')
        ->where(['store_id' => $this->core->data['intostore_id']])
        ->increment('quantity', $this->core->micro_unit_qty);

    }


    public function decrement_store_product_tale(){
        

        $this->core->store_product_f =  DB::table('store_products')
        ->where(['id' => $this->core->id_store_product])
        ->decrement('quantity', $this->core->micro_unit_qty);
    }


    
    public function get_store_product_table()
    {

        return  StoreProduct::where([
            'store_products.id' => $this->core->data['old'][$this->core->value]['store_product_id'],

        ])
            ->select()
            ->get();

      


    }


    
  
}
