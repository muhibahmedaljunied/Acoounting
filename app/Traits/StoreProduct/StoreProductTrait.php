<?php

namespace App\Traits\StoreProduct;

use DB;
use App\Models\StoreProduct;
use App\Services\CoreService;

trait StoreProductTrait
{

   
  
    // function get($data)
    // {


    //     $id_store_product = StoreProduct::where([
    //         'store_products.product_id' => $data['product_id'],
    //         'store_products.store_id' => $data['store_id'],
    //         'store_products.status_id' => $data['status_id'],
    //         'store_products.desc' => $data['desc']
    //     ])
    //         ->select('store_products.id')
    //         ->get();

    //     $response = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];
       
    //     return $response;
    // }


    // function init_store(...$list_data)
    // {
    //     $data = $list_data['data'];
 
    //     // $store_id = $list_data['store_id'];
    //     // $qty = $list_data['qty'];

    //     $store_id = (isset($list_data['store_id'])) ? $list_data['store_id'] : $data['store_id'];
    //     $qty = (isset($list_data['qty'])) ? $list_data['qty'] : $data['qty'];
    //     $store_product = new StoreProduct();
    //     $store_product->product_id = $data['product_id'];
    //     $store_product->store_id = $store_id;
    //     $store_product->status_id = $data['status_id'];
    //     $store_product->desc = $data['desc'];
    //     $store_product->quantity = $qty;
    //     $store_product->save();
    //     // $this->core->id_store_product = $store_product->id;
    //     return $store_product->id;
    // }

    // function refresh_store(...$list_data)

    // {
      
    //     $data = $list_data['data'];
    //     // $data = $this->core->data;
    //     $type_refresh = (isset($list_data['type_refresh'])) ? $list_data['type_refresh'] : $data['type_refresh'];
    //     $store_id = (isset($list_data['store_id'])) ? $list_data['store_id'] : $data['store_id'];
    //     $qty = (isset($list_data['qty'])) ? $list_data['qty'] : $data['qty'];
    //     $condition = [
    //         'product_id' => $data['product_id'],
    //         'status_id' => $data['status_id'],
    //         'store_id' => $store_id,
    //         'desc' => $data['desc'],
    //     ];

    //     $store_product_f = DB::table('store_products')->where($condition)->$type_refresh('quantity', $qty);
    //     // $this->core->store_product_f = $store_product_f;
    //     return $store_product_f;
    // }
}
