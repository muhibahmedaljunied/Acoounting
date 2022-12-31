<?php

namespace App\Traits;

use DB;
use App\Models\Stock;

trait StockTrait
{

  function refresh_stock($id, $value,$type, $type_refresh,$data= null)
  {


    if($data != null){

      if ($type == 'supply' || $type == 'cash'  || $type == 'purchase'  || $type == 'sale' || $type == 'transfer') {

        $qty = $data['qty'][$value];
      } else {
  
        $qty = $data['qty_remain'][$value];
      }
  
      $stock_f = DB::table('stocks')
        ->where('product_id', $data['product_id'][$value])
        ->where('type_operation', $type)
        ->where('number_operation', $id)
        // ->where('number_operation',1)
        ->where('store_id', $data['store_id'][$value])
        ->where('status_id', $data['status_id'][$value])
        ->where('desc', $data['desc'][$value])
        ->$type_refresh('quantity', $qty);
  
      return $stock_f;

    }else{

      if ($type == 'supply' || $type == 'cash'  || $type == 'purchase'  || $type == 'sale' || $type == 'transfer') {

        $qty = $value['qty'];
      } else {
  
        $qty = $value['qty_remain'];
      }
  
  
      $stock_f = DB::table('stocks')
        ->where('product_id', $value['product_id'])
        ->where('type_operation', $type)
        ->where('number_operation', $id)
        // ->where('number_operation',1)
        ->where('store_id', $value['store_id'])
        ->where('status_id', $value['status_id'])
        ->where('desc', $value['desc'])
        ->$type_refresh('quantity', $qty);
  
      return $stock_f;
    }


    
  }


  function init_stock($id, $value, $type, $date,$data = null)
  {

    if($data != null){

      if ($type == 'supply' || $type == 'cash'  || $type == 'purchase'  || $type == 'sale' || $type == 'transfer') {

        $qty = $data['qty'][$value];
      } else {
  
        $qty = $data['qty_remain'][$value];
      }
  
  
  
      $stocks = new Stock();
      $stocks->product_id = $data['product_id'][$value];
      $stocks->store_id = $data['store_id'][$value];
      $stocks->status_id = $data['status_id'][$value];
      $stocks->desc = $data['desc'][$value];
      $stocks->type_operation = $type;
      $stocks->number_operation = $id;
      // $stocks->number_operation = 1;
      $stocks->quantity = $qty;
      $stocks->date = $date;
      $stocks->save();
  
      return $stocks;
    }else{
      if ($type == 'supply' || $type == 'cash'  || $type == 'purchase'  || $type == 'sale') {

        $qty = $value['qty'];
      } else {
  
        $qty = $value['qty_remain'];
      }
  
  
  
      $stocks = new Stock();
      $stocks->product_id = $value['product_id'];
      $stocks->store_id = $value['store_id'];
      $stocks->status_id = $value['status_id'];
      $stocks->desc = $value['desc'];
      $stocks->type_operation = $type;
      $stocks->number_operation = $id;
      // $stocks->number_operation = 1;
      $stocks->quantity = $qty;
      $stocks->date = $date;
      $stocks->save();
  
      return $stocks;

    }

   
  }
}
