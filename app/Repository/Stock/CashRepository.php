<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Models\Cash;
use App\Models\CashDetail;
use DB;
class CashRepository implements StockRepositoryInterface,DetailRepositoryInterface
{

   
    public function add()
    {

        $table_one = new Cash();
        $table_one->customer_id =  $data['customer_id'];
        $table_one->customer_name =  $data['customer_name'];
        $table_one->date =  $data['date'];
        $table_one->save();
        return $table_one->id;
    }
    public function decode_unit(){
        
    }

    public function convert_qty(){
        
    }
    // public function add_temporale($request, $value)
    // {

    //     $array_unit_after_decode = $request['unit'][$value];
    //     $temporale = new Temporale();
    //     $micro_unit_qty = $this->set_unit($request, $value, $array_unit_after_decode);
    //     $temporale->product_id =  $request['product'][$value];
    //     $temporale->store_id =  $request['store'][$value];
    //     $temporale->status_id =  $request['status'][$value];
    //     $temporale->unit_id =  $array_unit_after_decode[0];
    //     $temporale->qty = $micro_unit_qty;
    //     $temporale->desc =  $request['desc'][$value];
    //     $temporale->type_process = 'Cash';
    //     $temporale->save();
    // }
    public function init_details(...$list_data){
        
        $data = $list_data['data'];
        $id = $list_data['id'];
        $id_store_product = $list_data['id_store_product'];
        
        $unit_id = (isset($list_data['unit_id'])) ? $list_data['unit_id'] : $data['unit_id'];
        $Details = new CashDetail();
        $Details->cash_id = $id;
        $Details->store_product_id = $id_store_product;
        // $Details->product_id = $data['product_id'];
        // $Details->status_id = $data['status_id'];
        // $Details->store_id = $data['store_id'];
        // $Details->desc = $data['desc'];
        $Details->unit_id = $unit_id;
        $Details->qty = $data['qty'];
        $Details->save();
    }
}
