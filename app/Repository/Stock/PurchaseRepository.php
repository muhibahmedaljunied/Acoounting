<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Warehouse\PurchaseTrait;
use App\Services\CoreService;
use App\RepositoryInterface\Daily;
use DB;

class PurchaseRepository extends Daily implements WarehouseRepositoryInterface, DetailRepositoryInterface
{

use PurchaseTrait;

    public $core;
    public function __construct()
    {


        $this->core = app(CoreService::class);
    }

    public function add()
    {


        $this->core->purchase_id = $this->add_into_purchase_table($this->core);

    }

    public function init_details(...$list_data)
    {

        $this->add_into_purchase_details_table($this->core);
  
    }

   


    // public function decode_unit()
    // {

    //     $this->core->unit_array = json_decode($this->core->data['unit'][$this->core->value]);
    //     $this->core->unit_value = $this->core->unit_array[0];
    //     // dd($this->core->unit_value);

    //     return $this;
    //     // return $unit[0];

    // }

    // function convert_qty()
    // {


    //     if ($this->core->unit_array[2] == 1) {  //this means unit_type

    //         $this->core->micro_unit_qty = $this->core->data['qty'][$this->core->value] * $this->core->unit_array[1];
    //     } else {
    //         $this->core->micro_unit_qty = $this->core->data['qty'][$this->core->value];
    //     }
    //     return $this;
    // }



 

    // public function handle(){

    //     for ($i = 0; $i < 2; $i++) {

    //         $this->data_store['count'][$i] = $i;
    //          if ($i == 0) {
                
    //             $this->data_store['account_id'][$i] = $this->core->data['store_account'];
    //             $this->data_store['debit'][$i] = $this->core->data['paid'];
    //             $this->data_store['credit'][$i] = $this->core->data['remaining'];
    //         }

    //         if ($i == 1) {

    //            $this->payment($i);
    //         }
    //     }

    // }
    // public function payment($i)
    // {

    //     $this->data_store['debit'][$i] = $this->core->data['remaining'];
    //     $this->data_store['credit'][$i] = $this->core->data['paid'];

    //     $this->set_acccount($i);
     
      
    // }
}
