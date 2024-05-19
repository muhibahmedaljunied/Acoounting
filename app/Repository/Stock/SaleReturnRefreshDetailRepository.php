<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Traits\Sale\SaleReturnTrait;
use App\Services\CoreService;
use App\Traits\Sale\SaleTrait;
use DB;
class SaleReturnRefreshDetailRepository implements DetailRefreshRepositoryInterface
{

use SaleTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

        function refresh_details()
    {

        $this->refresh_sale_details_table();


    }

   

   
}
