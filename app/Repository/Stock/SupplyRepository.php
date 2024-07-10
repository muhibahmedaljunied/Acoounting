<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Traits\Supply\SupplyTrait;
use App\Services\CoreService;

class SupplyRepository implements WarehouseRepositoryInterface
{

use SupplyTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

    public function add()
    {


        $this->add_into_supply_table();
     

    }

    public function refresh()
    {


        $this->refresh_supply_table();
     

    }



   

   
}
