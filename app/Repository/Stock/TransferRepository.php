<?php

namespace App\Repository\Stock;

use App\Traits\Warehouse\TransferTrait;
use App\Models\TransferDetail;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Services\CoreService;
use DB;

class TransferRepository implements WarehouseRepositoryInterface, DetailRepositoryInterface
{

    public $core;

    use TransferTrait;

    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

    public function add()
    {


        $this->core->transfer_id = $this->add_into_transfer_table($this->core);

    }


    // public function decode_unit()
    // {

    //     $this->core->unit_array = $this->core->data['unit'][$this->core->value];
    //     $this->core->unit_value = $this->core->unit_array[0];
    //     // dd($this->core->unit_array);

    //     return $this;
    //     // return $unit[0];

    // }



    // function convert_qty()
    // {


    //     if ($this->core->unit_array[2] == 0) {  //this means unit_type

    //         $micro_unit_qty = $this->core->data['qty_transfer'][$this->core->value];
    //     } else {

    //         $micro_unit_qty = $this->core->data['qty_transfer'][$this->core->value] * $this->core->unit_array[1];
    //     }
    //     $this->core->micro_unit_qty = $micro_unit_qty;
    //     return $this;
    // }


    public function init_details(...$list_data)
    {


        $unit_id = (isset($list_data['unit'])) ? $list_data['unit'] : $this->core->data['unit'][$this->core->value];

        $Details = new TransferDetail();
        $Details->transfer_id = $this->core->transfer_id;
        $Details->into_store = $this->core->data['intostore'];
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $unit_id[0];
        $Details->qty = $this->core->micro_unit_qty;

        $Details->save();
        // dd($Details->id);



    }
}
