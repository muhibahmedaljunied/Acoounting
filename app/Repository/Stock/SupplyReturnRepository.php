<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Traits\Supply\SupplyReturnTrait;
use App\Services\CoreService;

use DB;

class SupplyReturnRepository implements WarehouseRepositoryInterface
{

    use SupplyReturnTrait;

    public $core;
    public function __construct()
    {


        $this->core = app(CoreService::class);
    }



    public function add()
    {

      
        $this->add_into_supply_return_table();
    }

    public function refresh()
    {


        $this->refresh_supply_return_table();
     

    }

 
}
