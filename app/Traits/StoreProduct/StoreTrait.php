<?php

namespace App\Traits\StoreProduct;

use DB;

trait StoreTrait
{
    function refresh_store($value, $type)
    {


       
            $store_product_f = DB::table('store_products')
                ->where('product_id', $value['product_id'])
                ->where('store_id', $value['store_id'])
                ->where('status_id', $value['status_id'])
                // ->where('unit_id', $value['unit_id'])
                ->where('desc', $value['desc'])
                ->$type('quantity', $value['micro_unit_qty']);

            return $store_product_f;
    }

    function refresh_store_from_opening($value,$data,$qty)
    {


       
            $store_product_f = DB::table('store_products')
                ->where('product_id', $data['product_id'][$value])
                ->where('store_id', $data['store_id'][$value])
                ->where('status_id', $data['status_id'][$value])
                // ->where('unit_id', $value['unit_id'])
                ->where('desc', $data['desc'][$value])
                ->increment('quantity', $qty);

            return $store_product_f;
    }

    function refresh_store_from_return($value,$data,$qty)
    {
       
            $type = $data['type_refresh'];
            $store = $data['store_id'][$value];

            // if ($type == 'decrement') {

                // $store = $data['store_id'][$value];
            // }
            
            $store_product_f = DB::table('store_products')
                ->where('product_id', $data['product_id'][$value])
                ->where('store_id', $store)
                ->where('status_id', $data['status_id'][$value])
                ->where('desc', $data['desc'][$value])
                ->$type('quantity', $qty);
            return $store_product_f;
        
    }

    function refresh_store_from_transfer($value,$data,$qty,$type){

         
        // return $data['product_id'][$value];
        $store = $data['store_id'][$value];

        if ($type == 'increment') {

            $store = $data['intostore_id'][$value];
        }
        
        $store_product_f = DB::table('store_products')
            ->where('product_id', $data['product_id'][$value])
            ->where('store_id', $store)
            ->where('status_id', $data['status_id'][$value])
            ->where('desc', $data['desc'][$value])
            ->$type('quantity', $qty);
        return $store_product_f;
    }





    // function refresh_store($value,$operation, $type, $data = null)
    // {


        // if ($data !== null) {


        //     $qty = $data['micro_unit_qty'][$value];


        //     $store = $data['store_id'][$value];

        //     if ($type == 'increment') {
            
        //         $store = $data['intostore_id'][$value];
        //     }
        //     if ($type == 'decrement') {

        //         $store = $data['store_id'][$value];
        //     }
        //     $store_product_f = DB::table('store_products')
        //         ->where('product_id', $data['product_id'][$value])
        //         ->where('store_id', $store)
        //         // ->where('unit_id', $data['unit_id'][$value])

        //         ->where('status_id', $data['status_id'][$value])
        //         ->where('desc', $data['desc'][$value])
        //         ->$type('quantity', $qty);

        //     return $store_product_f;
        // } else {
            // if ($operation == 'Supply' || $operation == 'Cash' || $operation == 'Purchase' || $operation == 'Sale' ){
            
                // $qty = $value['micro_unit_qty'];

            // } else {

            //     $qty = $value['qty_remain'];
            // }
            // $store = $value['store_id'];

            // if ($type == 'increment') {

            //     $store = $value['intostore_id'];

            // }
            // if ($type == 'decrement') {

            //     $store = $value['store_id'];
            // }
            // $store_product_f = DB::table('store_products')
            //     ->where('product_id', $value['product_id'])
            //     ->where('store_id', $store)
            //     ->where('status_id', $value['status_id'])
            //     // ->where('unit_id', $value['unit_id'])
            //     ->where('desc', $value['desc'])
            //     ->$type('quantity', $qty);

            // return $store_product_f;
        // }
    // }

}
