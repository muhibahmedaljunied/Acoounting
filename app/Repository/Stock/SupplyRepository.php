<?php

namespace App\Repository\Stock;
use App\Models\Supply;
use App\Models\SupplyDetail;
class SupplyRepository
{

    public function add()
    {




        $table_one = Supply::create(
            [
                'supplier_id' => $data['supplier_id'],
                'supplier_name' => $data['supplier_name'],
                'date' => $data['date']
            ]
        );


        return $table_one->id;
    }

    public function decode_unit(){
        
    }
    public function convert_qty(){
        
    }

    public function init_details(...$list_data){
        
        $data = $list_data['data'];
        $id = $list_data['id'];
        $id_store_product = $list_data['id_store_product'];

         $unit_id = (isset($list_data['unit_id'])) ? $list_data['unit_id'] : $data['unit_id'];

        $Details = new SupplyDetail();
        $Details->supply_id = $id;
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
