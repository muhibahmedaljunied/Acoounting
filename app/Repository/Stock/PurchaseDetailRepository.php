<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Purchase\PurchaseTrait;
use App\Services\CoreService;
class PurchaseDetailRepository implements DetailRepositoryInterface
{

use PurchaseTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }



    public function init_details(...$list_data)
    {

        $this->add_into_purchase_details_table();
  
    }

   

   
}
