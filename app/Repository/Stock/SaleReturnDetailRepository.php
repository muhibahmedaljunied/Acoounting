<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Sale\SaleDetailsTrait;
use App\Traits\Sale\SaleReturnTrait;
use App\Traits\Sale\SaleTrait;
use App\Services\CoreService;
use DB;
class SaleReturnDetailRepository implements DetailRepositoryInterface
{

use SaleReturnTrait,SaleTrait,SaleDetailsTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

  

    public function details(...$list_data)
    {

        $this->refresh_qty_return_sale_details();
        $this->add_into_sale_return_details_table();


  
    }

 

   

   
}
