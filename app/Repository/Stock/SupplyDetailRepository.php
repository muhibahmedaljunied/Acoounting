<?php

namespace App\Repository\Stock;
use App\Traits\Supply\SupplyTrait;
use App\Services\CoreService;
use App\RepositoryInterface\Daily;
use App\RepositoryInterface\DetailRepositoryInterface;
use DB;

class SupplyDetailRepository implements DetailRepositoryInterface
{

use SupplyTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }



    public function init_details(...$list_data)
    {

        $this->add_into_supply_details_table();
  
    }

   

   
}
