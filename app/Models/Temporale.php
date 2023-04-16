<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Temporale extends Model
{
  protected $fillable = [
    'product_id', 'customer_id', 'qty', 'type_process'
  ];



  public function scopeWhereall($query, $request, $value, $type)

  {

    $array_unit_after_decode = $request['unit'][$value];
    // return $array_unit_after_decode;



    if ($type == 'Supply' || $type == 'Purchase' || $type == 'Transfer' ) {
      $array_unit_after_decode = json_decode($request['unit'][$value]);
      return $query->where([
        'product_id' => $request['product'][$value],
        'type_process' => $type,
        'store_id' => $request['store'][$value],
        'status_id' => $request['status'][$value],
        'unit_id' => $array_unit_after_decode[0],
        'desc' => $request['desc'][$value]
      ]);
    } else {

      return $query->where([
        'product_id' => $request['product'][$value],
        'type_process' => $type,
        'store_id' => $request['store'][$value],
        'unit_id' => $array_unit_after_decode[0],
        'status_id' => $request['status'][$value],
        'desc' => $request['desc'][$value]
      ]);
    }
  }


  //     public function scopeWhereall($query,$value,$type)

  //     {

  //       if($type == 'supply' || $type == 'purchase'){

  //         return $query->where([
  //             'product_id' =>$value['product_id'],
  //             'type_process' => $type,
  //             'store_id' => $value['store'][0],
  //             // 'shelve_id' => $value['store'][1], 
  //             'status_id' => $value['status'], 
  //             'desc' => $value['desc']
  //         ]);

  //       }else{

  //         return $query->where([
  //             'product_id' =>$value['product_id'],
  //             'type_process' => $type,
  //             'store_id' => $value['store'],
  //             // 'shelve_id' => $value['shelve'], 
  //             'status_id' => $value['status'], 
  //             'desc' => $value['desc']
  //         ]);

  //       }


  // }

}
