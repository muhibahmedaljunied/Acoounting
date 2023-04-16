<?php

namespace App\Traits\Stock;

use DB;
use App\Models\Stock;

trait StockTrait
{

  function refresh_stock($id, $value, $type, $type_refresh, $data = null)
  {



    if ($data != null) {


      $unit = $data['unit_id'][$value];

      if ($type == 'Opening') {

        $unit = json_decode($data['unit_id'][$value]);
      }


      // if ($type == 'Supply' || $type == 'Cash'  || $type == 'Purchase'  || $type == 'Sale' || $type == 'Transfer') {

      //   $qty = $data['qty'][$value];

      // }else
      // if ($type == 'SupplyReturn' || $type == 'CashReturn'  || $type == 'PurchaseReturn'  || $type == 'SaleReturn' || $type == 'Transfer'|| $type == 'TransferReturn') {
      $qty = $data['qty'][$value];

      // } else {

      //   $qty = $data['qty_remain'][$value];
      // }

      $stock_f = DB::table('stocks')
        ->where('product_id', $data['product_id'][$value])
        ->where('type_operation', $type)
        // ->where('number_operation', $id)
        // ->where('number_operation',1)
        ->where('store_id', $data['store_id'][$value])
        ->where('status_id', $data['status_id'][$value])
        ->where('unit_id', $unit[0])
        ->where('desc', $data['desc'][$value])
        ->$type_refresh('quantity', $qty);

      return $stock_f;
    } else {

      if ($type == 'Supply' || $type == 'Cash'  || $type == 'Purchase'  || $type == 'Sale') {

        $qty = $value['qty'];
      } else {

        $qty = $value['qty_remain'];
      }


      $stock_f = DB::table('stocks')
        ->where('product_id', $value['product_id'])
        ->where('type_operation', $type)
        // ->where('number_operation', $id)
        // ->where('number_operation',1)
        ->where('store_id', $value['store_id'])
        ->where('status_id', $value['status_id'])
        ->where('unit_id', $value['unit_id'])

        ->where('desc', $value['desc'])
        ->$type_refresh('quantity', $qty);

      return $stock_f;
    }
  }


  function init_stock($id, $value, $type, $date, $data = null)
  {

    if ($data != null) {


      $unit = $data['unit_id'][$value];

      if ($type == 'Opening') {

        $unit = json_decode($data['unit_id'][$value]);
      }

      $qty = $data['qty'][$value];
      $stocks = new Stock();
      $stocks->product_id = $data['product_id'][$value];
      $stocks->store_id = $data['store_id'][$value];
      $stocks->status_id = $data['status_id'][$value];
      $stocks->unit_id = $unit[0];

      $stocks->desc = $data['desc'][$value];
      $stocks->type_operation = $type;
      // $stocks->number_operation = $id;
      // $stocks->number_operation = 1;
      $stocks->quantity = $qty;
      $stocks->date = $date;
      $stocks->save();

      return $stocks;
    } else {
      // if ($type == 'Supply' || $type == 'Cash'  || $type == 'Purchase'  || $type == 'Sale') {

      $qty = $value['qty'];

      // } else {

      //   $qty = $value['qty_remain'];
      // }



      $stocks = new Stock();
      $stocks->product_id = $value['product_id'];
      $stocks->store_id = $value['store_id'];
      $stocks->status_id = $value['status_id'];
      $stocks->unit_id = $value['unit_id'];

      $stocks->desc = $value['desc'];
      $stocks->type_operation = $type;
      // $stocks->number_operation = $id;
      // $stocks->number_operation = 1;
      $stocks->quantity = $qty;
      $stocks->date = $date;
      $stocks->save();

      return $stocks;
    }
  }
}
