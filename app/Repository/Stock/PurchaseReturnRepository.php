<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Traits\Purchase\PurchaseReturnTrait;
use App\Services\CoreService;

use DB;

class PurchaseReturnRepository implements WarehouseRepositoryInterface
{

    use PurchaseReturnTrait;

    public $core;
    public function __construct()
    {


        $this->core = app(CoreService::class);
    }



    public function add()
    {


        $this->add_into_purchase_return_table();
    }

    public function refresh()
    {


        $this->refresh_purchase_return_table();
    }


}
