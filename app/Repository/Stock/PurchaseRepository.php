<?php

namespace App\Repository\Stock;
use App\Traits\Purchase\PurchaseTrait;
use App\Services\CoreService;
use App\RepositoryInterface\Daily;
use DB;

class PurchaseRepository
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


    public function init_details(...$list_data)
    {

        $this->add_into_purchase_details_table();
  
    }

   

   
}
