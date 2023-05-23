<?php

namespace App\Traits\StoreProduct;

use DB;
use App\Models\StoreProduct;

trait StoreProductTrait
{

    function get($data)
    {


        $id_store_product = StoreProduct::where([
            'store_products.product_id' => $data['product_id'],
            'store_products.store_id' => $data['store_id'],
            'store_products.status_id' => $data['status_id'],
            'store_products.desc' => $data['desc']
        ])
            ->select('store_products.id')
            ->get();

        $response = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];
        return $response;
    }


    function init_store($data,$store_id = null)
    {
        $store_id = ($store_id) ? $store_id : $data['store_id'] ;

        $store_product = new StoreProduct();
        $store_product->product_id = $data['product_id'];
        $store_product->store_id = $store_id;
        $store_product->status_id = $data['status_id'];
        $store_product->desc = $data['desc'];
        $store_product->quantity = $data['qty'];
        $store_product->save();
        return $store_product->id;
    }

    function refresh_store($data, $type_refresh = null, $store_id = null)
    {

        $type_refresh = ($type_refresh) ? $type_refresh : $data['type_refresh'] ;
        $store_id = ($store_id) ? $store_id : $data['store_id'] ;
        $condition = [
            'product_id' => $data['product_id'],
            'status_id' => $data['status_id'],
            'store_id' => $store_id,
            'desc' => $data['desc'],
        ];

        $store_product_f = DB::table('store_products')->where($condition)->$type_refresh('quantity', $data['qty']);
        return $store_product_f;
    }
}
