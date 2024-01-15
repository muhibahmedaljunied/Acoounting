<?php

namespace App\Repository\Stock;
use App\Traits\Supply\SupplyTrait;
use App\Services\CoreService;
use App\RepositoryInterface\Daily;
use DB;

class SupplyRepository
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


    public function init_details(...$list_data)
    {

        $this->add_into_supply_details_table();
  
    }

   

   
}
