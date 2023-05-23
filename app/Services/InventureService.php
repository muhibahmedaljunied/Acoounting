<?php

namespace App\Services;
use App\Models\StoreProduct;
use App\Models\Stock;
use Illuminate\Http\Request;
use DB;

class InventureService
{

    function refresh_stock($data,$id=null,$type_refresh =null)
    {
  
      $type = ($type_refresh) ? $type_refresh : $data['type_refresh'];
  
  
      $stock_f = DB::table('stocks')
        ->where('product_id', $data['product_id'])
        ->where('type_operation', $data['type'])
        ->where('store_id', $data['store_id'])
        ->where('status_id', $data['status_id'])
        ->where('unit_id', $data['unit_id'])
        ->where('desc', $data['desc'])
        ->$type('quantity', $data['qty']);
      return $stock_f;
    }
  
  
    function init_stock($data,$id=null)
    {
  
  
  
      $stocks = new Stock();
      $stocks->product_id = $data['product_id'];
      $stocks->store_id = $data['store_id'];
      $stocks->status_id = $data['status_id'];
      $stocks->unit_id = $data['unit_id'];
      $stocks->desc = $data['desc'];
      $stocks->type_operation = $data['type'];
      $stocks->quantity = $data['qty'];
      $stocks->date = $data['date'];
      $stocks->save();
      // }
    }

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
