<?php

namespace App\Repository\Return;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Models\CashDetail;
use DB;

class CashReturnRepository implements DetailRepositoryInterface
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


    public function check_detail(){

        $detail = DB::table('cash_return_details')
        ->select('cash_return_details.*')
        ->get();

         return $detail;
    }

        
}

