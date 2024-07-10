<?php

namespace App\Repository\Stock;
use App\Traits\Supply\SupplyDetailsTrait;
use App\Services\CoreService;
use App\RepositoryInterface\Daily;
use App\RepositoryInterface\DetailRepositoryInterface;
use DB;

class SupplyDetailRepository implements DetailRepositoryInterface
{

use SupplyDetailsTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }



    public function details(...$list_data)
    {

        $this->add_into_supply_details_table();
  
    }

   

   
}
