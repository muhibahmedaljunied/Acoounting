<?php


namespace App\Repository\StoreInventury;

use App\Models\StoreProduct;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\Services\CoreService;

class StorePurchaseReturnRepository extends StoreRepository implements StoreRepositoryInterface
{

  public $total;

  public function __construct(CoreService $core)
  {

    $this->core = $core;
    $this->operation = 'decrement';
  }


  public function store()
  {


    $this->get_store_product_first();
    $this->check_founded_store();
  }




  public function check_founded_store()
  {


    if ($this->core->id_store_product == 0) {


      $this->init_store_product_table();
    } else {


      $this->refresh_store_product();
    }
  }



  public function refresh_store_product()
  {



    $this->refresh_qty_store_product_table();
    $this->refresh_total_store_product_table();
    $this->get_store_product_first();
    $this->refresh_cost_store_product_table();
  }



  // public function calc_return_total(){


  //   $this->core->data['total'][$this->core->value] = $this->core->micro_unit_qty * $this->core->data['old'][$this->core->value]['cost'];


  // }
  



}
