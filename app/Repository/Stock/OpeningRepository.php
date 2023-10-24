<?php

namespace App\Repository\Stock;
use App\Models\CashDetail;
use App\RepositoryInterface\DetailRepositoryInterface;
use DB;

class OpeningRepository implements DetailRepositoryInterface
{

    public function init_details(...$list_data){
        
        $data = $list_data['data'];
        $id = $list_data['id'];
        $id_store_product = $list_data['id_store_product'];
        
        $unit_id = (isset($list_data['unit_id'])) ? $list_data['unit_id'] : $data['unit_id'];
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
}
