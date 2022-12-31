<?php

namespace App\Traits;

use DB;

trait StoreTrait
{

    function refresh_store($value,$operation, $type, $data = null)
    {



        if ($data !== null) {


            $qty = $data['qty'][$value];


            $store = $data['store_id'][$value];

            if ($type == 'transfer_increment') {
                $type = 'increment';
                $store = $data['intostore_id'][$value];
            }
            if ($type == 'decrement') {

                $store = $data['store_id'][$value];
            }
            $store_product_f = DB::table('store_products')
                ->where('product_id', $data['product_id'][$value])
                ->where('store_id', $store)

                ->where('status_id', $data['status_id'][$value])
                ->where('desc', $data['desc'][$value])
                ->$type('quantity', $qty);

            return $store_product_f;
        } else {
            if ($operation == 'supply' || $operation == 'cash' || $operation == 'purchase' || $operation == 'sale' || $type == 'transfer'){

                $qty = $value['qty'];
            } else {

                $qty = $value['qty_remain'];
            }
            $store = $value['store_id'];

            if ($type == 'transfer_increment') {
                $type = 'increment';
                $store = $value['intostore_id'];
            }
            if ($type == 'decrement') {

                $store = $value['store_id'];
            }
            $store_product_f = DB::table('store_products')
                ->where('product_id', $value['product_id'])
                ->where('store_id', $store)
                ->where('status_id', $value['status_id'])
                ->where('desc', $value['desc'])
                ->$type('quantity', $qty);

            return $store_product_f;
        }
    }
}
