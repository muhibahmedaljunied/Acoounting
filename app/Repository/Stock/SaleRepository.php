<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\Daily;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Warehouse\SaleTrait;
use App\Services\CoreService;
class SaleRepository extends Daily implements WarehouseRepositoryInterface, DetailRepositoryInterface
{

use SaleTrait;
    public $core;
    public function __construct()
    {
 
        $this->core = app(CoreService::class);
    }
    public function add()
    {


        $this->core->sale_id =  $this->add_into_sale_table($this->core);
      

    }


    public function init_details(...$list_data)
    {


        $this->add_into_sale_details_table($this->core);
        
    }



    // public function decode_unit()
    // {

    //     $this->core->unit_array = $this->core->data['unit'][$this->core->value];
    //     $this->core->unit_value = $this->core->unit_array[0];
    //     return $this;
    // }



    // function convert_qty()
    // {


    //     if ($this->core->unit_array[2] == 0) {  //this means unit_type

    //         $micro_unit_qty = $this->core->data['qty'][$this->core->value];
    //     } else {

    //         $micro_unit_qty = $this->core->data['qty'][$this->core->value] * $this->core->unit_array[1];
    //     }
    //     $this->core->micro_unit_qty = $micro_unit_qty;
    //     return $this;
    // }



 

    // public function handle(){

    //     for ($i = 0; $i < 4; $i++) {

    //         $this->data_store['count'][$i] = $i;
    //         // $this->daily->data_store['account_id'][$i] = $this->core->data['store_account'];
           
    //         if ($i == 0) {
                
    //             $this->data_store['account_id'][$i] = $this->core->data['store_account'];
    //             $this->data_store['debit'][$i] = $this->core->data['remaining'];
    //             $this->data_store['credit'][$i] = $this->core->data['paid'];
    
    //         }

    //         if ($i == 1) {
    //             // $this->daily->data_store['account_id'][$i] =$this->get_account_sale_cost();
    //             $this->data_store['account_id'][$i] =42;
    //             $this->data_store['debit'][$i] = $this->core->data['paid'];
    //             $this->data_store['credit'][$i] = $this->core->data['remaining'];


    //         }

    //         if ($i == 2) {
    //             // $this->daily->data_store['account_id'][$i] = $this->get_account_sale();
    //             $this->data_store['account_id'][$i] = 511;
    //             $this->data_store['debit'][$i] = $this->core->data['remaining'];
    //             $this->data_store['credit'][$i] = $this->core->data['paid'];

    //         }

    //         if ($i == 3) {
    //             $this->payment($i);
    //         }
    //     }

    // }


    // public function payment($i)
    // {

    //     $this->data_store['debit'][$i] = $this->core->data['paid'];
    //     $this->data_store['credit'][$i] = $this->core->data['remaining'];

    //     $this->set_acccount($i);

   
    // }

  


}
