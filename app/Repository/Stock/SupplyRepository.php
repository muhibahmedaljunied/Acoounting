<?php

namespace App\Repository\Stock;

use App\Models\Supply;
use App\Models\Temporale;
use App\Models\SupplyDetail;

use App\Traits\Temporale\TemporaleTrait;
use DB;
use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\TemporaleRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
class SupplyRepository implements StockRepositoryInterface,TemporaleRepositoryInterface,DetailRepositoryInterface
{

    use TemporaleTrait;
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
    // public function add_temporale($request, $value)
    // {

    //     $array_unit_after_decode = $request['unit'][$value];

    //     $temporale = new Temporale();
    //     $array_unit_after_decode = json_decode($request['unit'][$value]);
    //     $micro_unit_qty = $this->set_unit($request, $value, $array_unit_after_decode);
    //     $temporale->product_id =  $request['product'][$value];
    //     $temporale->store_id =  $request['store'][$value];
    //     $temporale->status_id =  $request['status'][$value];
    //     $temporale->unit_id =  $array_unit_after_decode[0];
    //     $temporale->qty = $micro_unit_qty;
    //     $temporale->desc =  $request['desc'][$value];
    //     $temporale->type_process = 'Supply';
    //     $temporale->save();
    // }
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
