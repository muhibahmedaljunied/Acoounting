<?php

namespace App\Traits\StoreProduct;

use DB;
use App\Models\StoreProduct;

trait StoreProductTrait
{

    function get($value, $data = null)
    {

// return $data['desc'][$value];
        if ($data != null) {
            $id_store_product = StoreProduct::where([
                'store_products.product_id' => $data['product_id'][$value],
                'store_products.store_id' => $data['store_id'][$value],
                'store_products.status_id' => $data['status_id'][$value],
                // 'store_products.unit_id' => $data['unit_id'][$value],
                'store_products.desc' => $data['desc'][$value]
            ])
                ->select('store_products.id')
                ->get();

            return $id_store_product;
        } else {
            $id_store_product = StoreProduct::where([
                'store_products.product_id' => $value['product_id'],
                'store_products.store_id' => $value['store_id'],
                'store_products.status_id' => $value['status_id'],
                // 'store_products.unit_id' => $value['unit_id'],
                'store_products.desc' => $value['desc']
            ])
                ->select('store_products.id')
                ->get();

            return $id_store_product;
        }
    }


    function init_store($value, $operation,$data = null,$qty = null)
    {


        if ($operation == 'Supply' || $operation == 'Cash' || $operation == 'Purchase' || $operation == 'Sale' || $operation == 'Transfer' || $operation == 'Opening') {

            if ($operation == 'Transfer') {
                // return $data['status_id'][$value];
                // $qty = $qty;
                $store = $data['intostore_id'][$value];
                // ----------------------------------------------------------------
                $store_product = new StoreProduct();
                $store_product->product_id = $data['product_id'][$value];
                $store_product->store_id = $store;
                $store_product->status_id = $data['status_id'][$value];
                $store_product->desc = $data['desc'][$value];
                $store_product->quantity = $qty;
                $store_product->save();
        
                $id = $store_product->id;
                return $id;


            } 
            if ($operation == 'Opening') {
                // return $data['status_id'][$value];
           
                // ----------------------------------------------------------------
                $store_product = new StoreProduct();
                $store_product->product_id = $data['product_id'][$value];
                $store_product->store_id = $data['store_id'][$value];
                $store_product->status_id = $data['status_id'][$value];
                $store_product->desc = $data['desc'][$value];
                $store_product->quantity = $qty;
                $store_product->save();
        
                $id = $store_product->id;
                return $id;


            }else {
                $qty = $value['micro_unit_qty'];
                $store = $value['store_id'];
            }
        } 
       

        $store_product = new StoreProduct();
        $store_product->product_id = $value['product_id'];
        $store_product->store_id = $store;
        $store_product->status_id = $value['status_id'];
        $store_product->desc = $value['desc'];
        $store_product->quantity = $qty;
        $store_product->save();
        $id = $store_product->id;
        return $id;
    }

    // function init_store_from_retrn($value, $operation, $type = null, $data = null)
    // {



    //         if ($operation == 'Transfer') {
    //             $qty = $data['micro_unit_qty'][$value];
    //             $store = $data['intostore_id'][$value];
    //             // ----------------------------------------------------------------
    //             $store_product = new StoreProduct();
    //             $store_product->product_id = $data['product_id'][$value];
    //             $store_product->store_id = $store;
    //             $store_product->status_id = $data['status_id'][$value];
    //             // $store_product->unit_id = $data['unit_id'][$value];

    //             $store_product->desc = $data['desc'][$value];
    //             $store_product->quantity = $qty;
    //             $store_product->save();
        
    //             $id = $store_product->id;
    //             return $id;


    //         } else {
    //             $qty = $value['micro_unit_qty'];
    //             $store = $value['store_id'];
    //         }
       

    // }
    

}
