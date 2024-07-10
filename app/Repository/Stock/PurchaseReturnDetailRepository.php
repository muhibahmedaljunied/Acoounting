<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Purchase\PurchaseReturnTrait;
use App\Traits\Purchase\PurchaseTrait;
use App\Traits\Purchase\PurchaseDetailsTrait;
use App\Services\CoreService;

class PurchaseReturnDetailRepository implements DetailRepositoryInterface
{

    use PurchaseReturnTrait,PurchaseTrait,PurchaseDetailsTrait;

    public $core;
 
    public function __construct()
    {


        $this->core = app(CoreService::class);
      
    }

    public function details(...$list_data)
    {

        $this->refresh_qty_return_purchase_details();
        $this->add_into_purchase_return_details_table();

    }


}
