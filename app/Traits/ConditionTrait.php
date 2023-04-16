<?php
namespace App\Traits;
use DB;


trait ConditionTrait{

  function all_condition($request,$table){

    $all = array();
    if ($request->post('store_id') != 0) {
        $s1 = ["$table.store_id", $request->post('store_id')];
        $all[0] = $s1;
    }
  

    if ($request->post('product_id') != 0) {

        $s2 = ["$table.product_id", $request->post('product_id')];
        $all[1] = $s2;
    }
   

    if ($request->post('status_id') != 0) {

        $s3 = ["$table.status_id", $request->post('status_id')[0]];
        $all[2] = $s3;
    }
    
    if ($request->post('desc') != 0) {

        $s4 = ["$table.desc", $request->post('desc')];
        $all[3] = $s4;
    }
      
    if ($request->post('unit_id') != 0) {

        $s5 = ["$table.unit_id", $request->post('unit_id')];
        $all[4] = $s5;
    }

return $all;

}



}