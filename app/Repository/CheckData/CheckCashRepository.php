<?php

namespace App\Repository\CheckData;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\ReturnRepositoryInterface;

use App\Models\CashDetail;
use App\Models\CashReturn;
use DB;

class CheckCashRepository implements DetailRepositoryInterface,ReturnRepositoryInterface
{

    
    public function init_details(...$list_data){
        
        $data = $list_data['data'];
        $id = $list_data['id'];
        $id_store_product = $list_data['id_store_product'];
        $unit_id = ($list_data['unit_id']) ? $list_data['unit_id'] : $data['unit_id'];

        
        $Details = new CashDetail();
        $Details->cash_id = $id;
        $Details->store_product_id = $id_store_product;
        $Details->product_id = $data['product_id'];
        $Details->status_id = $data['status_id'];
        $Details->store_id = $data['store_id'];
        $Details->unit_id = $unit_id;
        $Details->desc = $data['desc'];
        $Details->qty = $data['qty'];
        $Details->save();
    }

    // function store_return($request)
    // {

    //     $return = new CashReturn();
    //     $return->cash_id = $request['id']; #this equal cash_id
    //     $return->date  = $request['date'];
    //     // $return->quantity = $request->post('total');
    //     $return->note  = $request['note'];
    //     $return->save();
    //     return $return->id;
    // }

    public function check_detail(){

        $detail = DB::table('cash_return_details')
        ->select('cash_return_details.*')
        ->get();

         return $detail;
    }

    public function check_return($value)
    {

        $qty_return_now = $value['qty_return_now'];
        $qty_remain = $value['qty_remain'];
        $qty = $value['qty'];


        foreach ($value['units'] as $key => $values) {   //this for converts qty_return into micro unit

            //[0] =id,[1] = rate,[2] = unit_type
            if ($value['unit_selected'][2] == 1) {


                $qty_return_now = $value['qty_return_now'] * $value['rate'];
                $qty_remain = $value['qty_remain'] * $value['rate'];
                $qty = $value['qty'] * $value['rate'];
            }
        }

        // -------------------------------------------------------------------------------------------------------------------
        if ($qty_return_now > $value['avilable_qty']) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المتوفره"];
        }

        if ($qty_return_now > $qty_remain) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المسموح بها"];
        }

        if ($qty_return_now > $qty) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المباعه"];
        }

        if ($qty_remain == 0) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"];
        }
        return ['message' => 1, 'qty' => $qty_return_now];
        
    }
    
        
}

