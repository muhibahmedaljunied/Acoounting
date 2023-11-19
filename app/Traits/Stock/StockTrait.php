<?php

namespace App\Traits\Stock;

use DB;
use App\Models\Stock;

trait StockTrait
{

  // function refresh_stock(...$list_data)
  // {

  //   $stock_f = DB::table('stocks')
  //     ->where('product_id', $data['product_id'])
  //     ->where('type_operation', $data['type'])
  //     ->where('store_id', $data['store_id'])
  //     ->where('status_id', $data['status_id'])
  //     ->where('unit_id', $data['unit_id'])
  //     ->where('desc', $data['desc'])
  //     ->$type('quantity', $qty);
  //   return $stock_f;
  // }


  // function init_stock(...$list_data)
  // {


  //   $stocks = new Stock();
  //   $stocks->product_id = $data['product_id'];
  //   $stocks->store_id = $data['store_id'];
  //   $stocks->status_id = $data['status_id'];
  //   $stocks->unit_id = $data['unit_id'];
  //   $stocks->desc = $data['desc'];
  //   $stocks->type_operation = $data['type'];
  //   $stocks->quantity = $qty;
  //   $stocks->date = $data['date'];
  //   $stocks->save();
  //   // }
  // }
}
