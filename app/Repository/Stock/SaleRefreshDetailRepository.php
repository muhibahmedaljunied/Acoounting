<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\Services\CoreService;
use App\Traits\Sale\SaleTrait;

class SaleRefreshDetailRepository implements DetailRefreshRepositoryInterface
{

use SaleTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

    


    public function refresh_details()
    {


        $this->refresh_sale_details_table();
    }
   

   
}
