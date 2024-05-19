<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\Services\CoreService;
use App\Traits\Purchase\PurchaseTrait;
use DB;

class PurchaseReturnRefreshDetailRepository implements DetailRefreshRepositoryInterface
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
