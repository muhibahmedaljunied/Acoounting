<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Purchase\PurchaseTrait;
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


        $this->add_into_purchase_table($this->core);
     

    }

    public function init_details(...$list_data)
    {

        $this->add_into_purchase_details_table($this->core);
  
    }

   

   
}
