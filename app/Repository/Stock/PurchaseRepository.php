<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Traits\Purchase\PurchaseTrait;
use App\Services\CoreService;

class PurchaseRepository implements WarehouseRepositoryInterface
{

use PurchaseTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

    public function add()
    {


        $this->add_into_purchase_table();
     

    }

    public function refresh()
    {


        $this->refresh_purchase_table();
     

    }


 

   

   
}
