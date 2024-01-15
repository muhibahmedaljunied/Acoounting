<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\Traits\Supply\SupplyReturnTrait;
use App\Services\CoreService;

use DB;

class SupplyReturnRepository implements DetailRepositoryInterface,DetailRefreshRepositoryInterface
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

    public function init_details(...$list_data)
    {

        $this->add_into_supply_return_details_table();
    }

    public function refresh_details()
    {


        $this->refresh_supply_details_table();
       
    

    }
}
