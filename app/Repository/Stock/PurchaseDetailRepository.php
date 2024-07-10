<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Purchase\PurchaseDetailsTrait;
use App\Services\CoreService;
class PurchaseDetailRepository implements DetailRepositoryInterface
{

use PurchaseDetailsTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }



    public function details(...$list_data)
    {

        $this->add_into_purchase_details_table();
  
    }

   
 

   
}
