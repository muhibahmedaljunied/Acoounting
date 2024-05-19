<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\Traits\Purchase\PurchaseReturnTrait;
use App\Services\CoreService;
use App\Traits\Purchase\PurchaseTrait;

class PurchaseRefreshDitailRepository implements DetailRefreshRepositoryInterface
{

use PurchaseTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

    


    public function refresh_details()
    {


        $this->refresh_purchase_details_table();
    }
   

   
}
