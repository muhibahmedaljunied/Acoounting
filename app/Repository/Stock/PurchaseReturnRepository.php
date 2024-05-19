<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
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

    // public function init_details(...$list_data)
    // {

    //     $this->add_into_purchase_return_details_table();
    // }

    // public function refresh_details()
    // {


    //     $this->refresh_purchase_details_table();
    // }
}
